<?php

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

function order_total()
{
    $total = 0;
    $cart = Cart::with('product')->where('user_id', Auth::id())->get();
    foreach($cart as $item){
        $total = $total + ($item->product->price * $item->qty);
    }

    return $total;
}

function get_order_total()
{
    return Cart::with('product')
        ->where('user_id', Auth::id())
        ->get()
        ->sum(fn($item) => $item->product->price * $item->qty);
}

function generate_order_reference()
{
    return strtoupper(uniqid());
}


function get_cart()
{
    return Cart::with('product')->where('user_id', Auth::id())->get();
}

function clear_cart()
{
    Cart::where('user_id', Auth::id())->delete();
}

