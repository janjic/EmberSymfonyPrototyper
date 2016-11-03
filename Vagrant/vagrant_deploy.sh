#!/bin/bash
# Deploy script
sudo rm -rf /usr/share/fsddev-app;sudo mkdir --mode=u+rwx,g+rwx,o-r /usr/share/fsddev-app; sudo chown -R vagrant:www-data /usr/share/fsddev-app;cd /var/www/fsd_dev;
rm -rf web/Resource/*
php7.0 app/console empire-cli:deploy --env=prod --no-debug
rm -rf /usr/share/fsddev-app/cache
php7.0 app/console assetic:dump --env=prod --no-debug
sudo rm -rf /usr/share/fsddev-app;sudo mkdir --mode=u+rwx,g+rwx,o-r /usr/share/fsddev-app; sudo chown -R www-data:www-data /usr/share/fsddev-app;
