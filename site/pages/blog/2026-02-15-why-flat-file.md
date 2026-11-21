---
title: Why a Flat-File CMS Works for Small Sites
layout: post
type: post
date: 2026-02-15
author_id: herbie-team
authors: [Herbie Team]
categories: [News]
tags: [herbie, content]
abstract: A look at why this starter uses a flat-file CMS instead of a database, and what that means for editing, version control and backups.
---

Most content management systems store pages in a database. This starter takes a
different route: every page is a Markdown file in `site/pages`. Here is why that
choice shapes the whole project.

## Edit with any text editor

A page is a readable text file with a YAML header and a Markdown body. You can open
it in Vim, VS Code or a plain text editor — there is no admin interface to learn
and no database connection to configure. The {{ link_page('getting-started', 'getting-started guide') }}
walks through the file format.

## Version control becomes trivial

Because content lives in the repository, `git diff` shows exactly what changed in a
page. You can review a post before it goes live, revert a bad edit and branch content
changes the same way you branch code. For a small site this is often more useful than
a revision history buried in a database.

## Backups are just a copy

Backing up the site means copying `site/` and `web/`. There is no dump to schedule,
no table to optimise and no credentials to rotate. Restoring a site is equally
straightforward.

## When a database would be better

Flat files work well when content changes occasionally and the structure is stable.
If you need thousands of entries, user accounts or editorial workflows with multiple
writers editing at the same time, a database-backed CMS will serve you better. For
brochure sites, documentation and small blogs like this one, the simplicity wins.

The blog itself demonstrates the approach: each post, author and tag is a normal page.
Browse the {{ link_page('blog/archive', 'archive') }} to see how they fit together.
