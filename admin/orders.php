<?php
session_start();
include '../includes/db.php';
if(!isset($_SESSION['admin'])){
    header("Location: ../customer-care.php");
    exit;
}

// Handle messages
$message = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Orders - KiariHive Admin</title>
<link rel="stylesheet" href="../resources/css/admin.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <div class="container-fluid">
                <button class="btn btn-primary" id="menu-toggle">☰</button>
                <span class="ms-auto fw-bold">Kiari Ltd</span>
            </div>
        </nav>

        <div class="container-fluid mt-4">
            <h2>Orders Management</h2>
            <?php if($message) echo "<div class='alert alert-success'>$message</div>"; ?>

            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Total (KES)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($orders as $order):
                ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td><?= htmlspecialchars($order['customer_email']) ?></td>
                        <td><?= htmlspecialchars($order['customer_address']) ?></td>
                        <td><?= number_format($order['total']) ?></td>
                        <td><?= ucfirst($order['status']) ?></td>
                        <td>
                            <?php if($order['status']=='pending'): ?>
                                <a href="process_order.php?id=<?= $order['id'] ?>&action=approve" class="btn btn-process btn-sm">Approve</a>
                                <a href="process_order.php?id=<?= $order['id'] ?>&action=cancel" class="btn btn-cancel btn-sm">Cancel</a>
                            <?php endif; ?>
                            <a href="process_order.php?id=<?= $order['id'] ?>&action=delete" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if(count($orders)==0) echo "<tr><td colspan='7' class='text-center'>No orders yet.</td></tr>"; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../resources/js/admin.js"></script>
</body>
</html>
