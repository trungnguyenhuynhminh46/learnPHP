FROM php:8.1-fpm

# Update ubuntu and download some commands
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    unzip \
    libicu-dev

# Download and install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-configure intl

# Install pdo_mysql
RUN docker-php-ext-install pdo_mysql intl

# Install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

# Work directory
WORKDIR /var/www
