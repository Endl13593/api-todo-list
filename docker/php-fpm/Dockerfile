FROM jpaulolxm/php-7.4-fpm:1.5

RUN apk add --no-cache shadow

COPY entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

WORKDIR /var/www/html
