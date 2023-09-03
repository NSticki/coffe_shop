<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;

class StoresController extends Controller
{
	public function index(Store $store)
	{
		$res = Store::all();

		$result = array(
			"stores" => $res
		);

		return response()->json($result, 200);
	}
}
