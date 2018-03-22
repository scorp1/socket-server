FROM php:7.2-cli

RUN docker-php-ext-install pcntl
RUN docker-php-ext-install sockets

COPY . /var/www/server

WORKDIR /var/www/server

ENTRYPOINT [ "php", "bin/server.php", "" ]

EXPOSE 4545