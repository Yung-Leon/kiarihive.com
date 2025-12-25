<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>KiariHive Honey</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="resources/css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">🐝 KiariHive</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="#testimonials">Reviews</a></li>
        <li class="nav-item"><a class="nav-link" href="customer-care.php">Customer Care</a></li>

        <!-- Cart Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle position-relative" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown">
            🛒 Cart <span id="cart-count" class="badge bg-warning text-dark">0</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="cartDropdown" style="min-width:300px;">
            <div id="cart-items-dropdown"></div>
            <div class="d-flex justify-content-between mt-2">
              <strong>Total:</strong>
              <span id="cart-total-dropdown">KES 0</span>
            </div>
            <button id="checkout-btn-dropdown" class="btn btn-honey w-100 mt-2">Checkout</button>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="hero text-center">
  <div class="container">
    <h1>Pure. Natural. Raw Honey.</h1>
    <p class="lead mt-3">Harvested from nature’s finest flowers — straight from the hive to your home.</p>
    <a href="#products" class="btn btn-honey btn-lg mt-4">Explore Our Honey</a>
  </div>
</section>

<!-- About -->
<section id="about">
  <div class="container">
    <h2 class="section-title">Why Choose KiariHive?</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <div class="feature-icon">🍯</div>
        <h5 class="mt-3">100% Raw Honey</h5>
        <p>No additives, no processing — just pure goodness.</p>
      </div>
      <div class="col-md-4 mb-4">
        <div class="feature-icon">🌿</div>
        <h5 class="mt-3">Organic & Natural</h5>
        <p>Sustainably sourced from trusted local beekeepers.</p>
      </div>
      <div class="col-md-4 mb-4">
        <div class="feature-icon">🚚</div>
        <h5 class="mt-3">Fast Delivery</h5>
        <p>Delivered fresh to your doorstep nationwide.</p>
      </div>
    </div>
  </div>
</section>

<!-- Products -->
<section id="products" class="bg-light">
  <div class="container">
    <h2 class="section-title">Our Best Sellers</h2>
    <div class="row g-4">

      <!-- Wildflower Honey -->
      <div class="col-md-4">
        <div class="card">
          <img src="images/wildflower.jpg" class="card-img-top" alt="Wildflower Honey">
          <div class="card-body text-center">
            <h5>Wildflower Honey</h5>
            <p class="text-muted">Pure Kenyan wildflower honey.</p>
            <strong>KES 1,200</strong><br>
            <button class="btn btn-honey mt-2" onclick='addToCart({id:1,name:"Wildflower Honey",price:1200})'>Add to Cart</button>
          </div>
        </div>
      </div>

      <!-- Forest Honey -->
      <div class="col-md-4">
        <div class="card">
          <img src="images/forest.jpg" class="card-img-top" alt="Forest Honey">
          <div class="card-body text-center">
            <h5>Forest Honey</h5>
            <p class="text-muted">Natural forest honey.</p>
            <strong>KES 1,500</strong><br>
            <button class="btn btn-honey mt-2" onclick='addToCart({id:2,name:"Forest Honey",price:1500})'>Add to Cart</button>
          </div>
        </div>
      </div>

      <!-- Acacia Honey -->
      <div class="col-md-4">
        <div class="card">
          <img src="images/acacia.jpg" class="card-img-top" alt="Acacia Honey">
          <div class="card-body text-center">
            <h5>Acacia Honey</h5>
            <p class="text-muted">Raw acacia honey.</p>
            <strong>KES 1,800</strong><br>
            <button class="btn btn-honey mt-2" onclick='addToCart({id:3,name:"Acacia Honey",price:1800})'>Add to Cart</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Testimonials -->
<section id="testimonials">
  <div class="container">
    <h2 class="section-title">What Our Customers Say</h2>
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="p-4 shadow-sm">
          ⭐⭐⭐⭐⭐  
          <p class="mt-2">“Best honey I’ve ever tasted. You can feel the quality!”</p>
          <strong>- Sarah K.</strong>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="p-4 shadow-sm">
          ⭐⭐⭐⭐⭐  
          <p class="mt-2">“Fast delivery and truly raw honey. Highly recommended.”</p>
          <strong>- James M.</strong>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Newsletter -->
<section class="newsletter text-center">
  <div class="container">
    <h3>Join Our Honey Lovers Club</h3>
    <p>Get special offers and health tips straight to your inbox.</p>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form id="newsletterForm">
          <div class="input-group">
            <input type="email" class="form-control" placeholder="Enter your email" required>
            <button class="btn btn-honey" type="submit">Subscribe</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center mt-5 py-4 bg-dark text-white">
  <div class="container">
    <p>© 2025 KiariHive. All Rights Reserved.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="resources/js/app.js"></script>
</body>
</html>
