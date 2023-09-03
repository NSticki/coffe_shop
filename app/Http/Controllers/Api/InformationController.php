<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Information;

class InformationController extends Controller
{
    public function informationPage($code)
    {
        $info = Information::where('code', $code)->get()->toArray();
        $data = [];
        foreach ($info as $field) {
            $data['title'] = $field['title'];
            $data['code'] = $field['code'];
            $data['content'] = $field['content'];
        }

        if (empty($code)) {
            return response(array(
                "status" => "error",
                "message" => "code empty",
            ), 400);
        }

        return response(array(
            "status" => "OK",
            "message" => "Data get",
            "data" => $data
        ), 200);
    }
}
