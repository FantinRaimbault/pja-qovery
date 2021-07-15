FROM php:8.0-apache

# Install PDO MySQL driver
# See https://github.com/docker-library/php/issues/62
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update -y && apt-get install -y libpng-dev libfreetype6-dev libyaml-dev

RUN pecl install yamL

#RUN docker-php-ext-configure gd \
#        --with-freetype-dir=/usr/include/freetype2 \
#   && docker-php-ext-install gd

# Workaround for write permission on write to MacOS X volumes
# See https://github.com/boot2docker/boot2docker/pull/534
RUN usermod -u 1000 www-data

# Enable Apache mod_rewrite
RUN a2enmod rewrite

COPY src var/www/html/
COPY server/000-default.conf /etc/apache2/sites-available/
COPY server/apache2.conf /etc/apache2/
COPY server/php.ini /usr/local/etc/php/

# Enable yaml
#RUN a2enmod yaml