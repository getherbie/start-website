---
title: Twig Macros and Includes
layout: post
type: post
date: 2025-03-14
author_id: alex-weber
authors: [Alex Weber]
categories: [Tutorials]
tags: [twig, templates, content]
abstract: "When to use an include, when a macro is worth it, and how the blog layouts in this starter combine both to avoid duplicated markup."
---

Reuse in Twig is simple, but it helps to pick the right tool. This site uses both
includes and functions; here is how to decide.

## Includes for fragments of markup

An include renders a template with the current context. The post card is a good fit
because it needs a `post` variable but no logic of its own:

```twig
{{ '{{' }} include('includes/post-card.twig', {post: post}) {{ '}}' }}
```

Passing variables explicitly keeps the fragment predictable.

## Macros for small repeated output

A macro behaves like a function that returns markup. Use it when you need the same
snippet with different arguments in many places — a badge, an icon or a formatted
date, for example. Define it once and import it where needed.

## Functions for data

Lists of tags and categories come from the `blog_terms()` Twig function in
`site/extend/twig_functions`. It reads all pages and returns sorted unique values, so
the sidebar stays accurate when you add a post. Data belongs in a function; markup
belongs in an include or macro.

## Keep templates boring

The layouts in this starter are intentionally plain: a few queries, a few includes
and no clever abstractions. When a template gets hard to read, split it rather than
adding another layer. Read
{{ link_page('blog/2023-08-29-twig-templates-explained', 'Twig Templates Explained') }}
for the full picture.
