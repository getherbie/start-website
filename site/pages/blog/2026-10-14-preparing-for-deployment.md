---
title: Preparing the Site for Deployment
layout: post
type: post
date: 2026-10-14
author_id: robin-starter
authors: [Robin Starter]
categories: [Tutorials]
tags: [deployment]
abstract: "The checklist before going live: replace placeholder secrets, configure SMTP, remove the noindex middleware and check the generated feed."
---

The starter is safe for local development by default. A few settings need your
attention before the site goes live.

## Replace placeholder secrets

`site/config/main.dist.php` is the versioned template; `site/config/main.php` is
generated at deploy time. The workflow fills these repository secrets into it:

```text
SMTP_RECIPIENT
SMTP_HOST
SMTP_USERNAME
SMTP_PASSWORD
```

CSRF and captcha secrets are generated fresh with every deploy. Without the SMTP
secrets, the form looks fine but submissions go nowhere.

## Configure mail delivery

The generated config sets `plugins.contact.smtp` from `SMTP_HOST`, `SMTP_USERNAME`
and `SMTP_PASSWORD` (port 587, STARTTLS). The
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
