<?php
// Simple test client to send a sample image to your Flask API
$apiUrl = "http://localhost:8080/detect"; // or your Render/Flask URL

// Path to test image
$imagePath = __DIR__ . "/test.jpg";  // Make sure test.jpg exists in the same folder

if (!file_exists($imagePath)) {
    die("❌ Test image not found!");
}

$cfile = new CURLFile($imagePath);
$postData = ['file' => $cfile];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "❌ CURL Error: " . curl_error($ch);
} else {
    echo "✅ Response from Flask:\n";
    echo $response;
}
curl_close($ch);
