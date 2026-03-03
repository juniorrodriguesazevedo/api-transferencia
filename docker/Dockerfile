FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    supervisor \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    bcmath \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

CMD ["/usr/bin/supervisord", "-n"]
