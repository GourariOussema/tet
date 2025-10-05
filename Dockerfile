# Use the official PHP 8.1 image with Apache
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Copy all project files into the container
COPY . /var/www/html

# Install common PHP extensions (optional — add/remove as needed)
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Railway sets a dynamic port using $PORT
# We tell Apache to listen on that port instead of the default 80
ENV PORT=8080
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Expose the same port
EXPOSE ${PORT}

# Start Apache in the foreground
CMD ["apache2ctl", "-D", "FOREGROUND"]
