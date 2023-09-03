<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     *  Get list of stocks.
     */
    public function list()
    {
        return response(array(
            "status" => "OK",
            "special_list" => Stock::all()
        ), 200);
    }
}
