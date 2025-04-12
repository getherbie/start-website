[![Packagist](https://img.shields.io/packagist/dt/getherbie/start-website.svg)](https://packagist.org/packages/getherbie/start-website)
[![GitHub](https://img.shields.io/github/release/getherbie/start-website/all.svg)](https://github.com/getherbie/start-website/releases)
[![License](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](https://github.com/getherbie/start-website/blob/master/LICENCE.md)

# Website Kickstarter for Herbie CMS

## Using PHP

### Installation

You can start your new Herbie CMS website by using Composer.

    composer create-project getherbie/start-website mywebsite

This will install a simple demo website and all required dependencies.

### Run website

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

## Using Docker and Docker Compose

### Installation

Start Herbie CMS website by using Composer.

    docker run --rm -v $PWD:/app composer create-project --ignore-platform-reqs getherbie/start-website mywebsite

### Run website

Go to the web directory

    cd mywebsite/web

And start website

    docker compose up website

Open <http://localhost:8888> with your browser.

## More Information

For more information, see <https://herbie.tebe.ch>.
