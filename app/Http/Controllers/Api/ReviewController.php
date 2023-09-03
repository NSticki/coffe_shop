<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
	public function send(Request $request)
	{
		$rating = $request["rating"];
		$message = $request["message"];

		if(!empty($message))
		{
			$insert = array(
				"rating" => (!empty($rating) ? (int)$rating : 0),
				"text" => $message
			);

			$review = new Review($insert);
			$review->save();

			return response(array(
				"status" => "OK",
				"message" => "Review sent"
			), 200);
		} else {
			return response(array(
				"status" => "error",
				"message" => "Message is empty"
			), 400);
		}
	}
}