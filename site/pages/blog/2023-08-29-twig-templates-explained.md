---
title: Twig Templates Explained
layout: post
type: post
date: 2023-08-29
author_id: alex-weber
authors: [Alex Weber]
categories: [Tutorials]
tags: [twig, templates, themes]
abstract: "A guided tour of the Twig layouts in this starter, from the base template to reusable includes and theme inheritance."
---

Templates decide how content looks; Markdown decides what it says. This site keeps
them separate so you can change one without touching the other.

## The base template

Every layout extends `main.twig`, which renders the document head, header, navigation,
footer and the CSS/JS assets. It defines a single `content` block:

```twig
{{ '{%' }} extends "main.twig" {{ '%}' }}

{{ '{%' }} block content {{ '%}' }}
    <div class="container">
        {{ '{{' }} content.default|raw {{ '}}' }}
    </div>
{{ '{%' }} endblock {{ '%}' }}
```

The `content.default` variable holds the rendered Markdown body. Pages can split their
body into named segments with `--- left ---` style markers; `home.twig` uses that to
place two columns.

## Includes keep things dry

The sidebar search, blog navigation and post cards live in `includes/`. Reusing them
from several layouts means a change to a link or class happens in one place:

```twig
{{ '{{' }} include('includes/simplesearch.twig') {{ '}}' }}
```

## Theme inheritance

Herbie looks for a template in the active theme first, then falls back to the parent
listed in `themeParent`. The `dark` theme contains no Twig at all — it
only overrides CSS variables. Copy a template into your theme folder when you need
different markup; everything you leave behind still comes from the parent.

For a hands-on example, read
{{ link_page('blog/2026-04-22-customising-design-tokens', 'Customising Design Tokens') }}.
