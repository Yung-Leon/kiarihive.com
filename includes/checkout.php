<?php
include 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $cart = json_decode($_POST['cart'], true);

    $total = 0;
    foreach($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, customer_address, total) VALUES (?,?,?,?)");
    $stmt->execute([$name, $email, $address, $total]);
    $order_id = $conn->lastInsertId();

    // Insert order items
    $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)");
    foreach($cart as $item) {
        $stmtItem->execute([$order_id, $item['id'], $item['qty'], $item['price']]);
    }

    echo "success";
}
?>
