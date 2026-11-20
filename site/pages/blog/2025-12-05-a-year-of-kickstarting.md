---
title: A Year of Kickstarting
layout: post
type: post
date: 2025-12-05
author_id: herbie-team
authors: [Herbie Team]
categories: [Community]
tags: [kickstarter, community, updates]
abstract: "What the example site gained in its first full year, and the principles that kept it small while the blog and theme system grew."
---

Looking back at the last twelve months, the kickstarter changed more than we expected
— and less than a typical website project.

## What grew

The blog went from a handful of posts to a small library with authors, categories,
tags and an archive. The theme switcher arrived, followed by two child themes and a
set of CSS custom properties. Search and contact moved from bare plugin output to
styled, accessible components.

## What stayed the same

Every page is still a Markdown file. There is no build step, no database and no admin
interface. You can clone the repository, run one command and start editing. That
property mattered more than any feature we added.

## Lessons learned

* Keep generated directories out of Git and safe to delete.
* Put shared markup in includes so themes cannot drift apart.
* Write real example text — placeholder content hides layout problems.
* Document the small conventions, such as numeric prefixes and hidden pages.

## Thanks

To everyone who tried the kickstarter and sent a note: the practical questions were
the best guide for what to write here. More examples are on the way; see the
{{ link_page('blog/archive', 'archive') }} for everything published so far.
