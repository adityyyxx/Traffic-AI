from flask import Flask, request
from ultralytics import YOLO
import os

app = Flask(__name__)

# 🔽 Load YOLOv8 model (make sure this file exists in your project root)
model = YOLO("yolov8n.pt")

UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

@app.route('/detect', methods=['POST'])
def detect():
    try:
        file = request.files['file']
        filename = os.path.basename(file.filename)
        filepath = os.path.join(UPLOAD_FOLDER, filename)

        # Save file in case not already saved by PHP (Railway use-case)
        file.save(filepath)

        print(f"[INFO] Detecting on: {filepath}")
        results = model(filepath)
        names = results[0].names
        classes = results[0].boxes.cls.tolist()
        detected = [names[int(cls)] for cls in classes]

        if detected:
            return "✅ Detected objects:\n" + "\n".join(set(detected))
        else:
            return "✅ No violations detected."

    except Exception as e:
        return f"❌ Error: {e}"

if __name__ == '__main__':
    # ✅ Required for Railway deployment (bind to all IPs)
    app.run(host='0.0.0.0', port=int(os.environ.get("PORT", 5000)), debug=False)
