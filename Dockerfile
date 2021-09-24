FROM php:7.4-cli-alpine

ARG BUILD_DATE
ARG VCS_REF

LABEL Maintainer="Brian Gebel <brian@pixeloven.com>" \
      Description="Lightweight php 7.4 container based on alpine with xDebug enabled & composer installed." \
      org.label-schema.name="php-7.4-xdebug-alpine" \
      org.label-schema.description="Lightweight php 7.4 container based on alpine with xDebug enabled & composer installed." \
      org.label-schema.build-date=$BUILD_DATE \
      org.label-schema.vcs-ref=$VCS_REF \
      org.label-schema.schema-version="1.0.0"

RUN apk update \
    && apk add --no-cache php7-pecl-xdebug \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /usr/src/app
