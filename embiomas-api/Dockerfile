FROM php:8.3-fpm

# Instala dependências do sistema e do PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Limpa cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala extensões do PHP necessárias para o Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto para o container
COPY . /var/www

# Instala dependências do PHP
RUN composer install --no-interaction --optimize-autoloader

# Instala dependências do Node e compila os assets (Vite)
RUN npm install
RUN npm run build

# Ajusta permissões
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Exponha a porta 9000
EXPOSE 9000

CMD ["php-fpm"]
