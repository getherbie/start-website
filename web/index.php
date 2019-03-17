<?php

/**
 * This file is part of Herbie.
 *
 * (c) Thomas Breuss <www.tebe.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (php_sapi_name() == 'cli-server') {
    if (preg_match('/\.(?:js|css|gif|jpg|jpeg|png)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}

use herbie\Application;

require_once(__DIR__ . '/../vendor/autoload.php');

define('HERBIE_DEBUG', true);

$app = new Application('../site');
$app->run();
