<?php

/**
 * This file is part of Herbie.
 *
 * (c) Thomas Breuss <www.tebe.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use herbie\Application;

require_once(__DIR__ . '/../vendor/autoload.php');

define('HERBIE_DEBUG', true);

$app = new Application('../site');
$app->run();
