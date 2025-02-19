<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::resource('/register', RegisterController::class);



Route::group(['middleware' => ['auth']], function () {
    Route::get('/authentication', [AuthenticationController::class, 'index'])->name('authentication');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('adminorders', \App\Http\Controllers\Admin\OrderController::class);
});


Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::resource('shop', ShopController::class);
    Route::resource('cart', CartController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('orders', OrderController::class);
});
