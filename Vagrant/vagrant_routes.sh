#!/bin/bash
# Deploy script
sudo rm -rf /usr/share/fsddev-app;sudo mkdir --mode=u+rwx,g+rwx,o-r /usr/share/fsddev-app; sudo chown -R vagrant:www-data /usr/share/fsddev-app;cd /var/www/fsd_dev;
php bin/console assets:install
php bin/console fos:js-routing:dump
php bin/console bazinga:js-translation:dump
php bin/console assetic:dump --env=prod --no-debug
