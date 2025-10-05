FROM php:8.1-apache

WORKDIR /var/www/html

# Copy all project files into the container
COPY . /var/www/html

# Optional: install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Railway sets a dynamic port via $PORT
ENV PORT=8080
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Expose the port to Railway
EXPOSE ${PORT}

# Start Apache
CMD ["apache2ctl", "-D", "FOREGROUND"]
