---
title: Choosing a Theme
layout: post
type: post
date: 2026-03-04
author_id: jane-sample
authors: [Jane Sample]
categories: [Design]
tags: [themes, design]
abstract: How the seven bundled themes work, what theme inheritance means in Herbie and how to add your own colour scheme or a complete new design.
---

A starter should look decent on the first launch and still be easy to change
later. This site ships with seven themes: `default`, `dark`, `journal`,
`spotlight`, `docs`, `portfolio` and `high-contrast`. Use the switcher in the bottom-right corner to compare
them without touching any code.

## One set of templates

Five of the seven themes share the same Twig layouts. Every child theme has `default` as its
`themeParent`, so Herbie looks for a template in the active theme first and falls
back to the default theme when it is not there. The result is that a child theme can
be as small as a single CSS file — or as large as a whole new design.

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
stylesheet, so the themes cannot drift apart. `high-contrast` goes the same way:
its palette is tokens, with a few extra rules for underlined links, strong borders
and thick focus rings. It changes no markup, so accessibility stays a variant and
not a second design.

## A theme with its own design

`journal` shows the other end of the scale. It keeps the Twig layouts and adds its
serif typography, hairline rules, drop cap and centred reading column in
`css/extensions.css`, which is loaded after the shared base stylesheet. Its
`css/theme.css` supplies the matching warm paper-and-ink palette. Because
`@theme/` assets fall back to the parent, the small navigation script still comes
from `default` without being copied.

`spotlight` takes the same route in the opposite direction. It is inspired by
Ghost's Casper theme: bold sans typography, a dark gradient cover hero and a card
grid of posts. The "images" in the cards are pure CSS gradients, varied by
position, so the theme adds no external assets. Post pages get a narrow reading
column.

`docs` goes one step further and overrides `main.twig` as well. Inspired by Doks,
it adds a top bar and a fixed navigation rail; the individual page layouts are
still inherited. That covers the site shell.

`portfolio` covers the other level. It overrides `home.twig` with a project grid
and restyles the shared header, hero and cards in `css/extensions.css`, so every
page gets a dark gallery look while the navigation and footer markup still come
from `default`. Together, `docs` and `portfolio` show the full theme mechanism:
tokens, extensions, shell markup and page markup.

So "theme" can mean two things here: a colour scheme over the shared design, or a
design of its own that merely extends the markup.

## Adding your own theme

Create a folder under `site/themes`, add a `css/theme.css` with your overrides and
add the folder name to `themes` in `site/data/site.json`. Add `css/extensions.css`
for extra layout or typography rules; without it the hook from `default` is
inherited. The switcher and the validation in `site/config/main.php` both read that
list, so the new theme is available immediately.

If you need different markup, copy a Twig template into your theme folder and edit
it there. The parent theme keeps working as a fallback for everything you did not
copy. If you want a folder that stands on its own, run
`php vendor/bin/herbie export-theme <name>`: it writes a complete copy to
`dist/themes/<name>/`, ready to move into another project.
