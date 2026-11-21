---
title: The First Release
layout: post
type: post
date: 2023-04-18
author_id: robin-starter
authors: [Robin Starter]
categories: [News]
tags: [starter, herbie, updates]
abstract: "A short history of this starter and what the first release set out to solve for small Herbie sites."
---

It started with a repeated task: every time we built a small website with Herbie CMS,
we copied the same pages, layouts and plugins into a new repository. This starter
is the result of that repetition — a working site you can fork and edit instead of an
empty folder.

## What the first version included

The initial release was deliberately small: a home page, an about page, a contact form
with a CSRF token, a search page and a single theme. The goal was not to impress but
to give you a site that already worked on the first launch.

## What changed since

Over time we added example content, a blog with authors and tags, a theme switcher and
a dependency-free stylesheet. Each addition followed the same rule: if you can remove
it with a single file deletion, it belongs here.

## Where it goes next

The project stays intentionally modest. More posts, better examples and clearer
documentation are planned; a build pipeline, a database and an admin interface are
not. If you want to see where things live, start with the
{{ link_page('getting-started', 'getting-started guide') }}.
