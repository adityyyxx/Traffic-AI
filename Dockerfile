# Base image with Python and system packages
FROM python:3.10-slim

# Set environment variables to avoid interactive prompts during install
ENV DEBIAN_FRONTEND=noninteractive

# Install Apache, PHP, and required tools
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php curl && \
    apt-get clean

# Set working directory
WORKDIR /app

# Copy project files
COPY . /app

# Install Python dependencies
RUN pip install --no-cache-dir -r requirements.txt

# Link PHP app to Apache root
RUN ln -s /app/public /var/www/html

# Expose port (optional if using Render)
EXPOSE 8080

# Start both Apache and Flask using a script
CMD service apache2 start && python3 app.py
