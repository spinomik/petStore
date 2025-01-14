# 1. Wybieramy obraz PHP 8.4 z Apachem
FROM php:8.4-apache

# 2. Instalujemy wymagane rozszerzenia PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath zip \
    && a2enmod rewrite \
    && apt-get clean

# 3. Skopiuj aplikację Laravel do katalogu /var/www/html
WORKDIR /var/www/html
COPY . /var/www/html

# 4. Instalujemy Composer (menedżer zależności PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 5. Nadpisanie pliku entrypoint.sh
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# 6. Zainstaluj zależności PHP projektu Laravel (na wypadek, gdyby entrypoint.sh ich nie zainstalował)
RUN composer install --no-dev --optimize-autoloader

# 7. Ustawiamy uprawnienia dla plików, aby Apache mógł je prawidłowo odczytywać
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Zmieniamy DocumentRoot na folder 'public' Laravela
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 9. Eksponujemy port 80, na który nasza aplikacja Laravel będzie dostępna
EXPOSE 80

# 10. Ustawiamy entrypoint
ENTRYPOINT ["entrypoint.sh"]

# 11. Uruchamiamy Apache w trybie foreground
CMD ["apache2-foreground"]