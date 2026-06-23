FROM node:22-alpine AS frontend-build

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci --no-audit

COPY resources/ resources/
COPY vite.config.js ./

RUN npm run build

FROM php:8.3-fpm-alpine

RUN apk update && apk add --no-cache \
    nginx \
    git \
    curl \
    zip \
    unzip \
    postgresql-dev \
    libzip-dev \
    icu-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        zip \
        intl \
    && docker-php-ext-configure intl \
    && rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN rm -f /etc/nginx/conf.d/* /etc/nginx/http.d/* /etc/nginx/default.conf 2>/dev/null || true
COPY _sinenko/docker/nginx/conf.d/default.conf /etc/nginx/http.d/default.conf
RUN mkdir -p /etc/nginx/sites-enabled

RUN mkdir -p /run/nginx

COPY . /var/www/html
COPY --from=frontend-build /app/public/build /var/www/html/public/build
# COPY _sinenko/docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini     # читай docker/php/php.ini

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/public

COPY _sinenko/docker/php/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

USER root

EXPOSE 80
CMD ["sh", "-c", "nginx && php-fpm -F"]
