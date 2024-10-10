FROM php:8.3.12-apache

ARG user
ARG uid

RUN apt update && apt-get install -y \
    vim \
    curl \
    git

RUN apt clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install dom fileinfo filter hash json libxml openssl ctype mbstring pcre phar session tokenizer xml xmlwriter

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www/html

USER $user

EXPOSE 80