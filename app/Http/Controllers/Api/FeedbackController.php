<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{

	public function send(Request $request)
	{
		$message = $request["message"];

		if(!empty($message))
		{
			Mail::to(env('MAIL_TO_DEV'))->send(new \App\Mail\Feedback($request));

			return response(array(
				"status" => "OK",
				"message" => "Mail sent"
			), 200);
		} else {
			return response(array(
				"status" => "error",
				"message" => "Message is empty"
			), 400);
		}

		return false;
	}
}