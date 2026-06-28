FROM php:8.2-apache

WORKDIR /var/www/html

COPY . /var/www/html/

RUN mkdir -p /var/www/html/uploads && \
    touch /var/www/html/data.json && \
    echo '{"hero_title":"Empowering Business Through","hero_subtitle":"Three specialized firms — MAS Corporation for e-procurement, MAS Communication for web & IT, and MAS Consultancy for foreign business operations. One group, complete solutions.","about_text":"MAS is a licensed group of companies under MAS Corporation, headquartered in Dhaka, Bangladesh.","about_text2":"Our three sister concerns operate in dedicated domains.","stats_years":"10","stats_projects":"300","stats_clients":"150","stats_us_clients":"40","contact_address":"House 12, Road 4, Block B, Banani, Dhaka-1213, Bangladesh","contact_phone_us":"+1 (347) 000-0000","contact_phone_bd":"+880-1700-000000","contact_email1":"info@masconsultancy.org","contact_email2":"biz@masconsultancy.org","contact_hours":"Sun - Thu: 9:00 AM - 6:00 PM","blogs":[]}' > /var/www/html/data.json && \
    chmod 777 /var/www/html/data.json && \
    chmod -R 777 /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite

RUN echo '<Directory /var/www/html>\nOptions Indexes FollowSymLinks\nAllowOverride All\nRequire all granted\n</Directory>' >> /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
