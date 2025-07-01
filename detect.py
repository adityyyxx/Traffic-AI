from flask import Flask, request
from ultralytics import YOLO
import os

app = Flask(__name__)
model = YOLO("yolov8n.pt")

@app.route('/detect', methods=['POST'])
def detect():
    try:
        file = request.files['file']
        
        # ✅ Clean the filename
        filename = os.path.basename(file.filename)

        # ✅ Use correct path (PHP already saved the file)
        filepath = os.path.join("uploads", filename)

        if not os.path.exists(filepath):
            return f"❌ File not found: {filepath}"

        print(f"[INFO] Processing: {filepath}")

        results = model(filepath)
        names = results[0].names
        classes = results[0].boxes.cls.tolist()
        detected = [names[int(cls)] for cls in classes]

        if detected:
            return f"✅ Detected objects:\n" + "\n".join(set(detected))
        else:
            return "✅ No violations detected."

    except Exception as e:
        return f"❌ Error: {e}"

if __name__ == '__main__':
    app.run(debug=True)
