[![Packagist](https://img.shields.io/packagist/dt/getherbie/start-website.svg)](https://packagist.org/packages/getherbie/start-website)
[![GitHub (pre-)release](https://img.shields.io/github/release/getherbie/start-website/all.svg)](https://github.com/getherbie/start-website/releases)
[![License](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](https://github.com/getherbie/start-website/blob/master/LICENCE.md)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/getherbie/start-website.svg)](https://packagist.org/packages/getherbie/start-website)

# Website Kickstarter

> Bootstrap a Herbie website in no time – with Docker Compose or plain PHP 👌

The kickstarter comes with a default theme, example pages, and the plugins needed for contact forms and search.

## What the Kickstarter Includes

* [Herbie CMS](https://github.com/getherbie/herbie) with Twig and Markdown
* A Docker Compose setup with PHP 8.3 by default
* A contact form with CSRF token and ALTCHA captcha
* A site search with a sidebar form
* `noindex, nofollow` by default so the site stays out of search results

## Supported PHP Versions

8.3 / 8.4 / 8.5 / 8.6

## Quick Start

Create your own Herbie website with Docker (recommended):

    docker run --rm -v "$PWD":/app composer create-project --ignore-platform-reqs getherbie/start-website mywebsite
    cd mywebsite
    docker compose up website

Open <http://localhost:8888>.

<details>
<summary>Without Docker (PHP & Composer required)</summary>

    composer create-project getherbie/start-website mywebsite
    cd mywebsite/web
    php -S localhost:8888 index.php

Optional: `HERBIE_DEBUG=1 php -S localhost:8888 index.php` for debug output, or `XDEBUG_MODE=debug php -S localhost:8888 index.php` for Xdebug.

</details>

## Development

Work on this repository with Docker (recommended):

    git clone https://github.com/getherbie/start-website.git
    cd start-website
    docker compose up website

Open <http://localhost:8888>.

Common tasks:

    docker compose run --rm install    # install Composer dependencies
    docker compose run --rm bash       # open a shell

Use a different PHP version (default: 8.3):

    PHP_VERSION=8.3 docker compose up website
    PHP_VERSION=8.4 docker compose up website
    PHP_VERSION=8.5 docker compose up website
    PHP_VERSION=8.6 docker compose up website

<details>
<summary>Without Docker (PHP & Composer required)</summary>

    git clone https://github.com/getherbie/start-website.git
    cd start-website
    composer install
    cd web
    php -S localhost:8888 index.php

</details>

## Contact Form Configuration

The contact form requires a CSRF secret and an ALTCHA captcha secret. The defaults in `site/config/main.php` are enough for local development.

For production, set `HERBIE_CONTACT_RECIPIENT`, `HERBIE_CONTACT_CSRF_SECRET` and `HERBIE_CONTACT_CAPTCHA_SECRET`, and configure SMTP under `plugins.contact.smtp`. When running with Docker Compose, pass these variables to the `website` container via `environment:` in `compose.yml`.

## Search Engine Indexing

This website is not intended to appear in search results. Every response is sent with `X-Robots-Tag: noindex, nofollow`, defined in `site/extend/middlewares_app/noindex.php`. This also covers non-HTML responses such as downloads.

If the website should be indexed by search engines, remove `site/extend/middlewares_app/noindex.php`.

## More Information

For more information, see <https://herbie.tebe.ch>.
