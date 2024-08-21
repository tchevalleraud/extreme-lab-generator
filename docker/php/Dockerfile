FROM php:8.3-fpm

ARG USER_ID
ARG GROUP_ID

RUN apt update
RUN apt install -y bash git gnupg2 software-properties-common unzip wget
RUN apt install -y libldap2-dev libnss3 libx11-6 libzip-dev

RUN apt-get install -y libssh2-1-dev libssh2-1 \
    && pecl install ssh2-1.3.1 \
    && docker-php-ext-enable ssh2

RUN groupadd -f --gid $GROUP_ID user
RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID user
USER user

EXPOSE 9000

WORKDIR /var/www