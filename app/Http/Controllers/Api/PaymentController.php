<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Services\Integration\IikoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
	private $auth = array();
	private $api;

	public function processCallback(Request $request)
	{
		$isPaid = $this->setOrderPaymentStatus($request);
		if($isPaid)
		{
			$this->api->createOrder($request->get("orderNumber")); // Send to iiko
		}

		return;
	}

	protected function setOrderPaymentStatus(Request $request)
	{
		if($request->get("status") == 0)
		{
			Log::channel("payment")->info("[ERROR]  --> " . json_encode($request));
			return false;
		}

		$orderId = $request->get("orderNumber");
		if(!$orderId) return;

		$order = Order::query()->where("id", "=", $orderId)->first();
		if(empty($order))
		{
			Log::channel("payment")->info("[ERROR]  --> Order №" . $orderId . " not found");
			return false;
		}

		if($order["is_paid"] == 1)
		{
			Log::channel("payment")->info("[ERROR]  -> Order №" . $orderId . " already payed");
			return false;
		}

		$operation = $request->get("operation");
		if(empty($operation))
		{
			Log::channel("payment")->info("[ERROR]  -> Payment operation is missing");
			return false;
		}
		elseif($operation == "deposited")
		{
			Order::where('id', $orderId)->update(array('is_paid' => 1));

			return true;
		}
	}

	public function __construct()
    {
        $settings = Setting::where('key', 'iiko_key')->orWhere('key', 'iiko_login')->get();
        foreach ($settings as $setting) {
            $this->auth[$setting['key']] = $setting['value'];
        }

        $this->connect();
    }

	public function connect()
    {
        $this->api = new IikoService($this->auth['iiko_login'], $this->auth['iiko_key']);
    }
}