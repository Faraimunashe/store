<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = ['order_id', 'reference', 'amount', 'status', 'method'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
