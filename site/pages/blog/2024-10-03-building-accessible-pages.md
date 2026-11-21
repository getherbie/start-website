---
title: Building Accessible Pages
layout: post
type: post
date: 2024-10-03
author_id: jane-sample
authors: [Jane Sample]
categories: [Design]
tags: [accessibility, design, content]
abstract: "The small template decisions in this starter that help keyboard and screen-reader users, and what to keep in mind when editing content."
---

Accessibility is easier when it is part of the default layout rather than an
afterthought. Here are the choices built into these templates.

## Landmarks and skip link

`main.twig` wraps content in a `<main>` element, puts navigation in `<nav>` and footer
content in `<footer>`. A skip link lets keyboard users jump straight to the content:

```html
<a class="skip-link" href="#content">Skip to content</a>
```

It is visually hidden until focused, so it does not affect the design.

## Focus styles and labels

Every interactive element gets a visible `:focus-visible` outline. Form controls have
labels — the sidebar search uses a visually hidden label because the placeholder alone
is not enough. The theme switcher is a labelled group of links with `aria-current` on
the active theme.

## Content habits

When you write a post, use headings in order, describe links instead of saying "click
here", and add alternative text to images. The markdown plugin passes attributes
through, so you can be as descriptive as needed.

## Test with a keyboard

Unplug the mouse and tab through the home page, a blog post and the contact form. If
you can reach everything and always see where you are, the basics are in place.
