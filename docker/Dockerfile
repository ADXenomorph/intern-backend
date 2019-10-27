FROM ubuntu

ENV DEBIAN_FRONTEND=noninteractive

ADD postgres /home/postgres/
ADD nginx /home/nginx/

EXPOSE 9001

RUN mkdir -p /home/project
VOLUME ["/home/project"]
WORKDIR /home/project

RUN apt-get update && apt-get install -yq \
    vim \
    git \
    nginx \
    postgresql \
    php7.2 \
    php7.2-pgsql \
    php7.2-fpm \
    php7.2-dev \
    php-pear \
    php7.2-mbstring

RUN pecl install xdebug \
    && echo "zend_extension=xdebug.so" >> /etc/php/7.2/mods-available/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /etc/php/7.2/mods-available/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /etc/php/7.2/mods-available/xdebug.ini \
    && echo "xdebug.remote_host=172.17.0.1" >> /etc/php/7.2/mods-available/xdebug.ini \
    && echo "xdebug.remote_port=9001" >> /etc/php/7.2/mods-available/xdebug.ini \
    && echo "xdebug.remote_log=/var/log/xdebug.log" >> /etc/php/7.2/mods-available/xdebug.ini \
    && ln -s /etc/php/7.2/mods-available/xdebug.ini /etc/php/7.2/fpm/conf.d/20-xdebug.ini \
    && ln -s /etc/php/7.2/mods-available/xdebug.ini /etc/php/7.2/cli/conf.d/20-xdebug.ini

RUN rm /etc/postgresql/10/main/pg_hba.conf \
    && cp /home/postgres/pg_hba.conf_trust /etc/postgresql/10/main/pg_hba.conf \
    && service postgresql start \
    && psql -U postgres -c "ALTER USER postgres PASSWORD '12345';" \
    && psql -U postgres -c "CREATE DATABASE roowix;" \
    && rm /etc/postgresql/10/main/pg_hba.conf \
    && cp /home/postgres/pg_hba.conf_md5 /etc/postgresql/10/main/pg_hba.conf \
    && echo "listen_addresses = '*'" >> /etc/postgresql/10/main/postgresql.conf

RUN rm /etc/nginx/sites-available/default \
    && cp /home/nginx/default /etc/nginx/sites-available/default

CMD nginx && service postgresql restart && service php7.2-fpm start && bash
