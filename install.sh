#!/usr/bin/env bash

composer update
cp .env.example .env
php artisan key:generate
composer dump-autoload
php artisan migrate --seed
php artisan passport:keys
php artisan passport:client --personal
