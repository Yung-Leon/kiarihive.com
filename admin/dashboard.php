<?php
session_start();
include '../includes/db.php';
if(!isset($_SESSION['admin'])){
    header("Location: ../customer-care.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KiariHive Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../resources/css/admin.css">
</head>

<body>
<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-dark-blue text-white" id="sidebar-wrapper">
        <div class="sidebar-heading py-4 px-3 text-center fs-4 fw-bold">KiariHive Admin</div>
        <div class="list-group list-group-flush">
            <a href="dashboard.php" class="list-group-item list-group-item-action bg-dark-blue text-white">Dashboard</a>
            <a href="orders.php" class="list-group-item list-group-item-action bg-dark-blue text-white">Orders</a>
            <a href="products.php" class="list-group-item list-group-item-action bg-dark-blue text-white">Products</a>
            <a href="report.php" class="list-group-item list-group-item-action bg-dark-blue text-white">Reports</a>
            <a href="logout.php" class="list-group-item list-group-item-action bg-dark-blue text-white">Logout</a>
            <a href="change_password.php" class="list-group-item list-group-item-action bg-dark-blue text-white">Change Password</a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <div class="container-fluid">
                <button class="btn btn-primary" id="menu-toggle">☰</button>
                <span class="ms-auto fw-bold">Kiari Ltd</span>
            </div>
        </nav>

        <div class="container-fluid mt-4">
            <h1 class="mb-4">Welcome, Loghan Kiari!</h1>
            <p class="lead">Use the sidebar to manage orders, products, and generate reports.</p>

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <h5>Total Orders</h5>
                        <?php
                        $totalOrders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
                        echo "<h2>$totalOrders</h2>";
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <h5>Total Products</h5>
                        <?php
                        $totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
                        echo "<h2>$totalProducts</h2>";
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <h5>Pending Orders</h5>
                        <?php
                        $pendingOrders = $conn->query("SELECT COUNT(*) FROM orders WHERE status='pending'")->fetchColumn();
                        echo "<h2>$pendingOrders</h2>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../resources/js/admin.js"></script>
</body>
</html>
