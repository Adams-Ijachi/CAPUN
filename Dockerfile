FROM php:8.0-fpm

# Arguments defined in docker-compose.yml
ARG user 
ARG uid

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* 

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www


# Copy existing application directory contents
COPY ./src /var/www/html

# Copy .env.example to .env
COPY ./src/.env.example .env

# # RUN php artisan key:generate
# CMD php artisan key:generate


# Copy existing application directory permissions
COPY --chown=www:www ./src /var/www/html

# Change current user to www
USER www


