# Use PHP + Apache as base
FROM php:8.1-apache

# Install Python, pip, wget, and Supervisor
RUN apt-get update && \
    apt-get install -y python3 python3-pip wget supervisor && \
    docker-php-ext-install mysqli

# ✅ Install required Python packages (first)
COPY ./backend/requirements.txt /app/requirements.txt
RUN pip3 install --break-system-packages -r /app/requirements.txt

# # ✅ Download YOLOv8n model (optional if not auto-downloading)
# RUN mkdir -p /root/.cache/ultralytics && \
#     wget https://github.com/ultralytics/assets/releases/download/v8.0.0/yolov8n.pt \
#     -O /root/.cache/ultralytics/yolov8n.pt

# ✅ Copy PHP frontend
COPY ./fronted/ /var/www/html/
RUN mkdir -p /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# ✅ Copy Python Flask backend
COPY ./backend/ /app

# ✅ Copy Supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose web port
EXPOSE 80

# Run both services
CMD ["/usr/bin/supervisord"]
