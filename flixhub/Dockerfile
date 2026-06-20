FROM php:8.4-apache

# Aumenta o limite de upload do PHP para 50MB
RUN echo "upload_max_filesize = 50M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/uploads.ini

# INSTALA E ATIVA O OPCACHE (Aceleração máxima de leitura de arquivos)
RUN apt-get update && apt-get install -y libonig-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring opcache \
    && echo "opcache.enable=1" > /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Ativa o módulo de reescrita do Apache
RUN a2enmod rewrite

# Aponta o Apache para a pasta 'public' do Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Copia o projeto e dá as permissões corretas de escrita
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80