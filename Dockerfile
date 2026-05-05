FROM php:8.3-fpm

# Instalar dependências de sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip

# Limpar o cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões do PHP (pdo_pgsql é crucial aqui)
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar o diretório de trabalho
WORKDIR /var/www

# Copiar o código existente
COPY . .

# Ajustar permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache