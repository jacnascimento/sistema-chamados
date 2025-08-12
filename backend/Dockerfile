FROM php:8.2-fpm

# Argumentos definidos no docker-compose.yml
ARG user=laravel
ARG uid=1000

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    supervisor \
    cron \
    wget

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Obter Composer mais recente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário do sistema para executar comandos Composer e Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Instalar Redis
RUN pecl install redis && docker-php-ext-enable redis

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar arquivos de configuração
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Criar diretório de logs e definir permissões
RUN mkdir -p /var/log/php-fpm && \
    chown -R $user:$user /var/log/php-fpm

# Mudar para o usuário laravel
USER $user

# Expor porta 9000
EXPOSE 9000

# Iniciar PHP-FPM
CMD ["php-fpm"]
