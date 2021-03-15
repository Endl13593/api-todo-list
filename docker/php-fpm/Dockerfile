FROM jpaulolxm/php-7.4-fpm:1.4

RUN apk add --no-cache shadow

COPY entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

RUN usermod -u 1000 www-data
USER www-data

WORKDIR /var/www/html
