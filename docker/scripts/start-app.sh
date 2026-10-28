#!/bin/sh
set -e

echo "[start-app] Preparando diretórios de sessão e permissões..."
mkdir -p /tmp/sessions
chmod -R 777 /tmp/sessions

if [ ! -f /var/www/html/.env ] && [ -f /var/www/html/.env.example ]; then
    echo "[start-app] Criando arquivo .env a partir do .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

echo "[start-app] Iniciando PHP-FPM..."
exec php-fpm -F
