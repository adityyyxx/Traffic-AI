FROM php:8.2-apache

# Change Apache to listen on port 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

# Enable mod_rewrite (optional, only if you use .htaccess rewrites)
RUN a2enmod rewrite

# Copy frontend files to Apache web root
COPY . /var/www/html/

# Expose port 8080
EXPOSE 8080

# Start Apache in foreground
CMD ["apache2-foreground"]
