#!/usr/bin/env bash

git pull
~/composer.phar install
bin/console ca:cl -e prod
bin/console doc:mig:mig -n
chown -R www-data:petr var/cache/prod
