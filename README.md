The **Traffic Violation Detection System** is a locally hosted full-stack project that detects traffic violations (like no helmet) using **YOLOv8**. To run it locally, follow these steps:

**Add trafic viloation folder and it sub folders fronted and backend and perform these steps**

1. **Backend Setup**:
   open command prompt
   * Install the required packages using: `pip install ultralytics flask flask_cors`.
   * Make sure the YOLO model file (e.g., `yolov8n.pt`) is placed in the same folder.
   * 1. cd "C:\Users\HP\OneDrive\Desktop\traffic violation\backend"
   * 2. python detect.py
     3. The flask server will run

2. **Frontend Setup**:
    open another command prompt make sure backend command prompt is running..
    
   * 1. "C:\Users\HP\OneDrive\Desktop\traffic violation\fronted"
   * 2.  php -S localhost:8000.
   * Open your browser and go to `http://localhost:8000/traffic.html`.

Once both servers are running, you can upload an image or video from the frontend, and the backend will return detection results using the YOLO model.
