FROM php:8.1-fpm-alpine

RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        curl-dev \
        libtool \
        libxml2-dev \
        postgresql-dev \
        sqlite-dev

RUN apk add --no-cache \
        curl \
        git \
        mysql-client \
        postgresql-libs \
        libintl \
        icu \
        icu-dev \
        libzip-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev


RUN docker-php-ext-install \
        bcmath \
        curl \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pdo_sqlite

RUN apk add nodejs npm

RUN npm install -g npm

RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

RUN apk del -f .build-deps

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
