```blade
@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h3>Complete Your Payment</h3>
    <p class="mb-4">Registration Fee: <strong>₹499</strong></p>

    <button id="rzp-button" class="btn btn-success px-4 py-2">Pay Now</button>

    <form action="{{ route('startups.verifyPayment') }}" method="POST" id="payment-success-form" class="d-none">
        @csrf
        <input type="hidden" name="startup_id" value="{{ $startup->id }}">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('rzp-button').onclick = function(e) {
    var options = {
        "key": "{{ $razorpay_key }}",
        "amount": "{{ $amount }}",
        "currency": "INR",
        "name": "{{ $startup->startup_name }}",
        "description": "Startup Registration Fee",
        "order_id": "{{ $order['id'] }}",
        "handler": function (response){
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('payment-success-form').submit();
        },
        "theme": {
            "color": "#0AB39C"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
}
</script>
@endsection
```
