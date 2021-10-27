FROM php:7.4-cli

COPY . /usr/src/gruyere_app
WORKDIR /usr/src/gruyere_app

RUN apt-get update && apt-get install -y libmcrypt-dev \
    default-mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo_mysql

# Composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer dumpautoload -o

EXPOSE 80
EXPOSE 3306

#RUN php src/scripts/script_init_db.php