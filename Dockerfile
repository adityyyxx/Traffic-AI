# Use PHP + Apache as base
FROM php:8.1-apache

# Install Python, pip, and Supervisor
RUN apt-get update && \
    apt-get install -y python3 python3-pip supervisor && \
    docker-php-ext-install mysqli

# Copy PHP frontend files (fix path if needed)
COPY ./fronted/ /var/www/html/

# Copy backend (Flask) app
COPY ./backend/ /app

# Install Python dependencies (with system packages bypass)
RUN pip3 install --break-system-packages -r /app/requirements.txt

# Create uploads folder inside public dir
RUN mkdir -p /var/www/html/uploads

# Copy Supervisor configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose web port
EXPOSE 80

# Run both PHP (Apache) and Flask via Supervisor
CMD ["/usr/bin/supervisord"]
