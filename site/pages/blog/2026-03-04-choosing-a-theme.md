---
title: Choosing a Theme
layout: post
type: post
date: 2026-03-04
author_id: jane-doe
authors: [Jane Doe]
categories: [Design]
tags: [themes, design]
abstract: How the six bundled themes work, what theme inheritance means in Herbie and how to add your own colour scheme or a complete new design.
---

A starter should look decent on the first launch and still be easy to change
later. This site ships with six themes: `default`, `light`, `dark`, `journal`,
`spotlight` and `docs`. Use the switcher in the header to compare them without
touching any code.

## One set of templates

Five of the six themes share the same Twig layouts. Every child theme has `default` as its
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
stylesheet, so the themes cannot drift apart.

## A theme with its own design

`journal` shows the other end of the scale. It keeps the Twig layouts but replaces
`css/styles.css` completely: serif typography, hairline rules instead of cards, a
drop cap on posts, and one centred reading column rather than article plus sidebar.
Its `css/theme.css` supplies the matching warm paper-and-ink palette. Because
`@theme/` assets fall back to the parent, the small navigation script still comes
from `default` without being copied.

`spotlight` takes the same route in the opposite direction. It is inspired by
Ghost's Casper theme: bold sans typography, a dark gradient cover hero and a card
grid of posts. The "images" in the cards are pure CSS gradients, varied by
position, so the theme adds no external assets. Post pages get a narrow reading
column.

`docs` goes one step further and overrides `main.twig` as well. Inspired by Doks,
it adds a top bar and a fixed navigation rail; the individual page layouts are
still inherited. This is the full theme mechanism: tokens, stylesheet, markup.

So "theme" can mean two things here: a colour scheme over the shared design, or a
design of its own that merely reuses the markup.

## Adding your own theme

Create a folder under `site/themes`, add a `css/theme.css` with your overrides and
add the folder name to `themes` in `site/data/site.json`. Add `css/styles.css` too
if you want to change layout or typography. The switcher and the validation in
`site/config/main.php` both read that list, so the new theme is available
immediately.

If you need different markup, copy a Twig template into your theme folder and edit
it there. The parent theme keeps working as a fallback for everything you did not
copy.
