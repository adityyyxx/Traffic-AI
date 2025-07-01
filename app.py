from flask import Flask, request
from ultralytics import YOLO
import os

app = Flask(__name__)
model = YOLO("yolov8n.pt")

@app.route('/detect', methods=['POST'])
def detect():
    try:
        file = request.files['file']

        # ✅ Remove "uploads/" or any path from filename
        filename = os.path.basename(file.filename)
        filepath = os.path.join("uploads", filename)

        # ✅ Check if file was saved by PHP
        if not os.path.exists(filepath):
            return f"❌ File not found: {filepath}"

        print(f"[INFO] Using uploaded file: {filepath}")

        # Run detection
        results = model(filepath)
        names = results[0].names
        classes = results[0].boxes.cls.tolist()
        detected = [names[int(cls)] for cls in classes]

        if detected:
            detected_str = "\n".join(set(detected))
            return f"✅ Detected objects:\n{detected_str}"
        else:
            return "✅ No violations detected."
    except Exception as e:
        print("[ERROR]", e)
        return f"❌ Error: {e}"

if __name__ == '__main__':
    app.run(debug=True)
