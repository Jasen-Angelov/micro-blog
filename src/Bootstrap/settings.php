<?php
return [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,

        // Renderer settings
        'twig' => [
            'template_path' => dirname(__DIR__, 2) . '/resources/view/templates',
            'settings' => [
                'cache' => false,
                'debug' => true,
            ],
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => APP_ROOT . '/logs/app.log',
        ],

        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'micro_blog',
            'username' => 'root',
            'password' => 'root',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ],
];
