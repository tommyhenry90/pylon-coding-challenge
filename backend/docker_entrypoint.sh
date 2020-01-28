#!/bin/bash

set -e # exit when subcommands fail

# Install if first time running
if [[ ! -d vendor ]]; then
    # This fixes some issues when downloading packages.
    # See https://github.com/composer/composer/issues/7503#issuecomment-458173411
    composer config -g repo.packagist composer https://repo.packagist.org
    composer install --no-scripts --no-suggest
fi

# Run local server
php artisan serve --host 0.0.0.0
