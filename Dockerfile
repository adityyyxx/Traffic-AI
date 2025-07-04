# Base image with Python
FROM python:3.10-slim

ENV DEBIAN_FRONTEND=noninteractive

# Install PHP and Apache
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php curl && \
    apt-get clean

# Set working directory
WORKDIR /app

# Copy all project files
COPY . /app

# Install Python dependencies
RUN pip install --no-cache-dir -r requirements.txt

# Link PHP frontend to Apache
RUN ln -s /app/public /var/www/html

# Expose port (Render will override this)
EXPOSE 8080

# Start Apache and Flask API using a startup script
CMD service apache2 start && python3 app.py
