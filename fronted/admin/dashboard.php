<?php
session_start();

// 🚫 Redirect if not logged in
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: admin_login.php");
    exit;
}

// 📄 Load detection data from JSON file
$dataFile = "data.json";
$violations = [];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $violations = json_decode($json, true);
    if (!is_array($violations)) {
        $violations = [];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Traffic Violations</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #f0f0f0;
        }
        h1 {
            color: #333;
        }
        .logout {
            float: right;
            background: #e74c3c;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: white;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f9f9f9;
        }
    </style>
</head>
<body>

<a href="logout.php" class="logout">Logout</a>
<h1>🚦 Admin Dashboard</h1>

<?php if (count($violations) > 0): ?>
    <table>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Detected Classes</th>
            <th>Time</th>
        </tr>
        <?php foreach ($violations as $index => $entry): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><a href="../uploads/<?= htmlspecialchars($entry["image"]) ?>" target="_blank">View</a></td>
                <td><?= htmlspecialchars(implode(", ", $entry["classes"])) ?></td>
                <td><?= htmlspecialchars($entry["time"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No violation records found.</p>
<?php endif; ?>

</body>
</html>
