---
title: Local Development with Docker
layout: post
type: post
date: 2026-06-11
author_id: herbie-team
authors: [Herbie Team]
categories: [Tutorials]
tags: [docker, development]
abstract: How to run the starter with Docker Compose, where to find the generated assets and how to reset a local installation.
---

The repository ships with a Docker Compose setup so you can start the site without
installing PHP locally.

## Start and stop

From the project root:

```bash
docker compose up website
```

Open <http://localhost:8888>. Press `Ctrl+C` to stop the container. To run it in the
background, add `-d` and use `docker compose down` when you are finished.

## What the container does

PHP serves `web/index.php`, and Herbie reads content from `site/`. Twig templates
are compiled into `site/runtime`, CSS and JavaScript are published from
`site/themes` into `web/assets`, and the imagine plugin writes image variants to
`web/cache`. All three are generated directories — you never edit them by hand.

## Reset generated files

If a template or stylesheet change does not show up, remove the generated files and
reload the page:

```bash
rm -rf site/runtime/* web/assets/themes/* web/cache/*
```

Herbie recreates what it needs on the next request. Your Markdown content and theme
sources are untouched.

## Without Docker

If you prefer a local PHP installation, run:

```bash
composer install
cd web
php -S localhost:8888 index.php
```

This uses PHP's built-in server. It is fine for development; for production, point
a real web server at the `web/` directory.

## Debugging

The default error layout hides stack traces unless debug mode is enabled in the CMS
configuration. The log file at `site/runtime/log/logger.log` is the first place to
look when a page renders unexpectedly.
