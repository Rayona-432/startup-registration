<!DOCTYPE html>
<html>
<head>
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h2>Complete your Payment</h2>

    <button id="payBtn">Pay ₹499</button>

    <script>
        var options = {
            "key": "{{ $razorpayKey }}", // Enter the Key ID generated from the Dashboard
            "amount": "{{ $amount }}", // Amount is in currency subunits. Default currency is INR. Hence, 49900 = 499.00 INR
            "currency": "{{ $currency }}",
            "name": "Your Company/Startup",
            "description": "Registration Fee",
            "order_id": "{{ $order->id }}", //This is a sample Order ID. Pass the `id` obtained in the previous step
            "handler": function (response){
                alert("Payment Successful. Payment ID: " + response.razorpay_payment_id);
                // You can submit this payment id to your server for verification or redirect
                window.location.href = "/payment/success?payment_id=" + response.razorpay_payment_id + "&order_id=" + response.razorpay_order_id;
            },
            "prefill": {
                "email": "{{ $startup->email }}",
                "contact": "{{ $startup->phone }}"
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp1 = new Razorpay(options);

        document.getElementById('payBtn').onclick = function(e){
            rzp1.open();
            e.preventDefault();
        }
    </script>
</body>
</html>
