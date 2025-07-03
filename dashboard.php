<?php
// Read data from JSON file
$dataFile = 'data.json';
$violations = [];

if (file_exists($dataFile)) {
    $jsonContent = file_get_contents($dataFile);
    $violations = json_decode($jsonContent, true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar {
      background-color: #343a40;
    }
    .navbar-brand, .nav-link {
      color: white !important;
    }
    .container {
      margin-top: 40px;
    }
    table {
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">🚔 Admin Dashboard</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="admin_login.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <h2 class="mb-4">📋 Traffic Violations Detected</h2>

    <?php if (!empty($violations)): ?>
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Filename</th>
            <th>Violation Type</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($violations as $index => $violation): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($violation['filename']) ?></td>
              <td><?= htmlspecialchars($violation['violation']) ?></td>
              <td><?= htmlspecialchars($violation['date']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-warning">No violations recorded yet.</div>
    <?php endif; ?>
  </div>
</body>
</html>
