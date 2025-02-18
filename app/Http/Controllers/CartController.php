<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cart = Cart::with('product.images')->where('user_id', Auth::id())->get();
        return inertia('CartPage', [
            'cart' => $cart
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $cartItem = Cart::where('user_id', Auth::id())
                            ->where('product_id', $request->product_id)
                            ->first();

            if ($cartItem) {
                $cartItem->increment('qty', $request->qty);
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'qty' => $request->qty,
                ]);
            }

            return back()->with('success', 'Added to cart successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $item = Cart::findOrFail($id);
            $item->delete();

            return back()->with('success', 'Item removed from cart successfully');
        }catch(Exception $e)
        {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
