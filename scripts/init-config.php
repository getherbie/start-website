<?php

declare(strict_types=1);

$target = __DIR__ . '/../site/config/main.php';
if (is_file($target)) {
    return;
}

$replacements = [
    '<plugin_contact_recipient>' => 'test@example.com',
    '<plugin_contact_csrf_secret>' => bin2hex(random_bytes(16)),
    '<plugin_contact_captcha_secret>' => bin2hex(random_bytes(16)),
    '<plugin_contact_smtp_host>' => 'localhost',
    '<plugin_contact_smtp_username>' => '',
    '<plugin_contact_smtp_password>' => '',
];

file_put_contents(
    $target,
    strtr(
        (string) file_get_contents(__DIR__ . '/../site/config/main.dist.php'),
        $replacements,
    ),
);
