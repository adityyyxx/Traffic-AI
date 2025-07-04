from flask import Flask, request
from ultralytics import YOLO
import os

app = Flask(__name__)

UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

@app.route('/detect', methods=['POST'])
def detect():
    try:
        file = request.files['file']
        filename = os.path.basename(file.filename)
        filepath = os.path.join(UPLOAD_FOLDER, filename)
        file.save(filepath)

        print(f"[INFO] Detecting on: {filepath}")

        # 🔽 Load model only when needed (saves memory!)
        model = YOLO("yolov8n")

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
    # ✅ Important for deployment platforms like Railway or Render
    app.run(host='0.0.0.0', port=int(os.environ.get("PORT", 5000)), debug=False)
