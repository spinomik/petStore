#!/bin/sh

# Zainstaluj zależności npm
echo "Running npm install..."
npm install

# Zainstaluj zależności PHP
echo "Running composer install..."
composer install

# Uruchom główną aplikację (np. serwer PHP)
echo "Starting the application..."
exec "$@"