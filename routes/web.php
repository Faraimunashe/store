<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);
Route::resource('/login', LoginController::class);
Route::resource('/register', RegisterController::class);


Route::resource('/shop', ShopController::class);
Route::resource('/cart', CartController::class);
//Route::resource('/checkout', CheckoutController::class);
