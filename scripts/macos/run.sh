#!/usr/bin/env zsh

SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" &> /dev/null && pwd)"
APP_PATH="${1:-"../.."}"

cd "$SCRIPT_DIR" || exit 1
cd "$APP_PATH" || exit 1

if ! [ -d ./vendor ]; then
    echo "Application install script doesn't look like it's been run. Running now..."
    sh ./scripts/macos/install.sh
fi

php artisan serve --host=0.0.0.0

