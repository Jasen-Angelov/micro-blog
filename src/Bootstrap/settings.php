<?php
return [
    'settings' => [
        'displayErrorDetails' => $_ENV['APP_DEBUG'] ?? false, // set to false in production,
        'determineRouteBeforeAppMiddleware' => true,

        // Renderer settings
        'twig' => [
            'template_path' => APP_ROOT . '/resources/view/templates',
            'settings' => [
                'cache' => $_ENV['APP_CACHE'] ?? false,
                'debug' => $_ENV['APP_DEBUG'] ?? false,
            ],
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => APP_ROOT . '/logs/app.log',
        ],

        'upload_directory' => APP_ROOT . '/public/resources/images/',

        'db' => [
            'driver'    => $_ENV['DB_DRIVER'] ?? '',
            'host'      => $_ENV['DB_HOST'] ?? '',
            'database'  => $_ENV['DB_NAME'] ?? '',
            'username'  => $_ENV['DB_USER'] ?? '',
            'password'  => $_ENV['DB_PASSWORD'] ?? '',
            'charset'   => $_ENV['DB_CHARSET'] ?? '',
            'collation' => $_ENV['DB_COLLATION'] ?? '',
            'prefix'    => $_ENV['DB_PREFIX'] ?? '',
        ],
    ],
];
