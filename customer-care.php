<?php
session_start();
include 'includes/db.php';

$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Fetch admin user from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND role='admin'");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debug: uncomment to see what is fetched
    // var_dump($user, $password);

    // Check password (SHA2 256)
    if($user && hash('sha256', $password) === $user['password']){
        $_SESSION['admin'] = $user['username'];
        header("Location: admin/dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - KiariHive</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f5f5;
}
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.login-card {
    background: #fff;
    padding: 30px 25px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}
.login-card h2 {
    color: #1a237e; /* dark blue */
    font-weight: 700;
    margin-bottom: 25px;
    text-align: center;
}
.form-control {
    border-radius: 5px;
    padding: 10px 12px;
}
.btn-login {
    background-color: #1a237e; /* dark blue */
    color: #fff;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-login:hover {
    background-color: #3949ab;
    color: #fff;
}
.alert {
    border-radius: 5px;
    font-size: 0.9rem;
}
</style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <h2>KiariHive Admin Login</h2>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input class="form-control" type="text" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input class="form-control" type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>

        <div class="mt-3 text-center text-muted" style="font-size:0.9rem;">
            KiariHive Customer Care
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
