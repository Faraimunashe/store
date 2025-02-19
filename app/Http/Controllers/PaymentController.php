<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Paynowlog;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cart = Cart::with('product.images')->where('user_id', Auth::id())->get();
        return inertia('CheckoutPage', [
            'cart' => $cart
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => ['required', 'string'],
            'email' => ['required', 'email'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'zip' => ['required', 'numeric'],
            'ecocash' => ['required', 'digits:10', 'starts_with:07']
        ]);

        //dd($request->all());
        try{

            $amount = get_order_total();
            $reference = generate_order_reference();

            DB::beginTransaction();
            $order = Order::create([
                'user_id' => Auth::id(),
                'reference' => $reference,
                'status' => 'PENDING',
                'amount' => $amount
            ]);

            $paid = $this->ecocash_payment($amount, $request->ecocash, $request->email, $order->id);
            if($paid){
                foreach(get_cart() as $item){
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product->id,
                        'unit_price' => $item->product->price,
                        'qty' => $item->qty,
                        'total_price' => $item->product->price * $item->qty
                    ]);
                }
                OrderAddress::create([
                    'order_id' => $order->id,
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                    'ecocash' => $request->ecocash
                ]);

                clear_cart();
                DB::commit();
                return back()->with('success', 'Order placed successfully');
            }else{
                DB::rollBack();
                return back()->withErrors(['error' => 'Error while processing payment']);
            }
        }catch(Exception $e)
        {
            DB::rollBack();
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
        //
    }

    function ecocash_payment($amount, $phone, $email, $order_id){


        $wallet = "ecocash";

        if (strpos($phone, '071') === 0) {
            $wallet = "onemoney";
        }

        $paynow = new \Paynow\Payments\Paynow(
            "11336",
            env('PAYNOW'),
            route('payments.store'),
            route('payments.store'),
        );

        // Create Payments
        $invoice_name = "TECHSIGHTSOLUTIONS" . time();
        $payment = $paynow->createPayment($invoice_name, $email);

        $payment->add("TECHSIGHT SOLUTIONS", $amount);

        $response = $paynow->sendMobile($payment, $phone, $wallet);
        //dd($response);
        // Check transaction success
        if ($response->success()) {

            $timeout = 9;
            $count = 0;

            while (true) {
                sleep(3);
                // Get the status of the transaction
                // Get transaction poll URL
                $pollUrl = $response->pollUrl();
                $status = $paynow->pollTransaction($pollUrl);


                //Check if paid
                if ($status->paid()) {
                    // Yay! Transaction was paid for
                    // You can update transaction status here
                    // Then route to a payment successful
                    $info = $status->data();

                    $paynowdb = new Paynowlog();
                    $paynowdb->reference = $info['reference'];
                    $paynowdb->paynow_reference = $info['paynowreference'];
                    $paynowdb->amount = $info['amount'];
                    $paynowdb->status = $info['status'];
                    $paynowdb->poll_url = $info['pollurl'];
                    $paynowdb->hash = $info['hash'];
                    $paynowdb->save();

                    //transaction update
                    $order_payment = new OrderPayment();
                    $order_payment->order_id = $order_id;
                    $order_payment->reference = $info['paynowreference'];
                    $order_payment->method = "ECOCASH";
                    $order_payment->amount = $info['amount'];
                    $order_payment->status = 'SUCCESSFUL';
                    $order_payment->save();

                    return true;
                }


                $count++;
                if ($count > $timeout) {
                    $info = $status->data();

                    $paynowdb = new Paynowlog();
                    $paynowdb->reference = $info['reference'];
                    $paynowdb->paynow_reference = $info['paynowreference'];
                    $paynowdb->amount = $info['amount'];
                    $paynowdb->status = $info['status'];
                    $paynowdb->poll_url = $info['pollurl'];
                    $paynowdb->hash = $info['hash'];
                    $paynowdb->save();

                    $trans_status = 2;
                    if($info['status'] != 'sent')
                    {
                        $trans_status = 0;
                    }
                    $order_payment = new OrderPayment();
                    $order_payment->order_id = $order_id;
                    $order_payment->reference = $info['paynowreference'];
                    $order_payment->method = "ECOCASH";
                    $order_payment->amount = $info['amount'];
                    $order_payment->status = 'FAILED';
                    $order_payment->save();

                    return false;
                } //endif
            } //endwhile
        } //endif

        return false;
    }
}
