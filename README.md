[![Packagist](https://img.shields.io/packagist/dt/getherbie/start-website.svg)](https://packagist.org/packages/getherbie/start-website)
[![GitHub](https://img.shields.io/github/release/getherbie/start-website/all.svg)](https://github.com/getherbie/start-website/releases)
[![License](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](https://github.com/getherbie/start-website/blob/master/LICENCE.md)

# Website Kickstarter for Herbie CMS

## Supported PHP Versions

- 8.0 / 8.1 / 8.2 / 8.3

## Run Website Using PHP and Composer

Create project and install dependencies.

    composer create-project getherbie/start-website mywebsite

In your terminal go to the web directory and start the built-in web server.

    cd mywebsite/web
    php -S localhost:8888 index.php

Now, open <http://localhost:8888> with your browser.
That’s all it takes!

If you need additional console output or logging information, set the debug environment variable.

    HERBIE_DEBUG=1 php -S localhost:8888 index.php

If you want to debug using Xdebug (3.x), start the web server as follows.

    XDEBUG_MODE=debug php -S localhost:8888 index.php

For this to work, Xdebug must of course be installed.

## Run Website Using Docker and Docker Compose

Create project and install dependencies.

    docker run --rm -v $PWD:/app composer create-project --ignore-platform-reqs getherbie/start-website mywebsite

Go to the `mywebsite` directory and start website.

    cd mywebsite
    docker compose up website

Open <http://localhost:8888> with your browser.

## More Information

For more information, see <https://herbie.tebe.ch>.
