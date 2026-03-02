FROM php:8.5.3-fpm-bookworm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php \
    && php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY php.ini "$PHP_INI_DIR/php.ini"

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions pdo_pgsql

EXPOSE 9000