---
title: About
---

# About Herbie Website Starter

This site is the starting point for small Herbie CMS websites. It is intentionally
modest: a handful of pages, a blog and a few plugins, all wired together so you can
see a complete site before you change anything.

## Why Herbie?

[Herbie](https://herbie.tebe.ch) is a flat-file CMS. Content is stored in readable
text files, templates are written in Twig, and there is no database to install or
back up. This makes it a good fit for brochure sites, documentation and blogs that
change more often than they grow.

## What this example demonstrates

* Markdown front matter with custom fields such as `type`, `author_id`, `tags` and
  `abstract`.
* Twig layouts that query pages with Herbie's `query()` function.
* Theme inheritance: `light` and `dark` contain only CSS variable overrides.
* A cookie-based theme switcher that works without reloading page content.
* A contact form with CSRF token and ALTCHA captcha and a site-wide search.

## Credits and links

* {{ link_page('https://github.com/getherbie/herbie', 'Herbie CMS on GitHub', {target: '_blank'}) }}
* {{ link_page('https://herbie.tebe.ch', 'Herbie CMS website', {target: '_blank'}) }}
* {{ link_page('https://github.com/getherbie/start-website', 'Herbie Website Starter on GitHub', {target: '_blank'}) }}

If you want to meet the people behind the example posts, have a look at the
{{ link_page('blog/author', 'author profiles') }}.
