FROM php:8.1-fpm

ARG user=DanielSystemDev&Motorez
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Instala as dependências necessárias e a extensão zip do PHP
RUN apt-get update \
    && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install xml pdo_mysql opcache mbstring zip exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
    
# Set working directory
WORKDIR /var/www/

USER $user


