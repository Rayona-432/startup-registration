<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
    'razorpay_payment_id',
    'razorpay_order_id',
    'status',
    'amount',
    'currency',
    'email',
    'contact',
    'startup_id',
    ];

    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }

}
