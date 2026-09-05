#!/bin/sh
set -e

# Render は待ち受けポートを PORT で渡してくる（ローカルでは 8080）
export SERVER_NAME=":${PORT:-8080}"

# データベースに表を作る（04 でやった php artisan migrate と同じもの）
php artisan migrate --force

# 設定を読み込み済みの状態にしておくと、表示が速くなる
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan storage:link

exec frankenphp run --config /etc/frankenphp/Caddyfile --adapter caddyfile