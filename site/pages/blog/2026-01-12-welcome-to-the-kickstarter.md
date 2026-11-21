---
title: Welcome to Herbie Website Starter
layout: post
type: post
date: 2026-01-12
author_id: herbie-team
authors: [Herbie Team]
categories: [News]
tags: [starter, herbie]
abstract: A quick tour of what you get when you create a site from Herbie Website Starter and how the example content is organised.
---

Welcome! This site is more than an empty skeleton. It is a small, working website
that you can use as the starting point for your own project. You get example pages,
a contact form, site search, seven themes and a blog — all built with Herbie CMS and
plain text files.

## No database, no build step

Every page is a Markdown file in `site/pages`. The file name becomes the route, the
YAML header at the top holds the title and other properties, and the rest is the
body. Edit a file, refresh the page, and you are done.

Layouts live in `site/themes/default` and are written in Twig. Herbie renders the
page content into the layout, adds CSS and JavaScript assets and publishes them to
`web/assets` automatically.

## The blog is made of pages too

Blog posts are normal pages with a few extra properties:

```markdown
---
title: My first post
layout: post
type: post
date: 2026-01-12
author_id: herbie-team
categories: [News]
tags: [herbie]
abstract: A short summary for list pages.
---
```

The `type: post` property is what makes the blog layouts pick the page up. Authors,
categories and tags are pages as well, so the whole blog is just a folder of text
files. The {{ link_page('getting-started', 'getting-started guide') }}
shows the full file layout.

## Make it yours

Start by changing the text in `site/pages/index.md` and the navigation in
`site/data/menu.json`. Then try the theme switcher in the bottom-right corner: `dark` is a small
child theme that only overrides CSS custom properties, while `journal`, `spotlight`
and `docs` add their own styles for completely different looks. `portfolio` even
ships its own `home.twig` with a project grid.
