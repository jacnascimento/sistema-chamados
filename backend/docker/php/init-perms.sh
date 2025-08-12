#!/usr/bin/env sh
set -e

# Garante estrutura de pastas da storage e bootstrap/cache
mkdir -p storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache/data \
         bootstrap/cache

# Permissões tolerantes a bind mounts
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R ug+rwx storage bootstrap/cache || true

# Se artisan existir, roda rotinas úteis
if [ -f artisan ]; then
  php artisan optimize:clear || true

  # Gera APP_KEY se estiver ausente (evita 500 em fresh setup)
  if ! php -r "echo (getenv('APP_KEY') ? 1 : 0);" | grep -q 1; then
    php artisan key:generate || true
  fi
fi

# Segue para o processo principal
exec "$@"
