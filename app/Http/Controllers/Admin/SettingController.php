<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\Sms;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    /**
     *  List of fields on settings page.
     */
    private const FIELDS = [
        'shop_name',
        'shop_email',
        'iiko_login',
        'iiko_pass',
        'iiko_key',
        'acquiring_login',
        'acquiring_pass',
    ];


    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data = array();
        $data['title'] = 'Настройки';


        $config = Setting::where('code', 'config')->get();

        foreach (self::FIELDS as $field) {
            $element = $config->filter(function ($element) use ($field) {
                return $element->key == $field;
            })->first();

            if ($element) {
                $data['settings'][$field] = $element->toArray()['value'];
            }
        }
        return view('app.settings', compact('data'));
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        $inputs = $request->except(['_token', '_method']);

        $data = array();
        foreach ($inputs as $key => $value) {
            $data[] = array(
                'code' => 'config',
                'key' => $key,
                'value' => $value,
            );
        }

        Setting::upsert($data, ['code', 'key'], ['value']);
        return redirect(route('settings'));
    }
}
