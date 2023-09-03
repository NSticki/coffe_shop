<?php


namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;

class CallbackController
{
    public function callBackSber(Request $request)
    {
        if ($request['status'] == '0') {
            Order::query()->where('id', $request['orderNumber'])->update(['is_paid' => '1']);
        }
    }
}
