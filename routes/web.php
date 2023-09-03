<?php

use App\Http\Controllers\Api\CategoriesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (){
   return redirect()->route('dashboard');
});

Route::get('/test',[App\Http\Controllers\TestController::class, 'index']);

Route::group(['middleware' => 'admin','prefix' => 'admin'], function (){
    Route::post('/', [App\Http\Controllers\Admin\DashboardController::class, 'sendMail'])->name('sendMail');
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings',[App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings');
    Route::put('/settings',[App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories',\App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('stores',\App\Http\Controllers\Admin\StoreController::class);
    Route::resource('info',\App\Http\Controllers\Admin\InformationController::class);
    Route::resource('stocks',\App\Http\Controllers\Admin\StockController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::resource('users',\App\Http\Controllers\Admin\UserController::class);
    Route::get('/customers',[\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}',[\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::resource('options',\App\Http\Controllers\Admin\OptionCategoryController::class);
    Route::get('/iiko',[\App\Http\Controllers\Services\IikoController::class, 'index'])->name('iiko');
    Route::get('/iiko/menu', [\App\Http\Controllers\Services\IikoController::class, 'getMenu'])->name('iikoMenu');
    Route::get('/iiko/payment',[\App\Http\Controllers\Services\IikoController::class, 'payment']);
    Route::get('/reviews',[\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
});

Auth::routes();
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

