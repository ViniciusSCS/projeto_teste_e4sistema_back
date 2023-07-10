# Use a imagem oficial do PHP com o Apache
FROM php:8-apache

# Instale as dependências do Laravel e outras extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath opcache zip

# Copie o arquivo de configuração do Apache
COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilite o módulo de reescrita do Apache
RUN a2enmod rewrite

# Copie o diretório do projeto para o contêiner
COPY . /var/www/html

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Instale as dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instale as dependências do projeto
RUN composer install --optimize-autoloader --no-dev

# Copie o arquivo de exemplo do ambiente Laravel
# COPY .env.example .env

# Gere a chave do aplicativo Laravel
RUN php artisan key:generate

# Defina as permissões corretas para os arquivos do projeto
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponha a porta do Apache
EXPOSE 8000

# Inicie o servidor Apache
CMD ["apache2-foreground"]
