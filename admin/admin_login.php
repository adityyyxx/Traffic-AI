<?php
// Sample session check (optional)
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Traffic AI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8;
    }
    .navbar {
      background-color: #1a1a2e;
    }
    .navbar-brand, .nav-link {
      color: white !important;
    }
    .card {
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      border-radius: 1rem;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🚔 Admin Panel</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="traffic.html">🏠 Home</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">🚪 Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h3 class="mb-4">📊 Traffic Violation Records</h3>

  <!-- Sample Table -->
  <div class="card p-4">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Detected Violation</th>
          <th>Timestamp</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Sample data from a directory or DB (replace with DB query if needed)
        $folder = "uploads/";
        $files = scandir($folder);
        $i = 1;
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                echo "<tr>
                        <td>$i</td>
                        <td><img src='$folder$file' width='100'></td>
                        <td>Helmet Violation</td>
                        <td>" . date("d-m-Y H:i:s", filemtime($folder.$file)) . "</td>
                      </tr>";
                $i++;
            }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
