---
title: Home
layout: home
---

Herbie Website Starter gives you a working [Herbie CMS](https://github.com/getherbie/herbie)
website from the first minute: example pages, a small blog, a contact form, search and
six themes you can switch right in the browser. All content lives in plain Markdown
files, so you can edit it with any text editor — no database required.

--- left ---

## Ready out of the box

You get more than an empty skeleton. The site ships with a home page, feature and
getting-started guides, an about page, a contact form with CSRF protection and an
ALTCHA captcha, a site search and a complete example blog with posts, authors,
categories and tags.

Use the theme switcher in the header to see how the same content looks in the
`default`, `light` and `dark` themes. Your choice is remembered in a cookie.

--- right ---

## Made for editing

Pages are Markdown files with a small YAML header. Add a file to `site/pages` and it
becomes a page; add a dated file to `site/pages/blog` and it becomes a blog post.
Layouts are Twig templates in `site/themes`, assets are published automatically to
`web/assets`.

The styling is plain, dependency-free CSS using custom properties. There is no Pure
CSS, no framework and no external icon font to load.

--- footer ---

### Start with the basics

Read {{ link_page('getting-started', 'Getting Started') }} to learn where things live,
then browse {{ link_page('blog', 'the blog') }} for longer examples. The
{{ link_page('contact', 'contact page') }} shows the form and captcha in action.
