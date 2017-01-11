
upstream websocket {
    server localhost:8080;
}
server {
        # listen on this port external
        listen 8888;
        rewrite ^(/app/.*)/assets/(.*).*$ /app/assets/$2 last;
        # SSL
          ssl on;
         ssl_certificate /etc/ssl/fsd.dev/fsd.dev.pem;
         ssl_certificate_key /etc/ssl/fsd.dev/fsd.dev.key;

	     ssl_session_cache shared:SSL:10m;
         ssl_session_timeout 5m;

        # route all to "websocket"
        location / {
                proxy_pass http://websocket;
                 proxy_http_version 1.1;
                proxy_set_header Upgrade $http_upgrade;
                proxy_set_header Connection "upgrade";
                proxy_set_header Host $host;

                proxy_set_header X-Real-IP $remote_addr;
                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                proxy_set_header X-Forwarded-Proto https;
                proxy_read_timeout 86400;
                proxy_redirect off;
        }
}
server {   
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    root /var/www/fsd_dev/web;
    rewrite ^(/app/.+)/assets/(.*)$ /app/assets/$2 last
    ssl on;
    ssl_certificate /etc/ssl/fsd.dev/fsd.dev.pem;
    ssl_certificate_key /etc/ssl/fsd.dev/fsd.dev.key;
    add_header Access-Control-Allow-Origin *;
    location / {
        # try to serve file directly, fallback to app.php
        try_files $uri /app.php$is_args$args;
    }
    # DEV
    # This rule should only be placed on your development environment
    # In production, don't include this and don't deploy app_dev.php or config.php
    location ~ ^/(app_dev|config)\.php(/|$) {
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        fastcgi_param  SCRIPT_FILENAME  $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }
    # PROD
    location ~ ^/app\.php(/|$) {
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        fastcgi_param  SCRIPT_FILENAME  $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        # Prevents URIs that include the front controller. This will 404:
        # http://domain.tld/app.php/some-path
        # Remove the internal directive to allow URIs like this
        internal;
    }
   location ~*  \.(jpg|jpeg|png|gif|ico|css|js)$ {
   expires 365d;
   }
location /app {
    root /var/www/fsd_dev/web/app;
    rewrite ^ /index.html break;

}

location /app/assets {
    root /var/www/fsd_dev/web;
}

location /app/fonts/ {

    #Fonts dir
    alias /var/www/fsd_dev/web/app/fonts/;

    #Include vanilla types
    include mime.types;

    #Missing mime types
    types  {font/truetype ttf;}
    types  {application/font-woff woff;}
    types  {application/font-woff2 woff2;}
}

   ### phpMyAdmin ###
location /phpmyadmin {
               root /usr/share/;
               index index.php index.html index.htm;
               location ~ ^/phpmyadmin/(.+\.php)$ {
                       try_files $uri =404;
                       root /usr/share/;
                       fastcgi_pass unix:/run/php/php7.0-fpm.sock;
                       fastcgi_index index.php;
                       fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                       include /etc/nginx/fastcgi_params;
               }
               location ~* ^/phpmyadmin/(.+\.(jpg|jpeg|gif|css|png|js|ico|html|xml|txt))$ {
                       root /usr/share/;
               }
        }
        location /phpMyAdmin {
               rewrite ^/* /phpmyadmin last;
        }
     ### phpMyAdmin ###
        error_log /var/log/nginx/fsd_dev-ssl-error.log;
        access_log /var/log/nginx/fsd_dev-ssl-access.log;
}
