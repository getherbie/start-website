---
title: Features
---

# What is included

Herbie Website Starter is a small but complete website. Every part is a normal file you can
change or remove — there is no hidden configuration layer and no database.

## Content and structure

* Example pages for features, getting started, about and contact.
* A blog with posts, author profiles, categories, tags, an archive and an Atom feed.
* A site-wide search and a contact form with CSRF token and ALTCHA captcha.
* A `noindex, nofollow` response header so the demo stays out of search results.

## Design

* Five selectable themes: `default`, `dark`, `journal`, `spotlight` and `docs`.
* A floating theme switcher in the bottom-right corner; the selection is stored in a cookie.
* Responsive layouts written with CSS Grid and Flexbox — no Pure CSS, no icon font and
  no JavaScript framework.
* Child themes inherit templates and assets from the `default` theme.

## Under the hood

* Herbie CMS 3 with Twig templates and Markdown content.
* PHP 8.3 or newer, with a Docker Compose setup for local development.
* Assets in `site/themes` are published automatically to `web/assets`.

## Try it out

Switch themes with the button in the bottom-right corner, search for a term such as "theme", open a
{{ link_page('blog', 'blog post') }} and follow the author and tag links, or send a
message through {{ link_page('contact', 'the contact form') }}.
