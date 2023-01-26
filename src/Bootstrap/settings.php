<?php
return [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => true,

        // Renderer settings
        'twig' => [
            'template_path' => APP_ROOT . '/resources/view/templates',
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

        'upload_directory' => APP_ROOT . '/public/resources/images/',

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
