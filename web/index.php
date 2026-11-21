<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use herbie\Application;
use herbie\ApplicationPaths;

// Serve image files from site/media at /media/... like ordinary static images.
$mediaPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
$mediaTypes = [
    'gif' => 'image/gif',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'png' => 'image/png',
    'svg' => 'image/svg+xml',
    'webp' => 'image/webp',
];
if (is_string($mediaPath) && str_starts_with($mediaPath, '/media/')) {
    $mediaRoot = realpath(dirname(__DIR__) . '/site/media');
    $mediaFile = realpath(dirname(__DIR__) . '/site' . $mediaPath);
    $extension = $mediaFile !== false ? strtolower(pathinfo($mediaFile, PATHINFO_EXTENSION)) : '';
    if (
        $mediaRoot !== false && $mediaFile !== false
        && str_starts_with($mediaFile, $mediaRoot . DIRECTORY_SEPARATOR)
        && is_file($mediaFile) && isset($mediaTypes[$extension])
    ) {
        header('Content-Type: ' . $mediaTypes[$extension]);
        readfile($mediaFile);
        exit;
    }
}

herbie\handle_internal_webserver_assets(__FILE__);

$app = new Application(
    new ApplicationPaths(
        dirname(__DIR__)
    )
);

$app->run();
