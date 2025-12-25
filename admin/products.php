<?php
session_start();
include '../includes/db.php';
if(!isset($_SESSION['admin'])){
    header("Location: ../customer-care.php");
    exit;
}

// Handle Add Product
if(isset($_POST['add_product'])){
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../images/$image");
    $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?,?,?,?)")
        ->execute([$name,$desc,$price,"images/$image"]);
    header("Location: products.php");
    exit;
}

// Handle Delete
if(isset($_GET['delete'])){
    $conn->prepare("DELETE FROM products WHERE id=?")->execute([$_GET['delete']]);
    header("Location: products.php");
    exit;
}

// Handle Update (Edit)
if(isset($_POST['update_product'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $conn->prepare("UPDATE products SET name=?, description=?, price=? WHERE id=?")
        ->execute([$name,$desc,$price,$id]);
    header("Location: products.php");
    exit;
}

// Fetch products
$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Products - KiariHive Admin</title>
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
            <a href="products.php" class="list-group-item list-group-item-action bg-dark-blue text-white active">Products</a>
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
            <h2>Products Management</h2>

            <!-- Add Product Form -->
            <form method="POST" enctype="multipart/form-data" class="mb-4">
                <div class="row g-2">
                    <div class="col-md-3"><input class="form-control" type="text" name="name" placeholder="Product Name" required></div>
                    <div class="col-md-3"><input class="form-control" type="text" name="description" placeholder="Description" required></div>
                    <div class="col-md-2"><input class="form-control" type="number" name="price" placeholder="Price" required></div>
                    <div class="col-md-2"><input class="form-control" type="file" name="image" required></div>
                    <div class="col-md-2"><button class="btn btn-success w-100" type="submit" name="add_product">Add Product</button></div>
                </div>
            </form>

            <!-- Product List Table -->
            <table class="table table-hover">
                <thead>
                    <tr><th>#</th><th>Name</th><th>Description</th><th>Price</th><th>Image</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach($products as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= htmlspecialchars($p['description']) ?></td>
                            <td><?= number_format($p['price']) ?></td>
                            <td><img src="../<?= $p['image'] ?>" style="height:50px;"></td>
                            <td>
                                <!-- Edit Button triggers modal -->
                                <button class="btn btn-process btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['id'] ?>">Edit</button>
                                <a href="products.php?delete=<?= $p['id'] ?>" class="btn btn-delete btn-sm" onclick="return confirm('Delete this product?');">Delete</a>

                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $p['id'] ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form method="POST">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel<?= $p['id'] ?>">Edit Product</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <div class="mb-2"><input class="form-control" type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>" required></div>
                                    <div class="mb-2"><input class="form-control" type="text" name="description" value="<?= htmlspecialchars($p['description']) ?>" required></div>
                                    <div class="mb-2"><input class="form-control" type="number" name="price" value="<?= $p['price'] ?>" required></div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="update_product" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                    <?php endforeach; ?>
                    <?php if(count($products)==0) echo "<tr><td colspan='6' class='text-center'>No products yet.</td></tr>"; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../resources/js/admin.js"></script>
</body>
</html>
