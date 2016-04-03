#!/usr/bin/env bash

git pull
bin/console ca:cl -e prod
bin/console doc:mig:mig -n
chown -R www-data:petr var/cache/prod
