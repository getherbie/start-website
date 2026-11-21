<?php

// The active theme can be changed with the theme switcher in the bottom-right corner.
// The choice is stored in a cookie so it survives navigation and reloads.
$siteData = json_decode((string)@file_get_contents(__DIR__ . '/../data/site.json'), true);
$themes = is_array($siteData) && isset($siteData['themes']) && is_array($siteData['themes'])
    ? array_values(array_filter($siteData['themes'], is_string(...)))
    : ['default'];

$theme = 'default';
if (isset($_GET['theme']) && is_string($_GET['theme']) && in_array($_GET['theme'], $themes, true)) {
    $theme = $_GET['theme'];
    if (!headers_sent()) {
        $cookiePath = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
        setcookie('herbie_theme', $theme, [
            'expires' => time() + 60 * 60 * 24 * 365,
            'path' => $cookiePath === '' || $cookiePath === '/' ? '/' : rtrim($cookiePath, '/'),
            'samesite' => 'Lax',
        ]);
    }
} elseif (isset($_COOKIE['herbie_theme']) && is_string($_COOKIE['herbie_theme']) && in_array($_COOKIE['herbie_theme'], $themes, true)) {
    $theme = $_COOKIE['herbie_theme'];
}

return [
    'language' => 'en',
    'locale' => 'en_EN',
    'theme' => $theme,
    // `default` is the shared source theme: layouts, JavaScript and the base
    // stylesheet live here, child themes add only what differs.
    // The export-theme Herbie command materialises a standalone copy for 1:1 reuse.
    'themeParent' => 'default',
    'enabledPlugins' => 'twig,markdown,imagine,search,contact,blog',
    'plugins' => [
        'markdown' => [
            'flavor' => 'gfm',
        ],
        'contact' => [
            'recipient' => getenv('HERBIE_CONTACT_RECIPIENT') ?: 'blackhole@example.com',
            'csrf' => [
                'secret' => getenv('HERBIE_CONTACT_CSRF_SECRET') ?: 'start-website-csrf-secret-change-me',
            ],
            'captcha' => [
                'secret' => getenv('HERBIE_CONTACT_CAPTCHA_SECRET') ?: 'start-website-captcha-secret-change-me',
            ],
        ],
    ],
    'components' => [
        'urlManager' => [
            'niceUrls' => false,
            // Virtual blog routes are rendered by site/extend/plugins/blog.
            'rules' => [
                ['blog/author/{author}', 'blog'],
                ['blog/tag/{tag}', 'blog'],
                ['blog/category/{category}', 'blog'],
                ['blog/{section}', 'blog', ['section' => 'archive|author|tag|category']],
            ],
        ]
    ]
];
