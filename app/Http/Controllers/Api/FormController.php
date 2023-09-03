<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormController extends Controller
{
	public function getReview(Request $request) {
		return response(array(
			"status" => "OK"
		), 200);
	}

	public function getFeedback(Request $request) {
		return response(array(
			"status" => "OK"
		), 200);
	}
}