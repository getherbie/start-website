---
title: Contact Forms and Search
layout: post
type: post
date: 2026-09-02
author_id: jane-sample
authors: [Jane Sample]
categories: [Tutorials]
tags: [plugins, forms]
abstract: How the contact form and the site search are wired into the starter and which settings matter before you deploy.
---

Two plugins turn this static-looking site into something interactive: `contact` and
`search`. Both are enabled in `site/config/main.php` and both are ready for local
development with safe placeholder settings.

## The contact form

The {{ link_page('contact', 'contact page') }} calls `{{ '{{' }} contact() {{ '}}' }}`. The
plugin renders the fields, adds a CSRF token and a time check, and includes an
ALTCHA captcha widget. Failed and successful submissions are handled by the same
template.

Before deploying, add these repository secrets:

```text
SMTP_RECIPIENT
SMTP_HOST
SMTP_USERNAME
SMTP_PASSWORD
```

The CI workflow substitutes them into `site/config/main.php` from
`site/config/main.dist.php` and generates fresh CSRF/captcha secrets. SMTP uses port
587 with STARTTLS. The `cached: false` property on the contact page makes sure the
form is never served from the page cache.

## The site search

The search plugin indexes page titles, bodies and front matter. There is a small
form in the sidebar of every default page and a full {{ link_page('search', 'search page') }}
with the result list. Try a word that only appears in a blog post, such as
`custom properties`, to see that posts are included.

Pages can opt out with `no_search: true`, which is how the Atom feed stays out of
the results. The `hidden` property keeps utility pages out of menus and sitemaps
without making them unreachable.

## Keep the demo quiet

A middleware in `site/extend/middlewares_app/noindex.php` sends
`X-Robots-Tag: noindex, nofollow` with every response. Remove that file when the
site is ready for search engines.
