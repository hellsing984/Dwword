FROM php:8.2-apache

# Active mod_rewrite (utile pour .htaccess par ex.)
RUN a2enmod rewrite

# Copie des fichiers de ton projet dans le conteneur
COPY . /var/www/html/

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html/
