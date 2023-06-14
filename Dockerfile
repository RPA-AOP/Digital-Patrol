FROM registry.gitlab.com/imamsy/digipatrol-backend:latest


# Copy over the php conf
COPY docker/docker-php.conf /etc/apache2/conf-enabled/docker-php.conf

# Copy over the php ini
COPY docker/docker-php.ini $PHP_INI_DIR/conf.d/

ADD . /var/www/html
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
