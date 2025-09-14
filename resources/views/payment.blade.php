<!DOCTYPE html>
<html>
<head>
    <title>SSLCommerz Payment</title>
</head>
<body>
    <h2>Make Payment</h2>
    <form method="POST" action="{{ route('pay') }}">
        @csrf
        <input type="text" name="name" placeholder="Customer Name" required><br>
        <input type="email" name="email" placeholder="Customer Email" required><br>
        <input type="text" name="phone" placeholder="Phone" required><br>
        <input type="number" name="amount" placeholder="Amount" value="100" required><br>
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
