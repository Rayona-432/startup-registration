<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
</head>
<body>
    <h2>Payment Successful</h2>
    <p>Payment ID: {{ $payment['id'] }}</p>
    <p>Order ID: {{ $payment['order_id'] }}</p>
    <p>Amount: ₹{{ $payment['amount'] / 100 }}</p>
    <p>Status: {{ $payment['status'] }}</p>
</body>
</html>
