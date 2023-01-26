<?php

use Slim\App;
define('APP_ROOT', dirname(__DIR__));

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = APP_ROOT . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require APP_ROOT . '/vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require APP_ROOT . '/src/Bootstrap/settings.php';
$app = new App($settings);

// Set up dependencies
require APP_ROOT . '/src/Bootstrap/dependencies.php';

// Register middleware
require APP_ROOT . '/src/Bootstrap/middleware.php';

// Register routes
require APP_ROOT . '/src/Bootstrap/routes.php';

// Run app
$app->run();
