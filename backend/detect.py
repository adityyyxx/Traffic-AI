from flask import Flask, request
from flask_cors import CORS
from ultralytics import YOLO
import os

app = Flask(__name__)
CORS(app)

UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

# 🧠 Load your trained YOLO model (replace with your model path or use yolov8n.pt for testing)
MODEL_PATH = "yolov8n.pt"  # Replace with your custom model if needed
model = YOLO(MODEL_PATH)

@app.route('/detect', methods=['POST'])
def detect():
    try:
        file = request.files.get('file')
        if not file:
            return "❗ No file provided in request.", 400

        filename = os.path.basename(file.filename)
        filepath = os.path.join(UPLOAD_FOLDER, filename)
        file.save(filepath)

        # 🔍 Perform detection using YOLOv8
        results = model(filepath)
        names = model.names

        detected_classes = set()
        for r in results:
            for box in r.boxes:
                cls_id = int(box.cls[0])
                detected_classes.add(names[cls_id])

        if detected_classes:
            return "✅ Detected objects:\n" + "\n".join(detected_classes)
        else:
            return "✅ No violations detected."

    except Exception as e:
        return f"❌ Internal Server Error: {e}", 500

if __name__ == '__main__':
    port = int(os.environ.get("PORT") or 8080)
    app.run(host='0.0.0.0', port=port, debug=False)
