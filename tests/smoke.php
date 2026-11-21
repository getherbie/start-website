<?php

declare(strict_types=1);

/**
 * Smoke tests for routes, theme switcher, imagine cache, rendered links and
 * standalone theme exports.
 *
 * Start the site from the web directory, then run `php tests/smoke.php`.
 * SMOKE_BASE_URL can point the checks at a different address.
 */

$base = rtrim((string)(getenv('SMOKE_BASE_URL') ?: 'http://127.0.0.1:8888'), '/');
$root = dirname(__DIR__);
$siteData = json_decode((string)file_get_contents($root . '/site/data/site.json'), true);
$themes = $siteData['themes'] ?? [];

$failures = [];
$checks = 0;
$check = static function (bool $ok, string $message) use (&$failures, &$checks): void {
    $checks++;
    if (!$ok) {
        $failures[] = $message;
        echo 'FAIL ' . $message . PHP_EOL;
    }
};

function fetch(string $url): array
{
    $context = stream_context_create(['http' => ['ignore_errors' => true, 'timeout' => 15]]);
    $body = @file_get_contents($url, false, $context);
    $headers = $http_response_header ?? [];
    $status = 0;
    $contentType = '';
    foreach ($headers as $header) {
        if (preg_match('#^HTTP/\S+\s+(\d{3})#', $header, $matches)) {
            $status = (int)$matches[1];
        }
        if (stripos($header, 'content-type:') === 0) {
            $contentType = trim(substr($header, strpos($header, ':') + 1));
        }
    }

    return [$status, $body === false ? '' : $body, $contentType];
}

function siteUrl(string $base, string $route, string $theme): string
{
    $separator = str_contains($route, '?') ? '&' : '?';

    return $base . $route . $separator . 'theme=' . rawurlencode($theme);
}

function queryOf(string $url): array
{
    $decoded = html_entity_decode($url, ENT_QUOTES | ENT_HTML5);
    $query = parse_url($decoded, PHP_URL_QUERY) ?: '';
    parse_str($query, $params);

    return $params;
}

function relativeFiles(string $dir): array
{
    if (!is_dir($dir)) {
        return [];
    }
    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $files[] = substr($file->getPathname(), strlen(rtrim($dir, '/')) + 1);
        }
    }
    sort($files);

    return $files;
}

function removeTree(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST,
    );
    foreach ($iterator as $entry) {
        $entry->isDir() ? rmdir($entry->getPathname()) : unlink($entry->getPathname());
    }
    rmdir($dir);
}

$routes = [
    '/index.php/',
    '/index.php/getting-started',
    '/index.php/features',
    '/index.php/about',
    '/index.php/blog',
    '/index.php/blog?page=2',
    '/index.php/blog/author/alex-example',
    '/index.php/blog/author/jane-sample',
    '/index.php/blog/author/robin-starter',
    '/index.php/blog/category/herbie',
    '/index.php/blog/tag/twig',
    '/index.php/blog/archive',
    '/index.php/search?q=theme',
    '/index.php/contact',
    '/index.php/blog/feed.xml',
];

foreach ($themes as $theme) {
    foreach ($routes as $route) {
        [$status, $body, $contentType] = fetch(siteUrl($base, $route, $theme));
        $check($status === 200, "$theme $route: HTTP $status");
        if (str_contains($contentType, 'text/html')) {
            $check(!str_contains($body, '](<span class="link'), "$theme $route: rendered Markdown links");
        }
    }
}

[$feedStatus, $feedBody, $feedType] = fetch(siteUrl($base, '/index.php/blog/feed.xml', $themes[0]));
$check(str_contains($feedType, 'application/atom+xml'), "feed content type: $feedType");
$check(str_starts_with(ltrim($feedBody), '<?xml'), 'feed body starts with XML declaration');

$switchRoutes = [
    '/index.php/blog?page=2' => ['page' => '2'],
    '/index.php/blog/author/alex-example' => [],
    '/index.php/blog/author/robin-starter' => [],
    '/index.php/search?q=theme' => ['q' => 'theme'],
];
foreach ($themes as $theme) {
    foreach ($switchRoutes as $route => $expectedQuery) {
        [, $html] = fetch(siteUrl($base, $route, $theme));
        preg_match_all('/class="theme-switcher__link(?: is-active)?"\s+href="([^"]+)"/', $html, $matches);
        $links = array_map(static fn(string $href): string => html_entity_decode($href, ENT_QUOTES | ENT_HTML5), $matches[1]);

        $linkThemes = array_map(static fn(string $href): ?string => queryOf($href)['theme'] ?? null, $links);
        sort($linkThemes);
        $expectedThemes = $themes;
        sort($expectedThemes);
        $check($linkThemes === $expectedThemes, "$theme $route: switcher lists every theme");

        preg_match('/class="theme-switcher__link is-active" href="([^"]+)"/', $html, $active);
        if (!isset($active[1])) {
            $check(false, "$theme $route: switcher has one active theme");
            continue;
        }
        $href = html_entity_decode($active[1], ENT_QUOTES | ENT_HTML5);
        $check(parse_url($href, PHP_URL_PATH) === parse_url($route, PHP_URL_PATH), "$theme $route: switcher keeps the path");
        $query = queryOf($href);
        $check(($query['theme'] ?? null) === $theme, "$theme $route: switcher marks the active theme");
        foreach ($expectedQuery as $key => $value) {
            $check(($query[$key] ?? null) === $value, "$theme $route: switcher keeps $key");
        }
    }
}

