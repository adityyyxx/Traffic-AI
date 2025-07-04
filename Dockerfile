# Base image
FROM python:3.10-slim

# Install system dependencies
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php curl && \
    apt-get clean

# Copy Flask app
WORKDIR /app
COPY . /app
RUN pip install --no-cache-dir -r requirements.txt

# Enable Apache PHP
RUN a2enmod php7.4
RUN ln -s /app/public /var/www/html

# Start both services
CMD service apache2 start && python3 app.py
