<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'reference', 'status', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class);
    }

    public function tracking()
    {
        return $this->hasOne(OrderTracking::class);
    }

    public function address()
    {
        return $this->hasOne(OrderAddress::class);
    }
}
