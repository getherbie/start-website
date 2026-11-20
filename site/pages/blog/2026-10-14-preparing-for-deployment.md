---
title: Preparing the Site for Deployment
layout: post
type: post
date: 2026-10-14
author_id: herbie-team
authors: [Herbie Team]
categories: [Tutorials]
tags: [deployment]
abstract: "The checklist before going live: replace placeholder secrets, configure SMTP, remove the noindex middleware and check the generated feed."
---

The kickstarter is safe for local development by default. A few settings need your
attention before the site goes live.

## Replace placeholder secrets

`site/config/main.php` reads three environment variables for the contact plugin:

```text
HERBIE_CONTACT_RECIPIENT
HERBIE_CONTACT_CSRF_SECRET
HERBIE_CONTACT_CAPTCHA_SECRET
```

The defaults are `blackhole@example.com` and obvious placeholder strings. Set real
values in your deployment environment and use long random strings for the secrets.
Without them, the form looks fine but submissions go nowhere.

## Configure mail delivery

Add SMTP credentials under `plugins.contact.smtp` in the config file. The
{{ link_page('contact', 'contact page') }} then sends messages through your provider.
Test the form once after deploying — a working page render does not prove that mail
delivery works.

## Allow indexing

A middleware in `site/extend/middlewares_app/noindex.php` sends
`X-Robots-Tag: noindex, nofollow` with every response. It keeps the demo out of
search engines. Remove the file when the site is ready to be indexed.

## Check the output

Before you announce the site, confirm that:

* every navigation link resolves, including author, tag and category pages;
* the {{ link_page('blog/feed.xml', 'Atom feed') }} uses your real domain;
* the theme switcher remembers a choice across a reload;
* search returns results from blog posts, not just static pages.

## Keep the repository tidy

`web/assets`, `web/cache` and `site/runtime` are generated and ignored by Git. Deploy
the sources and let Herbie publish the assets on the first request. Make sure the
web server can write to those directories.
