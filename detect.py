from flask import Flask, request
import requests
import os

app = Flask(__name__)
UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

# 🔐 Your Ultralytics API Key
API_KEY = "f454997160ead091409c1b30c32a229ca260105d9e"
API_URL = "https://api.ultralytics.com/v1/predict"

@app.route('/detect', methods=['POST'])
def detect():
    try:
        file = request.files['file']
        filename = os.path.basename(file.filename)
        filepath = os.path.join(UPLOAD_FOLDER, filename)
        file.save(filepath)

        with open(filepath, "rb") as f:
            files = {"image": f}
            headers = {"Authorization": f"Bearer {API_KEY}"}
            response = requests.post(API_URL, files=files, headers=headers)

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
                return f"❌ API Error: {data.get('message', 'Unknown error')}"
        else:
            return f"❌ HTTP Error: {response.status_code}"

    except Exception as e:
        return f"❌ Error: {e}"

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=int(os.environ.get("PORT", 5000)), debug=False)
