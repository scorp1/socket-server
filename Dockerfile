FROM ubuntu:16.04

RUN apt-get update
RUN composer install

CMD php bin/server.php