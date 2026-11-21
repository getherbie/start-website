<?php

declare(strict_types=1);

/**
 * Builds a theme switch link for the current URL, keeping query parameters
 * such as pagination and search terms. The request path is used instead of
 * site.route because the latter is the rewritten route (e.g. `blog` on an
 * author page) and would lose the address of the page being viewed.
 */
return [
    'theme_switch_url',
    static function (string $theme): string {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '/';
        $query = $_GET;
        $query['theme'] = $theme;

        return $path . '?' . http_build_query($query);
    },
];
