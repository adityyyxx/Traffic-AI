<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

// Load detection data
$dataFile = 'data.json';
$violations = [];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $violations = json_decode($json, true) ?? [];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - Traffic AI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
    }
    .container {
      margin-top: 60px;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .table thead {
      background-color: #1a1a2e;
      color: white;
    }
    .btn-logout {
      background-color: #dc3545;
      border: none;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="header mb-4">
    <h2>🚦 Admin Dashboard</h2>
    <a href="logout.php" class="btn btn-sm btn-logout text-white">Logout</a>
  </div>

  <?php if (empty($violations)): ?>
    <div class="alert alert-warning">No violations recorded yet.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Filename</th>
            <th>Violations Detected</th>
            <th>Plate Numbers</th>
            <th>Timestamp</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($violations as $index => $v): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($v['filename']) ?></td>
              <td><?= implode(', ', $v['violations_detected']) ?></td>
              <td><?= implode(', ', $v['number_plate_text']) ?></td>
              <td><?= $v['timestamp'] ?? '-' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
