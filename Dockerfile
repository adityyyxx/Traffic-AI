FROM python:3.10-slim

ENV DEBIAN_FRONTEND=noninteractive

# Install Apache + PHP
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php curl && \
    apt-get clean

# Set working directory
WORKDIR /app
COPY . /app

# Install Python packages
RUN pip install --no-cache-dir -r requirements.txt

# Link to Apache public folder
RUN ln -s /app /var/www/html

# Run both Apache and Flask
CMD service apache2 start && python3 detect.py
