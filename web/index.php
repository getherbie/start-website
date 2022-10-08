<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use herbie\Application;

herbie\handle_internal_webserver_assets(__FILE__);

define('HERBIE_DEBUG', true);

$app = new Application(
    dirname(__DIR__),
    dirname(__DIR__) . '/site'
);

$app->run();
