---
title: Organising Pages and Front Matter
layout: post
type: post
date: 2026-07-28
author_id: jane-doe
authors: [Jane Doe]
categories: [Tutorials]
tags: [markdown, content]
abstract: Practical tips for naming page files, using numeric prefixes for ordering and choosing the front matter fields that matter.
---

A page in this kickstarter is one Markdown file. A few conventions make a growing
`site/pages` folder easy to navigate.

## Numeric prefixes control order

Files like `2-features.md` and `9-contact.md` keep the navigation in a predictable
order. Herbie strips the prefix when building the route, so `2-features.md` is
served at `/features`. Leave gaps in the numbering — adding a page later should not
require renumbering everything.

Subfolders become route segments: `site/pages/blog/author/jane-doe.md` is reachable
at `/blog/author/jane-doe`.

## Fields you will use often

```markdown
---
title: A readable page title
layout: post
type: post
date: 2026-07-28
abstract: A short summary for lists and feeds.
hidden: true
no_search: true
cached: false
---
```

`title` is required. `layout` selects a Twig template in `site/themes/default`;
without it, `default.twig` is used. `abstract` appears on blog cards and in the feed.
`hidden` keeps utility pages out of menus, `no_search` keeps them out of the search
index, and `cached: false` is important for pages with forms such as contact and
search.

## Custom fields are free-form

The blog adds `author_id`, `authors`, `categories` and `tags` in the same header.
Herbie exposes them to Twig as `page.author_id` or `post.tags`, and the query builder
can filter on them. Add your own fields the same way — no schema changes needed.

## Keep bodies readable

Write headings, lists and code blocks in ordinary Markdown. Use
`{{ '{{' }} link_page('about', 'about this site') {{ '}}' }}` when you want a link that
keeps working if a route changes. The
{{ link_page('getting-started', 'getting-started guide') }} has a complete page
example you can copy.
