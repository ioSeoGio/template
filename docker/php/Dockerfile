FROM php:8.0.0-fpm

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && \
	apt-get install -y \
		libzip-dev zlib1g-dev libicu-dev g++ unzip libpng-dev libmagickwand-dev

RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl


RUN mkdir -p /usr/src/php/ext/imagick; \
    curl -fsSL https://github.com/Imagick/imagick/archive/06116aa24b76edaf6b1693198f79e6c295eda8a9.tar.gz | tar xvz -C "/usr/src/php/ext/imagick" --strip 1; \
    docker-php-ext-install imagick;



RUN cd ~
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
