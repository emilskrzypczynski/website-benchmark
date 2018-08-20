FROM php:7.2-fpm

RUN apt-get update

RUN apt-get install -y \
    curl \
    libicu-dev \
    libmcrypt-dev \
    libxml2-dev \
    zlib1g-dev \
    libpq-dev \
    git \
    libxml2-dev

RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
        intl \
        pdo pdo_mysql \
        zip xml \
        opcache \
    && docker-php-ext-enable \
        opcache

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Warsaw /etc/localtime
RUN "date"

WORKDIR /var/www/symfony