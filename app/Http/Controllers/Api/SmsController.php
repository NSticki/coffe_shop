<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use App\Services\Sms\SMSRU;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class SmsController extends Controller
{


    private const PHONE_LENGTH = 11;


    /**
     * Register sms to base then send code.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function register(Request $request)
    {
        $phone = $this->validatePhone($request->get('phone'));

        if (!empty($phone)) {
            $code = $this->generateCode();

            $db = new Sms([
                'telephone' => $phone,
                'code' => $code,
                'created_at' => Carbon::now(),
            ]);

            $db->save();

            // Temporarily disabled
            $this->sendMessage($phone, $code);
            return response(array(
                "status" => "OK",
                "code" => $code,
                "message" => "Code has been send."
            ), 200);
        }

        return response(array(
            "status" => "error",
            "message" => "Incorrect or missing value [phone]."
        ), 400);
    }

    public function check(Request $request)
    {
        $phone = $this->validatePhone($request->get('phone'));
        $code = $request->get('code');

        if (!empty($phone) && !empty($code)) {
            $db = Sms::where('telephone',$phone)->get()->last();
            if ($code == $db['code']) {
                return response(array(
                    "status" => "OK",
                    "message" => "Code approved."
                ), 200);
            }

        }

        return response(array(
            "status" => "error",
            "message" => "Incorrect code."
        ), 400);
    }

    public function sendMessage($phone , $code)
    {
        $sms = new SMSRU("11B3BEA0-E540-4913-FDB2-9F315CC9ED50");
        $data = new stdClass();
        $data->to = $phone;
        $data->text = "Ваш код: $code";
        $message = $sms->send_one($data);

        if ($message->status == "OK") {
            Log::channel('sms')->info("[OK] Сообщение успешно отправлено на номер |$data->to| ID сообщения: $message->sms_id | Стоимость смс: $message->cost");
        } else {
            Log::channel('sms')->info("[OK] Сообщение не отправлено | Код ошибки: $message->status_code | Текст ошибки: $message->status_text");
        }
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
     * Generate sms code.
     *
     * @return false|string
     */
    public function generateCode()
    {
        return substr(str_shuffle("0123456789"), 0, 4);
    }
}
