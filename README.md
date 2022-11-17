[![Packagist](https://img.shields.io/packagist/dt/getherbie/start-website.svg)](https://packagist.org/packages/getherbie/start-website)
[![GitHub](https://img.shields.io/github/release/getherbie/start-website/all.svg)](https://github.com/getherbie/start-website/releases)
[![License](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](https://github.com/getherbie/start-website/blob/master/LICENCE.md)

# Website Kickstarter for Herbie CMS

## Install Herbie CMS using Composer

You can start your new Herbie CMS website by using Composer.

For the upcoming 2.x version:

    composer create-project getherbie/start-website:dev-master mywebsite

For the stable 1.x version (only with PHP 5.x):

    composer create-project getherbie/start-website mywebsite 

Composer installs a simple demo website including the needed dependencies into the `mywebsite` folder. 

In your terminal go to the web directory and start the internal PHP webserver.

    cd mywebsite/web
    php -S localhost:8888 index.php

Now, open the URL <http://localhost:8888> in your browser. Finished!

If you want to have additional console output or logging information, set the debug environment variable.

    HERBIE_DEBUG=1 php -S localhost:8888 index.php

If you want to debug using Xdebug (3.x), start the internal web server as follows.

    XDEBUG_MODE=debug php -S localhost:8888 index.php

For this to work, Xdebug must of course be installed.

## Install Herbie CMS using Docker

You can find the Docker configuration files here:

```
docker-compose.yml
docker
    - nginx
        - app.conf
docker
    - php
        - Dockerfile
        - php.ini
```

First, you should update the server name in the config file `docker/nginx/app.conf` (`server_name your-domain.tld;` -> for example `server_name mydomain.org`).

Then start the Docker container by using `docker-compose up -d` in the root dir of the website.

Now, open the URL <http://0.0.0.0:8888> or <http://mydomain.org> in your browser. Finished!

## More Information

<https://herbie.tebe.ch>
