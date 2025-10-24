FROM php:8.2-cli

RUN apt-get update && apt-get install -y git unzip curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /app

# Copy composer.json dan install dependency
COPY composer.json ./
RUN docker-php-ext-install sockets
RUN composer install
RUN composer require php-amqplib/php-amqplib
# Copy source code
COPY . .

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "index.php"]
