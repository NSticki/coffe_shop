<?php


namespace App\Http\Controllers\Api;

use App\Models\Setting;

class SettingController
{
    public function getDataAcquiring()
    {
        $acquiring_login = Setting::where('key', '=', 'acquiring_login')->get();
        $acquiring_pass = Setting::where('key', '=', 'acquiring_pass')->get();

        return response(array(
            "status" => "OK",
            "message" => "Acquiring data complete.",
            "data" => array(
                "acquiring_login" => $acquiring_login,
                "acquiring_pass" => $acquiring_pass,
            )
        ));
    }
}
