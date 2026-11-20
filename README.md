[![Packagist](https://img.shields.io/packagist/dt/getherbie/start-website.svg)](https://packagist.org/packages/getherbie/start-website)
[![GitHub (pre-)release](https://img.shields.io/github/release/getherbie/start-website/all.svg)](https://github.com/getherbie/start-website/releases)
[![License](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](https://github.com/getherbie/start-website/blob/master/LICENCE.md)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/getherbie/start-website.svg)](https://packagist.org/packages/getherbie/start-website)

# Website Kickstarter

> Bootstrap a Herbie website in no time – with Docker Compose or plain PHP 👌

The kickstarter comes with three themes, example pages, a small blog, and the plugins needed for contact forms and search.

## What the Kickstarter Includes

* [Herbie CMS](https://github.com/getherbie/herbie) with Twig and Markdown
* A Docker Compose setup with PHP 8.3 by default
* Example pages with real content and a blog with posts, authors, categories, tags, archive and Atom feed
* Three selectable themes (`default`, `light`, `dark`) with a theme switcher in the header
* Dependency-free CSS with custom properties — no Pure CSS and no external icon font
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

## Themes

The header contains a theme switcher with `default`, `light` and `dark`. The choice
is stored in a cookie, so it survives navigation and reloads. The active theme is
validated against the `themes` list in `site/data/site.json`; unknown values fall
back to `default`.

All layouts live in `site/themes/default`. The config sets `themeParent` to
`default`, so the `light` and `dark` themes only override CSS custom properties in
`css/theme.css`. To add your own theme:

1. Create `site/themes/<name>/css/theme.css` with your variable overrides.
2. Add `<name>` to the `themes` list in `site/data/site.json`.

Copy a Twig template into your theme folder if you need different markup; Herbie
falls back to the parent theme for every template you do not override.

The author portraits are original, hand-written SVG illustrations in
`site/media/img/authors/`. Each author's `avatar` attribute in
`site/data/authors.json` points to one of these files (for example
`img/authors/alex-weber.svg`); the layouts render them as normal `<img>` elements via
Herbie's `image()` function. `web/index.php` serves `site/media` at `/media/...`, so the
files behave like ordinary static images. They are fictional characters, require no
external assets and have no third-party license obligations.

## Blog

The blog is made of normal pages in `site/pages/blog`. A post is a Markdown file
with `layout: post`, `type: post`, `date`, `author_id`, `categories`, `tags` and an
`abstract`. New posts appear automatically in the index, archive, author pages,
tag/category archives and the Atom feed. Longer lists are paginated with six posts
per page (`?page=2`); the controls appear only when there is more than one page.

Authors are entries in `site/data/authors.json`, keyed by the `author_id` used in
posts. Add an author there and the profile page plus all bylines appear without a
new Markdown file. Every blog route is generated at runtime: `site/config/main.php`
rewrites `blog/author/…`, `blog/tag/…`, `blog/category/…`, `blog/archive`,
`blog/author`, `blog/tag` and `blog/category` to the blog index, and the local
`blog` plugin in `site/extend/plugins/blog` supplies the matching virtual page. The
Atom feed at `/blog/feed.xml` is produced by the same plugin. No placeholder files
are needed for authors, tags, categories, the archive or the feed.

The `blog_terms()` Twig function in `site/extend/twig_functions` supplies the tag
and category lists in the sidebar.

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
