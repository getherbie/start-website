<?php

declare(strict_types=1);

/**
 * Absolute canonical URL of the current page. The script name is stripped so
 * /index.php/my-page and /my-page resolve to the same URL. Presentation-only
 * parameters such as `theme` are dropped, pagination is kept.
 */
return [
    'canonical_url',
    static function (): string {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
        $path = is_string($path) && $path !== '' ? $path : '/';

        $script = $_SERVER['SCRIPT_NAME'] ?? '';
        if (is_string($script) && $script !== '') {
            if ($path === $script) {
                $path = '/';
            } elseif (str_starts_with($path, $script . '/')) {
                $path = substr($path, strlen($script));
            }
        }

        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        if (!is_string($host) || preg_match('/^[a-zA-Z0-9.:\[\]-]+$/', $host) !== 1) {
            $host = 'localhost';
        }
        $https = (($_SERVER['HTTPS'] ?? '') !== '' && $_SERVER['HTTPS'] !== 'off')
            || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
        $url = ($https ? 'https' : 'http') . '://' . $host . $path;

        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        if (is_int($page) && $page > 1) {
            $url .= '?page=' . $page;
        }

        return $url;
    },
];
