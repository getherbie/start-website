<?php

declare(strict_types=1);

/**
 * Returns the sorted, unique values of a page field used by blog posts,
 * e.g. blog_terms(site.page_list, 'tags').
 */
return [
    'blog_terms',
    function (iterable $pages, string $field): array {
        $terms = [];
        foreach ($pages as $page) {
            if (($page['type'] ?? '') !== 'post' || !isset($page[$field])) {
                continue;
            }
            foreach ((array)$page[$field] as $value) {
                if (is_scalar($value) && (string)$value !== '') {
                    $terms[(string)$value] = true;
                }
            }
        }
        $result = array_keys($terms);
        sort($result, SORT_NATURAL | SORT_FLAG_CASE);
        return $result;
    },
];
