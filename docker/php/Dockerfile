FROM php:8.3-fpm

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions opcache
RUN install-php-extensions pdo_pgsql
RUN install-php-extensions xdebug

RUN apt-get update && apt-get install -y libzip-dev zip && docker-php-ext-install zip

ARG USER_ID=1000
ARG GROUP_ID=1000
RUN usermod -u $USER_ID www-data && groupmod -g $GROUP_ID www-data

WORKDIR /var/www/app
COPY --chown=www-data:www-data . /var/www/app

USER root
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --optimize-autoloader

ENV PHP_IDE_CONFIG 'serverName=Docker'
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.log=/dev/null" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN php artisan storage:link
