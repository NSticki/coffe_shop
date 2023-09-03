<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
   public function index()
   {
       Storage::disk('images')->put('example.txt', 'Contents');
   }
}
