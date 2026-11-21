---
title: SEO Basics for Flat Sites
layout: post
type: post
date: 2025-07-22
author_id: jane-sample
authors: [Jane Sample]
categories: [Performance]
tags: [seo, performance, content]
abstract: "The metadata, feed and URL choices already built into this starter, plus the few things you should set before a site goes live."
---

A flat-file site can be perfectly searchable without a plugin. Most of the work is in
the layout and in a handful of front matter fields.

## Metadata in the base template

`main.twig` renders a description from `site/data/site.json`, a language attribute,
a `<base>` tag and an Atom feed link. The page title is assembled by `page_title()`
with the site title as a fallback. There is nothing to configure for the basics.

## Descriptions per page

The global description is fine for a demo. On a real site, add a `description` field to
important pages and use it in the layout. Keep it short and specific — it is what
search engines may show under the link.

## Clean routes

Routes come from file names. Prefixes such as `2-features.md` are stripped, so the URL
stays `/features`. Prefer readable names, avoid deep nesting where possible, and keep
old routes as redirects if you rename a page.

## The feed helps too

The {{ link_page('blog/feed.xml', 'Atom feed') }} lists every post with a stable URL and
a date. It is useful for readers and gives crawlers a simple map of your articles.

## Remember the demo header

While the site is a demo, a middleware sends `noindex, nofollow`. Remove it as described
in {{ link_page('blog/2026-10-14-preparing-for-deployment', 'Preparing the Site for Deployment') }}
before you expect traffic.
