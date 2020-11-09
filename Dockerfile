FROM php:7.3-apache

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y --no-install-recommends \
    build-essential \
    curl \
    git \
    libpq-dev \
    libonig-dev \
    libpng-dev \
    libsodium-dev \
    libxml2-dev \
    libzip-dev \
    postgresql-client \
    unzip \
    zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install bcmath ctype gd mbstring opcache pdo pdo_pgsql pgsql zip

# Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer && \
    composer self-update

WORKDIR /var/www/html
