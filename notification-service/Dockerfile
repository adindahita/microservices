FROM php:8.2-cli

RUN apt-get update && apt-get install -y git unzip curl
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /app
COPY composer.json ./
RUN docker-php-ext-install sockets
RUN composer install
RUN composer require php-amqplib/php-amqplib
COPY . .

CMD ["php", "index.php"]
