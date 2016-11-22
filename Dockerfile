from php:5.6-fpm

MAINTAINER Sylvain Boily <sboily@proformatique.com>

RUN apt-get update && apt-get install -y \
        smarty3 \
        php5-pgsql \
        php5-curl
 
RUN rm -rf /var/www/html/*
COPY . /var/www/html/
RUN mkdir /var/www/html/templates_c/
RUN chown www-data /var/www/html/templates_c/

WORKDIR /var/www/html

EXPOSE 80
CMD APACHE_ARGUMENTS=-DFOREGROUND /usr/sbin/apache2ctl start
