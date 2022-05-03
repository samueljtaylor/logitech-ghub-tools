#!/usr/bin/env zsh

SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" &> /dev/null && pwd)"
APP_PATH="${1:-"../.."}"
PLATFORM="OS X"

cd "$SCRIPT_DIR" || exit 1
cd "$APP_PATH" || exit 1

if ! [ -f ./.env ]; then
    echo ".env file not found, creating default..."
    cp .env.example .env
fi

echo "Setting PLATFORM environment variable to $PLATFORM"
sed -i "" "s/PLATFORM=.*/PLATFORM=\"$PLATFORM\"/" .env

if ! [ -d ./vendor ]; then
    echo "Installing Composer packages..."
    composer install
fi

if ! [ -d ./node_modules ]; then
    echo "Installing Node packages..."
    npm install
fi

if ! [ -f ./public/mix-manifest.json ]; then
    echo "Building..."
    npm run prod
fi

if ! [ -f ./database/database.sqlite ]; then
    echo "Creating SQLite database..."
    touch ./database/database.sqlite
fi

echo "Migrating database..."
php artisan migrate --force

echo "Install complete."


