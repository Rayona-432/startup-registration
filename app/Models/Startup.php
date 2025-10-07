<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    protected $fillable = [ 'startup_name','founder_name','email','phone','website','sector','pitch_deck_path', 'payment_status','razorpay_order_id','razorpay_payment_id','razorpay_signature','amount_paid' ];
}
