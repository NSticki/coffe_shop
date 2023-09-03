<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_options;
use App\Models\Order_products;
use App\Models\Setting;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
	public function createOrder(Request $request)
	{
		if(empty($request["order"]))
		{
			return response(array(
				"status" => "error",
				"message" => "Empty order.",
			), 400);
		}

		$orderId = $this->storeOrder($request);
		if(!$orderId)
		{
			return response(array(
				"status" => "error",
				"message" => "Order creation failed."
			), 400);
		}

		$host = request()->getSchemeAndHttpHost();

		$acquiring_login = Setting::query()->where('key', '=', 'acquiring_login')->get()->toArray();
		$acquiring_pass = Setting::query()->where('key', '=', 'acquiring_pass')->get()->toArray();

		$sberBody = [
			'orderNumber' => $orderId,
			'amount' => intval($request['order']['cash'] * 100),
			'currency' => '643',
			'language' => 'ru',
			'pageView' => 'MOBILE',
			'returnUrl' => $host . '/public/result.php',
			'dynamicCallbackUrl' => $host . '/api/payment/callback',
			'userName' => $acquiring_login[0]['value'],
			'password' => $acquiring_pass[0]['value'],
		];

		$response = $this->curlGet('https://3dsec.sberbank.ru/payment/rest/register.do', $sberBody);

		if(isset($response['formUrl'])) {
			$formUrl = $response['formUrl'];

			return response(array(
				"status" => "OK",
				"message" => "Data send.",
				"data" => [
					"orderId" => $orderId,
					"link" => $formUrl
				]
			), 200);
		} else {
			Log::channel("payment")->info("[ERROR]  -> " . json_encode($response));

			return response(array(
				"status" => "error",
				"message" => "Sberbank error.",
				"data" => [
					"orderId" => $orderId,
					"response" => $response
				]
			), 400);
		}
	}

	private function storeOrder($data)
	{
		$cash = $data['order']['cash'];
		$bonus = $data['order']['bonus'];
		$customer_id = Customer::where('phone', $data['order']['phone'])->pluck('id')->last();
		$terminal_guid = Store::query()->where('guid', $data['order']['terminalGroupId'])->get();

		$order = [
			"customer_id" => $customer_id,
			"firstname" => $data['order']['customer']['name'],
			//"lastname" => $data['order']['customer']['surname'],
			//"email" => $data['order']['customer']['email'],
			"telephone" => $data['order']['phone'],
			"terminal_guid" => $terminal_guid,
			"comment" => '',
			"total_sum" => $cash + $bonus,
			"created_at" => Carbon::now(),
			"cash" => $cash,
			"bonuses" => $bonus,
		];

		$new_order = new Order($order);
		if ($new_order->save()) {
			$order_id = $new_order->id;

			/* Order items */

			$order_items = array();
			$order_options = array();
			foreach ($data['order']['items'] as $item) {
				$order_items[] = [
					"order_id" => $order_id,
					"product_guid" => $item['productId'],
					"amount" => $item['amount'],
					"name_product" => $item['name'],
					"price_product" => $item['price'],
				];

				if (!empty($item['modifiers'])) {
					foreach ($item['modifiers'] as $modifier) {
						$order_options[] = [
							"order_id" => $order_id,
							"product_guid" => $item['productId'],
							"option_guid" => $modifier['productId'],
							"amount" => $modifier['amount'],
							"name_options" => $modifier['name']
						];
					}
				}
			}

			if (!empty($order_items)) {
				Order_products::insert($order_items);
			}

			if (!empty($order_options)) {
				Order_options::insert($order_options);
			}

			return $order_id;
		}
	}

	public function curlPost(string $url, array $body = null, array $addHeaders = null)
	{
		$headers = array('Content-Type: application/json');
		if (!empty($addHeaders)) {
			$headers = array_merge($headers, $addHeaders);
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = json_decode(curl_exec($ch), true);
		curl_close($ch);

		return $result;
	}

	public function curlGet($url, array $get = NULL, array $options = array())
	{
		$defaults = array(
			CURLOPT_URL => $url . (strpos($url, "?") === FALSE ? "?" : "") . http_build_query($get),
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_DNS_USE_GLOBAL_CACHE => false,
			CURLOPT_SSL_VERIFYHOST => 0, //unsafe, but the fastest solution for the error " SSL certificate problem, verify that the CA cert is OK"
			CURLOPT_SSL_VERIFYPEER => 0, //unsafe, but the fastest solution for the error " SSL certificate problem, verify that the CA cert is OK"
		);
		$ch = curl_init();
		curl_setopt_array($ch, ($options + $defaults));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


		if (!$result = json_decode(curl_exec($ch), true)) {
			trigger_error(curl_error($ch));
		}

		curl_close($ch);
		return $result;
	}
}