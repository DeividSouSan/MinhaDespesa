FROM php:8.2-apache

# Habilita o mod_rewrite
RUN a2enmod rewrite

# Ativa permissão de .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Habilita o mysqli
RUN apt-get update && apt-get install -y libpng-dev && docker-php-ext-install mysqli

# Copia os arquivos do projeto para o container
COPY . /var/www/html
