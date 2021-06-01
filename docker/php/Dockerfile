FROM php:8.0.0-fpm

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && \
	apt-get install -y \
		libzip-dev \
	&& docker-php-ext-install zip

RUN apt-get install -y \
	zlib1g-dev libicu-dev g++ unzip \
	&& docker-php-ext-configure intl \
	&& docker-php-ext-install intl

RUN cd ~
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

