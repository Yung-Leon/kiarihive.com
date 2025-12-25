<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../customer-care.php");
    exit;
}

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        $error = "New passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE username=? AND role='admin'");
        $stmt->execute([$_SESSION['admin']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($current, $user['password'])) {
            $error = "Current password is incorrect.";
        } else {
            $hashed = password_hash($new, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password=? WHERE username=? AND role='admin'");
            $update->execute([$hashed, $_SESSION['admin']]);
            $success = "Password updated successfully.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Change Password | KiariHive</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --honey:#f4b400;
  --dark-honey:#c49000;
  --dark:#1f1f1f;
}

body{
  background:#fff8e1;
  font-family:'Poppins',sans-serif;
}

.change-wrapper{
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
}

.card{
  width:100%;
  max-width:420px;
  border:none;
  border-radius:16px;
  padding:35px;
  box-shadow:0 15px 40px rgba(0,0,0,.1);
}

.brand{
  text-align:center;
  font-size:26px;
  font-weight:700;
  color:var(--honey);
  margin-bottom:5px;
}

.subtitle{
  text-align:center;
  color:#777;
  font-size:14px;
  margin-bottom:25px;
}

.form-control{
  border-radius:10px;
  padding:12px;
  font-size:14px;
}

.form-control:focus{
  border-color:var(--honey);
  box-shadow:0 0 0 .2rem rgba(244,180,0,.25);
}

.btn-honey{
  background:var(--honey);
  color:#fff;
  border:none;
  border-radius:10px;
  padding:12px;
  font-weight:600;
  transition:.3s;
}

.btn-honey:hover{
  background:var(--dark-honey);
}

.alert{
  border-radius:10px;
  font-size:14px;
}
</style>
</head>

<body>

<div class="change-wrapper">
  <div class="card">

    <div class="brand">🐝 KiariHive</div>
    <div class="subtitle">Secure Admin Password Update</div>

    <?php if($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if($success): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <input type="password" name="current_password" class="form-control" placeholder="Current Password" required>
      </div>

      <div class="mb-3">
        <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
      </div>

      <div class="mb-3">
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
      </div>

      <button class="btn btn-honey w-100">Update Password</button>
    </form>

  </div>
</div>

</body>
</html>
