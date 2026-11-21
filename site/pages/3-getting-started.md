---
title: Getting Started
---

# Getting started

Run the site locally, then edit the files that interest you. That is the whole
workflow — there is no build step and nothing to compile.

## Run it locally

With Docker Compose:

    docker compose up website

Without Docker:

    composer install
    cd web
    php -S localhost:8888 index.php

Open <http://localhost:8888> and use the theme switcher in the bottom-right corner.

## Where things live

| Path | Purpose |
| --- | --- |
| `site/pages` | Markdown pages; the file name becomes the route |
| `site/data/menu.json` | The main navigation |
| `site/data/site.json` | Site title, description and available themes |
| `site/themes/default` | Default layouts, CSS and JavaScript |
| `site/themes/dark` | Small theme that overrides CSS variables |
| `site/media` | Images and downloads |
| `site/config/main.php` | CMS configuration, plugins and cookie settings |

## Add a page

Create `site/pages/my-page.md` with a YAML header and Markdown body:

```markdown
---
title: My page
---

# Hello world

This is my first page.
```

It is immediately available at `/my-page` (or `/index.php/my-page` without pretty
URLs). Use `layout` in the header to pick a Twig layout from `site/themes/default`.

## Add a blog post

Put a dated file in `site/pages/blog`:

```markdown
---
title: My first post
layout: post
type: post
date: 2026-11-20
author_id: robin-starter
categories: [News]
tags: [herbie]
abstract: A short summary shown on list pages.
---

The post body goes here.
```

The blog index, archive, author page and feed pick it up automatically. See the
existing posts and the {{ link_page('blog/author', 'author profiles') }} for complete
examples.

## Images and downloads

This image is rendered through Herbie's `imagine()` Twig function:

{{ imagine('img/tulpen.jpg') }}

And this is a {{ link_download('pdf/dummy.pdf', 'sample download', show_info=true) }}.
Both files live in `site/media`.

## Search and contact

{{ link_page('search', 'The search page') }} uses the search plugin with a sidebar form.
{{ link_page('contact', 'The contact page') }} renders the contact plugin with CSRF
protection and an ALTCHA captcha. Check their configuration in
`site/config/main.php` before going live.
