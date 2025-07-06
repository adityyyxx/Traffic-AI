from flask import Flask, request
from ultralytics import YOLO
import os

app = Flask(__name__)
model = YOLO("yolov8n.pt")

UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

@app.route('/detect', methods=['POST'])
def detect():
    try:
        file = request.files['file']
        filename = os.path.basename(file.filename)
        filepath = os.path.join(UPLOAD_FOLDER, filename)

        file.save(filepath)
        print(f"[INFO] File saved: {filepath}")

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
    # ✅ Proper host/port setup for Render
    app.run(host="0.0.0.0", port=8080)
