<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $fileTmpPath = $_FILES["file"]["tmp_name"];
    $fileName = basename($_FILES["file"]["name"]);

    $cfile = new CURLFile($fileTmpPath, $_FILES["file"]["type"], $fileName);

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "http://127.0.0.1:8080/detect", // 👈 Local Flask endpoint
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => ['file' => $cfile],
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        $result = "❌ CURL Error: $error";
    } else {
        $result = $response;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Traffic Violation Detection (PHP)</title>
</head>
<body>
    <h2>🚦 Upload Image to Detect Violations (PHP version)</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    <?php if (!empty($result)): ?>
        <div style="margin-top:20px; padding:10px; border:1px solid #ccc;">
            <strong>Result:</strong><br>
            <pre><?= htmlspecialchars($result) ?></pre>
        </div>
    <?php endif; ?>
</body>
</html>
