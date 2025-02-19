<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTracking;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $orders = Order::with('user')->orderByDesc('created_at')->paginate(10);
        if(isset($search)){
            $orders = Order::with('user')
            ->where('reference', 'LIKE', '%'.$search.'%')
            ->orderByDesc('created_at')
            ->paginate(10);
        }
        return inertia('Admin/OrdersPage', [
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
        try{
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'carrier' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'remarks' => 'nullable|string',
                'expected_delivery_date' => 'required|date',
                'expected_delivery_time' => 'required',
            ]);

            $tracking = OrderTracking::updateOrCreate(
                ['order_id' => $validated['order_id']],
                $validated
            );

            return redirect()->back()->with('success', 'Tracking information saved successfully!');
        }catch(Exception $e)
        {
            return back()->withErrors(['error'=> $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $order = Order::with('user')->with('order_items.product')->with('payment')->with('tracking')->with('address')
            ->findOrFail($id);

            return inertia('Admin/ShowOrderPage', [
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
        try{
            $order = Order::findOrFail($id);

            return inertia('Admin/EditOrderPage', [
                'order' => $order
            ]);
        }catch(Exception $e){
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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
