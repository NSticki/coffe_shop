<?php


namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\Integration\IikoService;
use Exception;
use Illuminate\Http\RedirectResponse;


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


    /**
     * Run method.
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function index()
    {

        ini_set('max_execution_time', 300);
        $this->api->saveStores();
        $this->api->storeNomenclature();

        return redirect()
            ->route('dashboard')
            ->with('message', 'Выгрузка закончена');
    }

    public function getMenu()
    {
        return $this->api->getNomenclature();
    }

    /**
     * IikoController constructor.
     */
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

