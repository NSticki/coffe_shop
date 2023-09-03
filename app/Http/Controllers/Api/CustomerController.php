<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Option;
use App\Models\Order;
use App\Models\Order_options;
use App\Models\Order_products;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    private const PHONE_LENGTH = 11;


    /**
     * Main method, run authentication.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function login(Request $request)
    {

        $rules = array(
            'phone' => 'required',
            'name' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(array(
                "status" => "error",
                "message" => "Validation failed.",
                "error_info" => $validator->errors(),
            ), 400);
        } else {
            $phone = $this->validatePhone($request->get('phone'));
            $name = $request->get('name');

            if (!empty($phone) && !empty($name)) {
                $attempt = $this->checkCustomer($phone);
                if (!empty($attempt)) {
                    $customer = $this->update($phone, $name);
                    return response(array(
                        "status" => "OK",
                        "message" => "Sign-in",
                        "token" => $customer['api_token'],
                    ), 200);
                } else {
                    $customer = $this->create($phone, $name);
                    return response(array(
                        "status" => "OK",
                        "message" => "Sign-up",
                        "token" => $customer['api_token'],
                    ), 200);
                }
            }
            return response(array(
                "status" => "error",
                "message" => "Validation failed.",
                "error_info" => [
                    "phone" => "Incorrect phone."
                ],
            ), 400);
        }
    }


    /**
     *  Update customer name and api token.
     *
     * @param $phone
     * @param $name
     * @return array
     */
    protected function update($phone, $name)
    {

        $insert = [
            'name' => $name,
            'api_token' => Str::random(60),
        ];

        Customer::where('phone', $phone)->update($insert);

        return $insert;
    }

    /**
     * Create new customer.
     *
     * @param $phone
     * @param $name
     * @return array
     */
    protected function create($phone, $name)
    {
        $insert = [
            'name' => $name,
            'phone' => $phone,
            'api_token' => Str::random(60),
        ];

        $customer = new Customer($insert);
        $customer->save();

        return $insert;
    }

    /**
     * Check if customer registered.
     *
     * @param $phone
     * @return mixed
     */
    protected function checkCustomer($phone)
    {
        $customer = Customer::where('phone', $phone)->get();

        if (!$customer->isEmpty()) {
            return $customer;
        }
        return false;
    }

    /**
     * Check and prepare phone number.
     *
     * @param $phone
     * @return false|string
     */
    public function validatePhone($phone)
    {
        $prepared = preg_replace('/\D/', '', $phone);
        if (strlen($prepared) === self::PHONE_LENGTH) {
            return $prepared;
        }
        return false;
    }

    /**
     * Method to login if there is valid token.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function auth(Request $request)
    {
        $phone = $this->validatePhone($request->get('phone'));
        $token = $request->get('api_token');

        if (!empty($phone) && !empty($token)) {
            $customer = Customer::where('phone', $phone)->get()->last();

            if ($customer['api_token'] === $token) {
                return response(array(
                    "status" => "OK",
                    "message" => "Auth completed.",
                    "token" => $customer['api_token'],
                ), 200);
            }
        }
        return response(array(
            "status" => "error",
            "message" => "Auth failed.",
        ), 400);

    }


    public function orderHistory($telephone)
    {
        /* В БД хранится телефон, начинающийся с 7 без + */

        $customer = Customer::query()->where('phone', '=', $telephone)->get()->toArray();

        $customer_id = $customer[0]['id'];

        $orders_list = array();
        $orders = Order::where('customer_id', $customer_id)->get()->toArray();

        foreach ($orders as $key => &$order) {
            $store_dump = json_decode($order['terminal_guid'], true);
            $store = gettype($store_dump) == 'array' ? array_shift($store_dump) : false;

            $order_items = Order_products::where('order_id', $order['id'])->get()->toArray();
            foreach ($order_items as $i => $item) {
                $order_options = Order_options::where('order_id', $order['id'])->where('product_guid', $item['product_guid'])->get()->toArray();

                $order_items[$i]['modifiers'] = $order_options;
            }

            unset($order['created_at']);
            $orders_list[$key] = $order;
            $orders_list[$key]['store'] = $store;
            $orders_list[$key]['date'] = null;
            $orders_list[$key]['time'] = null;
            $orders_list[$key]['date'] = Carbon::parse($orders_list[$key]['date'])->format('d.m.y');
            $orders_list[$key]['time'] = Carbon::parse($orders_list[$key]['time'])->format('m:s');
            $orders_list[$key]['items'] = $order_items;
        }


        // if (!empty($orders_list)) {
            return response(array(
                "status" => "OK",
                "message" => "Orders history complete.",
                "orders_list" => array_reverse($orders_list),
            ), 200);
        // }

        return response(array(
            "status" => "error",
            "message" => "Auth failed.",
        ), 400);
    }

    public function orderHistoryValid(Request $request)
    {
        return $this->orderHistory($request->get('phone'));
    }
}
