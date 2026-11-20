---
title: Choosing a Theme
layout: post
type: post
date: 2026-03-04
author_id: jane-doe
authors: [Jane Doe]
categories: [Design]
tags: [themes, design]
abstract: How the three bundled themes work, what theme inheritance means in Herbie and how to add your own colour scheme in a few lines.
---

A kickstarter should look decent on the first launch and still be easy to change
later. This site ships with three themes: `default`, `light` and `dark`. Use the
switcher in the header to compare them without touching any code.

## One set of templates

All three themes share the same Twig layouts. `light` and `dark` are child themes:
their `themeParent` is `default`, so Herbie looks for a template in the active theme
first and falls back to the default theme when it is not there. The result is that
a child theme can be as small as a single CSS file.

## Colours are custom properties

The base stylesheet defines the colours once as CSS custom properties, for example
`--page-bg`, `--text`, `--accent` and `--footer-bg`. A child theme overrides only
the values it wants to change:

```css
:root {
    color-scheme: dark;
    --page-bg: #16181d;
    --text: #d7d9de;
    --accent: #ff7a6b;
}
```

That is the whole dark theme. Layouts, spacing and typography stay in the parent
stylesheet, so the themes cannot drift apart.

## Adding your own theme

Create a folder under `site/themes`, add a `css/theme.css` with your overrides and
add the folder name to `themes` in `site/data/site.json`. The switcher and the
validation in `site/config/main.php` both read that list, so the new theme is
available immediately.

If you need different markup, copy a Twig template into your theme folder and edit
it there. The parent theme keeps working as a fallback for everything you did not
copy.
