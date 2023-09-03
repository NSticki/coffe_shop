<?php

namespace App\Services\Integration;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_options;
use App\Models\Order_products;
use App\Models\Setting;
use App\Models\Store;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class IikoService
{
    /**
     *  The login value form settings.
     *
     * @var string $login
     */
    protected $login;

    /**
     *  The api-key value form settings.
     *
     * @var string $apiKey
     */
    protected $apiKey;

    /**
     *  Api token for connect.
     *  Get by getToken method.
     *
     * @var string $token
     */
    protected $token;

    /**
     * List of urls for API.
     *
     * @var array $urlList
     */
    protected $urlList = array(
        'access_token' => 'https://api-ru.iiko.services/api/1/access_token',
        'organizations' => 'https://api-ru.iiko.services/api/1/organizations',
        'nomenclature' => 'https://api-ru.iiko.services/api/1/nomenclature',
        'stores' => 'https://api-ru.iiko.services/api/1/terminal_groups',
        'createOrder' => 'https://api-ru.iiko.services/api/1/deliveries/create',
        'paymentTypes' => 'https://api-ru.iiko.services/api/1/payment_types',
        "orderTypes" => "https://api-ru.iiko.services/api/1/deliveries/order_types",
        "orderStatus" => "https://api-ru.iiko.services/api/1/deliveries/by_id",
        "customerInfo" => "https://api-ru.iiko.services/api/1/loyalty/iiko/get_customer",
        "bonuses" => "https://api-ru.iiko.services/api/1/bonuses",
    );

    /**
     * Organization id form API.
     *
     * @var string $organization_id
     */
    protected $organization_id;

    /**
     * IikoService constructor.
     * Get token and organization id from API.
     *
     * @param string $login
     * @param string $apiKey
     */

    public function __construct(string $login, string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->login =  $login;
        $this->getToken();
        $this->getOrganization();
    }

    public function check()
    {
        return array($this->login, $this->apiKey, $this->token, $this->organization_id);
    }


    /**
     * Method for getting API Token.
     */
    public function getToken()
    {
        $body = ['apiLogin' => $this->apiKey];
        $response = $this->curlPost($this->urlList['access_token'], $body);
        $this->token = $response['token'];
    }

    /**
     *  Method for getting organization id from API.
     */
    public function getOrganization()
    {
        $headers = array('Authorization: Bearer ' . $this->token);
        $body = [
            'organizationIds' => null,
            'returnAdditionalInfo' => true,
            'includeDisabled' => true,
        ];
        $response = $this->curlPost($this->urlList['organizations'], $body, $headers);
        $this->organization_id = $response['organizations'][0]['id'];

    }

    /**
     * Method for getting category and product lists from API.
     *
     * @return mixed
     */
    public function getNomenclature()
    {
        $headers = array('Authorization: Bearer ' . $this->token);
        $body = ['organizationId' => $this->organization_id];
        $response = $this->curlPost($this->urlList['nomenclature'], $body, $headers);

        return $response;
    }

    public function orderStatus($order_id)
    {
        $headers = array('Authorization: Bearer ' . $this->token);
        $body = ['organizationId' => $this->organization_id,
            "orderIds" => [
                $order_id,
            ]
        ];
        $response = $this->curlPost($this->urlList['orderStatus'], $body, $headers);
        return $response;
    }


    /**
     * Method to get payment types
     *
     * @return mixed
     */
    public function getPaymentTypes()
    {
        $headers = array('Authorization: Bearer ' . $this->token);
        $body = [
            'organizationIds' => [$this->organization_id]
        ];
        $response = $this->curlPost($this->urlList['paymentTypes'], $body, $headers);

        return $response;
    }

    public function getOrderTypes()
    {
        $headers = array('Authorization: Bearer ' . $this->token);
        $body = ['organizationIds' => [$this->organization_id]];
        $response = $this->curlPost($this->urlList['orderTypes'], $body, $headers);

        return $response;
    }

    /**
     * Method to create Iiko order.
     *
     * @return mixed
     */
    public function createOrder($orderId)
    {
        $order = Order::where("id", $orderId)->first();
        $terminal = json_decode($order["terminal_guid"], true)[0];

        if(empty($order))
        {
            Log::channel("iiko")->info("[ERROR]  --> Order №" . $orderId . " not found");
            return false;
        }

        $products = Order_products::where("order_id", $orderId)->get()->toArray();

        $order_items = array();

        foreach ($products as $item) {
            $options = Order_options::where('order_id', $order->id)->where('product_guid', $item['product_guid'])->get()->toArray();

            $item['name_product'];
            $item['price_product'];

            $products = $item;
            $products['amount'] = $item['amount'];
            $products['modifiers'] = $options;
            $order_items[] = $products;
        }

        /*Изменить передачу данных (бонусы и наличка)*/
        $payments = array();
        $payments[] = [
            "paymentTypeKind" => "Cash",
            "sum" => $order["total_sum"],
            "paymentTypeId" => "09322f46-578a-d210-add7-eec222a08871",
        ];

        /* TODO: iiko bonus  */

        $items = array();
        foreach($order_items as $item)
        {
            $new_item = array(
                "amount" => $item["amount"],
                "name" => $item["name_product"],
                "price" => $item["price_product"],
                "productId" => $item["product_guid"],
                "type" => "Product"
            );

            foreach($item["modifiers"] as $modifier)
            {
                $new_item["modifiers"][] = array(
                    "amount" => $modifier["amount"],
                    "name" => $modifier["name_options"],
                    "productId" => $modifier["option_guid"]
                );
            }

            $items[] = $new_item;
        }

        $body = [
            "organizationId" => $this->organization_id,
            "terminalGroupId" => $terminal["guid"],
            "createOrderSettings" => [
                "mode" => "Async",
            ],
            "order" => [
                "items" => $items,
                "payments" => $payments,
                "orderTypeId" => "d2317131-439d-4067-91d8-9750cd4ae795",
                "phone" => "+" . $order['telephone'],
                "comment" => "",
                "customer" => [
                    "name" => $order['firstname'],
                    "surname" => null,
                    "comment" => null,
                    "email" => null,
                    "gender" => "NotSpecified"
                ],
            ],
        ];

        $headers = array('Authorization: Bearer ' . $this->token);
        $iikoResponse = $this->curlPost($this->urlList['createOrder'], $body, $headers);

        if (!empty($iikoResponse['errorDescription'])) {
            Log::channel('iiko')->info("[ERROR]  -->" . $iikoResponse['errorDescription'] . PHP_EOL . json_encode($body));
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


    /**
     * Method to get customer information from iiko.
     *
     * @param $phone
     * @return Application|ResponseFactory|Response|mixed
     */
    public function customerInfo($phone)
    {
        if ($this->validatePhone($phone)) {
            $headers = array('Authorization: Bearer ' . $this->token);
            $body = [
                'organizationId' => $this->organization_id,
                "type" => "phone",
                "phone" => $phone,
            ];
            $response = $this->curlPost($this->urlList['customerInfo'], $body, $headers);

            return $response;
        }

        return response(array(
            "status" => "error",
            "message" => "Incorrect phone."
        ), 400);
    }

    /**
     * Do store catalog.
     *
     * @throws Exception
     */
    public function storeNomenclature()
    {
        $nomenclature = $this->getNomenclature();
        $store = new IikoCatalog();
        $store->store($nomenclature);
    }

    /**
     * Get stores list from iiko.
     *
     * @return mixed
     */
    public function getStores()
    {
        $headers = array('Authorization: Bearer ' . $this->token);
        $body = ['organizationIds' => [$this->organization_id]];
        return $this->curlPost($this->urlList['stores'], $body, $headers);
    }

    /**
     * Save stores
     *
     * @return void
     */
    public function saveStores()
    {
        $data = $this->getStores();
        $store = new IikoStores();
        $store->save($data);
    }

    /**
     *  Method to build cUrl request.
     *
     * @param string $url
     * @param array|null $body
     * @param array|null $addHeaders
     * @return mixed
     */
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

    /**
     * Check and prepare phone number.
     *
     * @param $phone
     * @return false|string
     */
    public function validatePhone($phone)
    {
        $prepared = preg_replace('/\D/', '', $phone);
        if (strlen($prepared) === 11) {
            return $prepared;
        }
        return false;
    }

}
