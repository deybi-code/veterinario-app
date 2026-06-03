# Usamos una imagen base que soporte versiones recientes de PHP
FROM php:8.5-apache

# Instalamos dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# Configuramos el servidor Apache
RUN a2enmod rewrite
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiamos el código
COPY . /var/www/html
WORKDIR /var/www/html

# Ajustamos permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Puerto
EXPOSE 80