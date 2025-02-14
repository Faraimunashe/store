<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    protected $fillable = ['order_id', 'status', 'remarks', 'expected_delivery_date', 'expected_delivery_time'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
