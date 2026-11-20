---
title: Fast by Default
layout: post
type: post
date: 2024-06-12
author_id: alex-weber
authors: [Alex Weber]
categories: [Performance]
tags: [performance, assets, themes]
abstract: "How this kickstarter keeps requests small without a build step, and which generated files you can safely delete when testing."
---

There is no bundler in this project. That is a deliberate performance choice: fewer
moving parts, fewer things to break and no JavaScript framework to download.

## Small, cacheable assets

The theme publishes one stylesheet and one small script. Both are plain files under
`web/assets/themes`, so a web server can cache them with simple headers. The stylesheet
uses custom properties instead of duplicated rules; child themes add only a few lines.

## No external requests

Fonts come from the system stack, icons are inline SVG in the header, and nothing is
loaded from a CDN. A page request therefore stays on your domain — useful for privacy
and for sites on slow connections.

## Generated files

Herbie writes compiled templates to `site/runtime`, published assets to `web/assets`
and image variants to `web/cache`. These directories are safe to delete: the next
request recreates what is needed. See
{{ link_page('blog/2026-06-11-local-development-with-docker', 'Local Development with Docker') }}
for the exact commands.

## Measure before optimising

Before adding a cache layer or a minifier, look at what is actually slow. A flat-file
site with a few dozen pages is usually limited by the web server and network, not by
Twig. Keep the setup simple until measurements say otherwise.
