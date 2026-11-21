<?php

declare(strict_types=1);

/**
 * Returns the sanitized page number from ?page=…, starting at 1.
 */
return [
    'blog_page_number',
    static function (): int {
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        return max(1, is_int($page) ? $page : 0);
    },
];
