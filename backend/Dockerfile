FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    unzip \
    zip

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    pdo \
    pdo_mysql \
    curl \
    mbstring \
    zip \
    @composer

COPY . /var/www/api

COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisord.conf

WORKDIR /var/www/api

RUN composer install --no-dev --optimize-autoloader

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]