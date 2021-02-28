FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip \
    unzip && \
    docker-php-ext-install pdo pdo_mysql && \
    pecl install apcu zip mongodb && \
    docker-php-ext-enable apcu zip mongodb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files
COPY . /var/www/
COPY docker/php /var/www

# Copy existing application directory permissions
RUN chown -R www-data:www-data /var/www

WORKDIR /var/www
USER www-data
