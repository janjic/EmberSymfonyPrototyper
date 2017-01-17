#!/bin/bash
# init script
# php7.0 bin/console doctrine:database:create
rm -rf web/Resource/*
Vagrant/vagrant_cache_clear.sh
php7.0 bin/console doctrine:schema:update --force
php7.0 bin/console import_hierarchy
php7.0 bin/console agent:create-admin
php7.0 bin/console import_agents
php7.0 bin/console proto:oauth-server:client:create --redirect-uri="https://192.168.11.3/" --grant-type="authorization_code" --grant-type="password" --grant-type="refresh_token" --grant-type="token" --grant-type="client_credentials" --grant-type="access_token"
Vagrant/vagrant_routes.sh
Vagrant/vagrant_cache_clear.sh