<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use herbie\Application;
use herbie\ApplicationPaths;

herbie\handle_internal_webserver_assets(__FILE__);

$app = new Application(
    new ApplicationPaths(
        dirname(__DIR__)
    )
);

$app->run();
