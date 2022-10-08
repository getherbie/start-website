<?php

/**
 * This file is part of Herbie.
 *
 * (c) Thomas Breuss <www.tebe.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(__DIR__ . '/../vendor/autoload.php');

use herbie\Application;

herbie\handle_internal_webserver_assets(__FILE__);

define('HERBIE_DEBUG', true);

$app = new Application(
    dirname(__DIR__) . '/site',
    dirname(__DIR__) . '/vendor'
);

$app->run();
