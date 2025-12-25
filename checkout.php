<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - KiariHive</title>
<link rel="stylesheet" href="resources/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">🐝 KiariHive</a>
  </div>
</nav>

<div class="container mt-5 pt-5">
<h2>Checkout</h2>
<div class="row">
    <div class="col-md-6">
        <h4>Order Summary</h4>
        <ul class="list-group mb-3" id="checkout-cart-items"></ul>
        <h5>Total: KES <span id="checkout-total">0</span></h5>
    </div>
    <div class="col-md-6">
        <h4>Delivery Information</h4>
        <form id="checkoutForm">
            <input class="form-control mb-2" placeholder="Full Name" name="name" required>
            <input class="form-control mb-2" placeholder="Email" name="email" type="email" required>
            <textarea class="form-control mb-2" placeholder="Delivery Address" name="address" required></textarea>
            <button class="btn btn-honey w-100">Place Order</button>
        </form>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="resources/js/checkout.js"></script>
</body>
</html>
