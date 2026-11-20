---
title: Writing Posts in Markdown
layout: post
type: post
date: 2026-05-19
author_id: herbie-team
authors: [Herbie Team]
categories: [Tutorials]
tags: [markdown, content]
abstract: A practical guide to the front matter fields used by the blog, from dates and abstracts to authors, categories and tags.
---

Writing a post means creating one Markdown file. The blog layouts do the rest: they
list posts by date, build the archive, group related articles and generate the feed.

## The header

The YAML block between the first two `---` lines describes the post:

```markdown
---
title: Writing Posts in Markdown
layout: post
type: post
date: 2026-05-19
author_id: herbie-team
authors: [Herbie Team]
categories: [Tutorials]
tags: [markdown, content]
abstract: A short summary shown on list pages.
---
```

`title`, `layout`, `type` and `date` are the important ones. `abstract` is used on
the blog index and in the feed. `authors` is a list of display names; `author_id`
links the post to an author profile so the byline can point to it.

## Categories and tags

Both fields are lists. Categories group posts into broad sections such as News or
Tutorials. Tags describe details such as `markdown` or `themes`. Each value has an
archive page under `blog/category` or `blog/tag`; add a small page there when you
introduce a new value, and the links in the post layout will work.

## Body and links

The body is regular Markdown. Headings, lists, code blocks and tables all work. You
can also call Twig functions inside a post, which is how the example pages link to
other parts of the site:

```markdown
Read {{ '{{' }} link_page('blog', 'the blog') {{ '}}' }} for more articles.
```

Use `{{ '{{' }}` and `{{ '}}' }}` when you want to show Twig syntax in a post instead
of executing it.
