FROM debian:jessie

ARG HOST_USER_ID
ARG HOST_GROUP_ID

# Install basic toolsdocker
RUN apt-get update && apt-get install -y \
    apt-transport-https ca-certificates lsb-release \
    software-properties-common \
    wget curl nmap \
    nano git unzip make

RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list \
    &&  apt-get update

# Install PHP with all necessary extensions
RUN apt-get update && apt-get install -y \
    php7.2-fpm \
    php7.2-cli \
    php7.2-common \
    php7.2-intl \
    php7.2-mbstring \
    php7.2-mysqli \
    php7.2-pdo \
    php7.2-xml \
    php7.2-xdebug \
    php7.2-gd \
    php7.2-curl \
    php7.2-pgsql

RUN addgroup --gid ${HOST_GROUP_ID} app && \
    adduser --shell /bin/bash --disabled-password --system --uid ${HOST_USER_ID}  --gid ${HOST_GROUP_ID} app

# Customize PHP configuration
COPY ./etc/php.ini              /etc/php/7.2/cli/conf.d/php_custom.ini
COPY ./etc/php.ini              /etc/php/7.2/fpm/conf.d/php_custom.ini
COPY ./etc/php-fpm-pool.conf    /etc/php/7.2/fpm/pool.d/www.conf
COPY ./etc/php-fpm.conf         /etc/php/7.2/fpm/php-fpm.conf

# Install composer
RUN cd /tmp && curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

WORKDIR /var/www
EXPOSE 9000

USER app


# Start PHP FPM daemon
CMD /usr/sbin/php-fpm7.2 -F
