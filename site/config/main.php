<?php

return [
    'language' => 'en',
    'locale' => 'en_EN',
    'enabledPlugins' => 'twig,markdown,imagine,search,contact',
    'plugins' => [
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
        ]
    ]
];
