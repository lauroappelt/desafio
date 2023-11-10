FROM php:8.2-fpm

ARG user=lauro
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

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#pgsql dependency
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy custom configurations PHP
COPY docker/php/xdebug.ini "${PHP_INI_DIR}/conf.d"

#RUN chown -R www-data:www-data /var/www
USER $user