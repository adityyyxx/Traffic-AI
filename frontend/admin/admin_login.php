<?php
session_start();

// Step 1: Set login credentials
$admin_user = 'admin';
$admin_pass = 'admin123';

// Step 2: Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php"); // redirect to dashboard
        exit;
    } else {
        $error = "❌ Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Login - Traffic AI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #1e1e2f;
      color: white;
    }
    .login-box {
      max-width: 400px;
      margin: 100px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      color: #333;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }
    .login-box h2 {
      text-align: center;
      margin-bottom: 25px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>🔐 Admin Login</h2>
  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="post" action="">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="text-center">
      <button class="btn btn-primary w-100">Login</button>
    </div>
  </form>
</div>

</body>
</html>
