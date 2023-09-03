<?php

use App\Services\Sms\SMSRU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/sms', [App\Http\Controllers\Api\SmsController::class, 'register']);
Route::get('/sms/check', [App\Http\Controllers\Api\SmsController::class, 'check']);

Route::get('/catalog/getCategories', [\App\Http\Controllers\Api\CategoriesController::class, 'index']);
Route::get('/catalog/getProducts', [\App\Http\Controllers\Api\ProductsController::class, 'index']);
Route::get('/catalog/getProduct', [\App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get('/catalog/getStores', [\App\Http\Controllers\Api\StoresController::class, 'index']);

Route::get('/login', [\App\Http\Controllers\Api\CustomerController::class, 'login']);
Route::get('/auth', [\App\Http\Controllers\Api\CustomerController::class, 'auth']);

Route::get('/customer/getBonuses', [\App\Http\Controllers\Api\IikoController::class, 'getBonuses']);

Route::get('/order/status', [\App\Http\Controllers\Api\IikoController::class, 'orderStatus']);
Route::post('/order/get', [\App\Http\Controllers\Api\OrderController::class, 'createOrder']);
Route::get('/order/history/{customer_id}', [\App\Http\Controllers\Api\CustomerController::class, 'orderHistory']);
Route::get('/order/history', [\App\Http\Controllers\Api\CustomerController::class, 'orderHistoryValid']);

Route::get('/special/get', [\App\Http\Controllers\Api\StockController::class, 'list']);

Route::get('/info/page/{code}', [\App\Http\Controllers\Api\InformationController::class, 'informationPage']);
Route::get('/info/page', [\App\Http\Controllers\Api\InformationController::class, 'informationPageValid']);

Route::post('/review/send', [\App\Http\Controllers\Api\ReviewController::class, 'send']);
Route::post('/feedback/send', [\App\Http\Controllers\Api\FeedbackController::class, 'send']);

Route::get('/payment/callback', [\App\Http\Controllers\Api\PaymentController::class, 'processCallback']);
