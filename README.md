FacebookMocker
==============

Mocks Facebook for OAuth authentication

Installation
------------

    git clone git://github.com/nixilla/FacebookMocker.git your_folder
    cd your_folder
    wget http://silex.sensiolabs.org/get/silex.phar


Sample nginx config

    server {
        listen your_ip:80;

        listen your_ip:443 ssl;
        ssl_certificate      /etc/nginx/ssl/some.crt;
        ssl_certificate_key  /etc/nginx/ssl/some.key;

        server_name facebook.com graph.facebook.com www.facebook.com;
        root /path/to/your_folder/web;
        index index.php;

        access_log /var/log/nginx/facebook.com.access_log main;
        error_log /var/log/nginx/facebook.com.error_log info;

        location / {
            if (-f $request_filename) {
                expires max;
                break;
            }

            if ($request_filename !~ "\.(js|htc|ico|gif|jpg|png|css)$") {
                rewrite ^(.*) /index.php last;
            }
        }

        location ~ \.php($|/) {
            set $script $uri;
            set  $path_info  "";
            if ($uri ~ "^(.+\.php)(/.+)") {
                set $script $1;
                set $path_info $2;
            }

            fastcgi_pass 127.0.0.1:9000;
            include fastcgi_params;
            fastcgi_param PATH_INFO $path_info;
            fastcgi_param SCRIPT_FILENAME $document_root/$script;
            fastcgi_param SCRIPT_NAME $script;
        }
    }

Edit your /ets/hosts and add this line:

    your_ip facebook.com graph.facebook.com www.facebook.com

Note:

This config (in /etc/hosts) will completely redirect all traffic to facebook.com to your_ip which is on your server.
This setting is meant for testing your app with the Facebook OAuth, so don't forget to remove it after you're done.
Otherwise you won't be able to access Facebook. Don't blame me, as I just warned you.