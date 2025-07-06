FROM php:8.1-apache

# Install required packages
RUN apt-get update && \
    apt-get install -y python3 python3-pip supervisor && \
    docker-php-ext-install mysqli

# Copy PHP files
COPY ./frontend/ /var/www/html/

# Copy Python files
COPY ./backend/ /app

# Install Python dependencies
RUN pip3 install -r /app/requirements.txt

# Create uploads folder
RUN mkdir /var/www/html/uploads

# Copy supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80
CMD ["/usr/bin/supervisord"]
