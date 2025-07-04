# Base image
FROM python:3.10-slim

# Silence interactive prompts
ENV DEBIAN_FRONTEND=noninteractive

# Install Apache, PHP, and system tools
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php curl && \
    apt-get clean

# Set working directory
WORKDIR /app

# Copy project files
COPY . /app

# Install Python dependencies
RUN pip install --no-cache-dir -r requirements.txt

# Remove Apache warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Link public folder (if using it)
RUN ln -s /app/public /var/www/html || true

# Start both Apache (PHP) and Flask (detect.py)
CMD service apache2 start && python3 detect.py
