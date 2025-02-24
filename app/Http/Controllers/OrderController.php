<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $orders = Order::where('user_id', Auth::id())->orderByDesc('created_at')->paginate(10);
        if(isset($search)){
            $orders = Order::where('user_id', Auth::id())
            ->where('reference', 'LIKE', '%'.$search.'%')
            ->orderByDesc('created_at')
            ->paginate(10);
        }
        return inertia('OrdersPage', [
            'orders' => $orders
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $order = Order::with('order_items.product')->with('payment')->with('tracking')->with('address')
            ->findOrFail($id);

            return inertia('ShowOrderPage', [
                'order' => $order
            ]);
        }catch(Exception $e){
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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
        //
    }
}
