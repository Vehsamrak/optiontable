#!/usr/bin/env bash

git pull
bin/console ca:cl -e prod
chown -R www-data:petr var/cache/prod