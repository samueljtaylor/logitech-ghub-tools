#!/usr/bin/env sh

if ! [ -f ./.env ]; then
    cp ./.env.example ./.env
fi

sed -i 's/PLATFORM=.*/PLATFORM="Docker"/g' ./.env

if ! [ -d ./vendor ]; then
    composer install
fi

if ! [ -d ./node_modules ]; then
    npm install
fi

if ! [ -f ./public/mix-manifest.json ]; then
    npm run prod
fi

if ! [ -f ./database/database.sqlite ]; then
    touch ./database/database.sqlite
    php artisan migrate
fi

php artisan serve --host=0.0.0.0
