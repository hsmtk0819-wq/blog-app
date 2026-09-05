# ---------- 1. PHP の部品（vendor）をそろえる ----------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction
COPY . .
RUN composer dump-autoload --no-dev --optimize

# ---------- 2. CSS / JS を組み立てる ----------
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci
COPY resources ./resources
COPY --from=vendor /app/vendor ./vendor
RUN mkdir -p storage/framework/views && npm run build

# ---------- 3. 本番用イメージ ----------
FROM dunglas/frankenphp:1-php8.4
RUN install-php-extensions pdo_pgsql opcache

# FrankenPHP のバイナリには cap_net_bind_service が付いており、
# 公開サーバーのサンドボックス環境では実行が拒否されることがある
# （Operation not permitted）。1024番未満を使わないので外しておく
RUN setcap -r /usr/local/bin/frankenphp

WORKDIR /app
COPY --from=vendor /app ./
COPY --from=assets /app/public/build ./public/build

RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker-start.sh /usr/local/bin/docker-start.sh
RUN chmod +x /usr/local/bin/docker-start.sh

ENTRYPOINT ["docker-start.sh"]