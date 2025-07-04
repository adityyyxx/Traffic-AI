from flask import Flask, request
import requests
import os

app = Flask(__name__)
UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

# 🔐 Ultralytics API Details
API_KEY = "f454997160ead091409c1b30c32a229ca260105d9e"
API_URL = "https://api.ultralytics.com/v1/predict"

# ✅ Home route (optional, prevents 404 at root URL)
@app.route('/')
def home():
    return "✅ Traffic Violation Detection Flask API is running. Use POST /detect to analyze images."

@app.route('/detect', methods=['POST'])
def detect():
    try:
        # Handle uploaded file
        file = request.files.get('file')
        if not file:
            return "❗ No file provided in request.", 400

        filename = os.path.basename(file.filename)
        filepath = os.path.join(UPLOAD_FOLDER, filename)
        file.save(filepath)

        # Send to Ultralytics API
        with open(filepath, "rb") as f:
            files = {"image": f}
            headers = {"Authorization": f"Bearer {API_KEY}"}
            response = requests.post(API_URL, files=files, headers=headers)

        # Handle API Response
        if response.status_code == 200:
            data = response.json()
            if data.get("success"):
                detections = data.get("data", {}).get("results", [])
                detected_classes = [obj["name"] for obj in detections]

                if detected_classes:
                    return "✅ Detected objects:\n" + "\n".join(set(detected_classes))
                else:
                    return "✅ No violations detected."
            else:
                return f"❌ Ultralytics API Error: {data.get('message', 'Unknown error')}", 500
        else:
            return f"❌ HTTP Error {response.status_code}: {response.text}", 500

    except Exception as e:
        return f"❌ Internal Server Error: {e}", 500

if __name__ == '__main__':
    # Railway expects port from $PORT
    app.run(host='0.0.0.0', port=int(os.environ.get("PORT", 8080)), debug=False)
