<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $fillable = ['order_id', 'fullname', 'email', 'address', 'city', 'state', 'zip', 'ecocash'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
