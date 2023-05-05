<?php

use App\Classes\Cart\Cart;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\OrdersController;

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

Route::get('/', [PagesController::class, 'index'])->name('index');
Route::get('make-order', [PagesController::class, 'makeOrder']);

Route::get('cart/add/{id}', [CartController::class, 'addToCart']);
Route::get('cart/delete/{id}', [CartController::class, 'deleteFromCart']);
Route::get('cart/show', [CartController::class, 'getCart']);
Route::get('cart/empty', [CartController::class, 'emptyCart']);

Route::post('order/validate', [OrdersController::class, 'validateOrder']);
Route::get('order/makePayment/{type}', [OrdersController::class, 'makePayment']);
Route::get('order/success', [OrdersController::class, 'success']);

Route::get('refresh-csrf', function() {
    return csrf_token();
});
