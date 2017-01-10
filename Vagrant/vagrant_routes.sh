#!/bin/bash
# Deploy script
sudo rm -rf /usr/share/fsddev-app;sudo mkdir --mode=u+rwx,g+rwx,o-r /usr/share/fsddev-app; sudo chown -R vagrant:www-data /usr/share/fsddev-app;cd /var/www/fsd_dev;
php7.0 bin/console assets:install
php7.0 bin/console fos:js-routing:dump
php7.0 bin/console bazinga:js-translation:dump
php7.0 bin/console dump:api-codes-to:ember
php7.0 bin/console assetic:dump --env=prod --no-debug
