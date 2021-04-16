FROM php:7.2-cli-alpine

ARG BUILD_DATE
ARG VCS_REF

LABEL Maintainer="Brian Gebel <bgebel@gofundme.com>" \
      Description="Lightweight php 7.2 container based on alpine with xDebug enabled & composer installed." \
      org.label-schema.name="php-7.2-xdebug-alpine" \
      org.label-schema.description="Lightweight php 7.2 container based on alpine with xDebug enabled & composer installed." \
      org.label-schema.build-date=$BUILD_DATE \
      org.label-schema.vcs-ref=$VCS_REF \
      org.label-schema.schema-version="1.0.0"

RUN apk update \
    && apk add --no-cache curl \
    && apk add --no-cache librdkafka autoconf build-base librdkafka-dev \
    && apk add --no-cache git \
    && apk add --no-cache openssh-client \
    && apk add --no-cache $PHPIZE_DEPS \
    && apk add --no-cache zlib-dev libmemcached-dev \
    && pecl install memcached \
    && pecl install xdebug-2.6.0 \
    && pecl install rdkafka \
    && docker-php-ext-enable memcached \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable rdkafka \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /usr/src/app
