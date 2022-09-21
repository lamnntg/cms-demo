FROM php:7.4-fpm
ARG user=appuser
ARG group=appuser
ARG uid=1000
ARG gid=1000
RUN groupadd -g ${gid} ${group} && useradd -m -u ${uid} -g ${group} -s /bin/sh ${user}
RUN apt-get update -y
RUN apt-get install -y
RUN apt-get install -y \
    libzip-dev unzip libonig-dev libpng-dev \
    libwebp-dev libjpeg62-turbo-dev libxpm-dev \
    libfreetype6-dev
RUN docker-php-ext-install pdo pdo_mysql zip mbstring
# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
USER ${user}
