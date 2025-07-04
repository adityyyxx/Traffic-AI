<?php
$result = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $fileTmp = $_FILES['image']['tmp_name'];
    $fileName = basename($_FILES['image']['name']);
    $uploadPath = 'uploads/' . $fileName;

    if (move_uploaded_file($fileTmp, $uploadPath)) {
        $apiUrl = 'http://127.0.0.1:5000/detect';  // Local Flask server

        $cfile = new CURLFile($uploadPath);
        $postData = ['file' => $cfile];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $result = "❌ cURL Error: " . curl_error($ch);
        } else {
            $result = $response;
        }

        curl_close($ch);
    } else {
        $result = "❌ Failed to move uploaded file.";
    }
} else {
    $result = "❗ No file uploaded.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detection Result</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
  <div class="container mt-5">
    <h3>📋 Detection Results:</h3>
    <div class="alert alert-info">
      <pre><?php echo htmlspecialchars($result); ?></pre>
    </div>
    <a href="traffic.html" class="btn btn-secondary">⬅️ Back to Upload</a>
  </div>
</body>
</html>
