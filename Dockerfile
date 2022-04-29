from php:7.4-apache

MAINTAINER Sylvain Boily <sylvain@wazo.io>

RUN apt update && apt -y dist-upgrade && apt install -y \
        wget

WORKDIR /usr/src
RUN wget https://github.com/smarty-php/smarty/archive/refs/tags/v4.1.0.tar.gz
RUN tar xfvz v4.1.0.tar.gz
RUN mkdir /usr/local/lib/php/Smarty
RUN cp -r smarty-4.1.0/libs/* /usr/local/lib/php/Smarty
 
RUN rm -rf /var/www/html/*
COPY . /var/www/html/
RUN mkdir /var/www/html/templates_c/
RUN chown www-data /var/www/html/templates_c/

WORKDIR /var/www/html

EXPOSE 80
CMD APACHE_ARGUMENTS=-DFOREGROUND /usr/sbin/apache2ctl start
