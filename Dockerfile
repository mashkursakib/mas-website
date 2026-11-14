FROM php:8.2-apache

WORKDIR /var/www/html

COPY . /var/www/html/

# PHP runs as www-data and must be able to write the CMS data files
# (data/*.json), the admin password config and the newsletter list.
RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite

# Let the site's .htaccess control access (it blocks /data/, /includes/,
# config.php and .git from browsers).
RUN printf '<Directory /var/www/html>\nOptions Indexes FollowSymLinks\nAllowOverride All\nRequire all granted\n</Directory>\n' >> /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
