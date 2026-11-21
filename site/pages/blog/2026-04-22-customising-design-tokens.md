---
title: Customising Design Tokens
layout: post
type: post
date: 2026-04-22
author_id: jane-sample
authors: [Jane Sample]
categories: [Design]
tags: [themes, design]
abstract: A hands-on guide to changing colours, spacing and typography across all themes by editing a handful of CSS custom properties.
---

The stylesheet in `site/themes/default/css/styles.css` defines the visual language
once, as CSS custom properties. Change a value there and every layout picks it up.
The bundled `dark` theme does exactly that in its own `css/theme.css`.

## Find the token you need

Open `styles.css` and look at the `:root` block near the top. Colours are grouped by
purpose rather than by appearance:

```css
:root {
    --page-bg: #ffffff;
    --surface: #ffffff;
    --text: #5f5c52;
    --heading: #423f37;
    --accent: #bb2222;
}
```

Use `--text` for body copy, `--heading` for titles, `--surface` for cards and
`--accent` for links and active states. This keeps changes consistent — you do not
have to hunt through the file for every red link.

## Override in a child theme

Create `site/themes/mytheme/css/theme.css` with only the values you want to change:

```css
:root {
    --page-bg: #fbfaf7;
    --accent: #2f6f4e;
    --accent-hover: #235438;
    --hero-bg: #e5f2ea;
}
```

Add `mytheme` to the `themes` list in `site/data/site.json` and it appears in the
theme switcher immediately. Layouts, spacing and typography stay in the parent
stylesheet, so your theme cannot drift away from the others.

## Tokens used by plugins

The contact plugin reads a few variables with fallbacks: `--surface`, `--text`,
`--accent-button` and `--border`. Define them in your theme to give the form the
same look as the rest of the site. The search plugin uses only the standard classes
and needs no extra tokens.

## Check the result

Switch between themes with the button in the bottom-right corner and look at a page with a form, a code block and
a blog post. The {{ link_page('contact', 'contact page') }} and any
{{ link_page('blog', 'article') }} are good places to spot a token you missed.
