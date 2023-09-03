<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public const VALIDATION = [
        'email' => 'required|email',
        'name' => 'required',
        'message' => 'required'
    ];

    public const VALIDATION_MESSAGES = [
        'required' => 'Заполните поле',
        'email' => 'Введите корректный адрес E-mail'
    ];

    public function index()
    {
        return view('app.dashboard');
    }

    public function sendMail(Request $request)
    {
        $this->validate($request, self::VALIDATION, self::VALIDATION_MESSAGES);

        Mail::to(env('MAIL_TO_DEV'))->send(new \App\Mail\Feedback($request));

        return view('app.dashboard')->with('message', 'Bruh.');
    }
}
