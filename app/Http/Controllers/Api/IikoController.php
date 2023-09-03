<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\Integration\IikoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IikoController extends Controller
{
    /**
     * Auth parameters.
     *
     * @var array
     */
    private $auth = array();

    /**
     * IikoService Object with token.
     *
     * @var IikoService $api
     */
    private $api;


    public function orderStatus(Request $request)
    {
        if (!empty($request->get('guid'))) {

            return response(array(
                "status" => "OK",
                "order_info" => $this->api->orderStatus($request->get('guid')),
            ), 200);

        }

        return response(array(
            "status" => "error",
            "message" => "Empty order guid.",
        ), 400);

    }

    public function createOrder(Request $request)
    {
        if (!empty($request['order'])) {
            return $this->api->createOrder($request);
        }
        return response(array(
            "status" => "error",
            "message" => "Empty order.",
        ), 400);
    }

    public function getBonuses(Request $request)
    {
        if (!empty($request->get('phone'))) {
            return $this->api->customerInfo($request->get('phone'));
        }
        return response(array(
            "status" => "error",
            "message" => "Empty phone.",
        ), 400);
    }

    public function getPaymentTypes(Request $request)
    {
        if (!empty($request)) {
            return $this->api->getPaymentTypes();
        }
        return response(array(
            "status" => "error",
            "message" => "Empty payments types.",
        ), 400);
    }

    public function __construct()
    {
        $settings = Setting::where('key', 'iiko_key')->orWhere('key', 'iiko_login')->get();
        foreach ($settings as $setting) {
            $this->auth[$setting['key']] = $setting['value'];
        }

        $this->connect();
    }

    /**
     * Method to register IikoService Object.
     *
     * @return void
     */
    public function connect()
    {
        $this->api = new IikoService($this->auth['iiko_login'], $this->auth['iiko_key']);
    }
}
