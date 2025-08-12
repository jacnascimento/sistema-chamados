# PHP-FPM 8.2 (compatível com Laravel 10)
FROM php:8.2-fpm-alpine

# Variáveis úteis (ajuste se quiser)
ENV TZ=America/Sao_Paulo \
    PHP_MEMORY_LIMIT=512M \
    PHP_UPLOAD_MAX_FILESIZE=32M \
    PHP_POST_MAX_SIZE=32M

# Dependências de sistema
RUN apk add --no-cache \
    bash git curl tzdata \
    libzip-dev icu-dev \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    oniguruma-dev libxml2-dev

# Extensões PHP comuns pra Laravel
# - gd com freetype+jpeg
# - intl/zip/pdo_mysql/bcmath/exif/pcntl/opcache
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql bcmath exif pcntl intl zip gd opcache

# Timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Composer (do container oficial)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Arquivo ini local (opcional)
# Ex.: crie docker/php/local.ini com configurações extras
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Script de inicialização: garante pastas/permissões/caches/APP_KEY
COPY docker/php/init-perms.sh /usr/local/bin/init-perms.sh
RUN chmod +x /usr/local/bin/init-perms.sh

WORKDIR /var/www

# Entrada: roda o init e mantém php-fpm em foreground
ENTRYPOINT ["/usr/local/bin/init-perms.sh"]
CMD ["php-fpm", "-F"]
