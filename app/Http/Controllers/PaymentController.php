<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        $paymentId = $request->payment_id;
        $orderId = $request->order_id;

        // TODO: Verify payment via Razorpay API for security

        return "Payment successful! Payment ID: $paymentId, Order ID: $orderId";
    }
}
