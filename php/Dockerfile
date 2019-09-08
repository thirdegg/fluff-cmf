FROM php:7.3-apache
COPY php.ini /usr/local/etc/php/
RUN apt-get update \
  && apt-get install -y git libfreetype6-dev libmcrypt-dev unzip \
  && docker-php-ext-install pdo_mysql mysqli mbstring gd iconv

#RUN curl -sS https://getcomposer.org/installer | php -- \
#        --filename=composer \
#        --install-dir=/usr/local/bin && \
#        echo "alias composer='composer'" >> /root/.bashrc && \
#        composer

RUN a2enmod rewrite
COPY apache-config.conf /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/html/
RUN ls -la /var/www/html/