foreach ($themes as $theme) {
    [, $html] = fetch(siteUrl($base, '/index.php/', $theme));
    preg_match_all('/class="theme-switcher__description">([^<]+)</', $html, $descriptions);
    $check(count($descriptions[1]) === count($themes), "$theme: switcher describes every theme");
    $check(
        !array_filter($descriptions[1], static fn(string $text): bool => trim($text) === ''),
        "$theme: switcher descriptions are not empty",
    );

    preg_match_all('/class="theme-switcher__download" href="([^"]+)"/', $html, $downloads);
    $downloadPaths = array_map(
        static fn(string $href): string => (string)parse_url(html_entity_decode($href, ENT_QUOTES | ENT_HTML5), PHP_URL_PATH),
        $downloads[1],
    );
    sort($downloadPaths);
    $expectedPaths = array_map(static fn(string $name): string => '/index.php/theme-download/' . $name, $themes);
    sort($expectedPaths);
    $check($downloadPaths === $expectedPaths, "$theme: switcher offers a download for every theme");
}

$footerData = json_decode((string)file_get_contents($root . '/site/data/footer.json'), true);
foreach (['explore', 'project', 'docsMore', 'blogMore'] as $group) {
    $check(is_array($footerData[$group] ?? null), "footer data has a $group list");
}
$externalTargets = count(array_filter(
    $footerData['project'] ?? [],
    static fn(array $item): bool => ($item['target'] ?? null) === '_blank',
));

foreach ($themes as $theme) {
    [, $html] = fetch(siteUrl($base, '/index.php/', $theme));
    if ($theme === 'docs') {
        preg_match('/docs-sidebar__title">More<\/p>\s*<ul class="site-nav__list">(.*?)<\/ul>/s', $html, $block);
        $check(isset($block[1]), "$theme: docs sidebar More list renders");
        foreach ($footerData['docsMore'] ?? [] as $item) {
            $check(str_contains($block[1] ?? '', '>' . $item['label'] . '</a>'), "$theme: docs sidebar has {$item['label']}");
        }
        continue;
    }

    preg_match('/<h2>Explore<\/h2>\s*<ul class="footer-links">(.*?)<\/ul>/s', $html, $explore);
    preg_match('/<h2>Project<\/h2>\s*<ul class="footer-links">(.*?)<\/ul>/s', $html, $project);
    $check(isset($explore[1]), "$theme: footer Explore list renders");
    $check(isset($project[1]), "$theme: footer Project list renders");
    foreach (['explore' => $explore[1] ?? '', 'project' => $project[1] ?? ''] as $group => $links) {
        foreach ($footerData[$group] ?? [] as $item) {
            $check(str_contains($links, '>' . $item['label'] . '</a>'), "$theme: footer $group has {$item['label']}");
        }
    }
    $check(substr_count($project[1] ?? '', 'target="_blank"') === $externalTargets, "$theme: external footer links open in a new tab");
}

[, $blogHtml] = fetch(siteUrl($base, '/index.php/blog', $themes[0]));
preg_match('/More from the blog<\/h2>\s*<ul class="widget__list">(.*?)<\/ul>/s', $blogHtml, $blogMore);
$check(isset($blogMore[1]), 'blog sidebar More from the blog list renders');
foreach ($footerData['blogMore'] ?? [] as $item) {
    $check(str_contains($blogMore[1] ?? '', '>' . $item['label'] . '</a>'), "blog sidebar has {$item['label']}");
}

foreach ($themes as $theme) {
    [$status, $body, $contentType] = fetch($base . '/index.php/theme-download/' . $theme);
    $check($status === 200, "theme download $theme: HTTP $status");
    $check(str_contains($contentType, 'application/zip'), "theme download $theme: content type $contentType");
    $check(str_starts_with($body, "PK\x03\x04"), "theme download $theme: ZIP signature");
    $check(str_contains($body, $theme . '/css/theme.css'), "theme download $theme: contains theme.css");
    $check(str_contains($body, $theme . '/css/extensions.css'), "theme download $theme: contains extensions.css");
}
[$unknownStatus] = fetch($base . '/index.php/theme-download/not-a-theme');
$check($unknownStatus === 404, "theme download rejects unknown theme: HTTP $unknownStatus");

[, $gettingStarted] = fetch(siteUrl($base, '/index.php/getting-started', $themes[0]));
preg_match('~<img[^>]+src="([^"]*tulpen[^"]*)"~', $gettingStarted, $image);
$check(isset($image[1]), 'getting-started renders an imagine image');
if (isset($image[1])) {
    $imageUrl = str_starts_with($image[1], 'http') ? $image[1] : $base . '/' . ltrim($image[1], '/');
    [$imageStatus] = fetch($imageUrl);
    $check($imageStatus === 200, "imagine image: HTTP $imageStatus");
}

$distDir = $root . '/dist';
$distThemes = $distDir . '/themes';
if (is_dir($distDir)) {
    $check(false, 'dist/ exists; remove generated exports before running smoke tests');
} else {
    $command = 'cd ' . escapeshellarg($root) . ' && '
        . escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($root . '/vendor/bin/herbie')
        . ' export-theme --all 2>&1';
    exec($command, $output, $exitCode);
    $check($exitCode === 0, 'export-theme --all: ' . implode('; ', $output));

    $baseFiles = relativeFiles($root . '/site/themes/default');
    foreach ($themes as $theme) {
        $expected = array_values(array_unique(array_merge($baseFiles, relativeFiles($root . '/site/themes/' . $theme))));
        sort($expected);
        $check(relativeFiles($distThemes . '/' . $theme) === $expected, "$theme export contains the merged theme files");
    }
    removeTree($distDir);
}

printf("%d checks, %d failure(s)%s", $checks, count($failures), PHP_EOL);
if ($failures !== []) {
    exit(1);
}
echo 'Smoke tests passed.' . PHP_EOL;
