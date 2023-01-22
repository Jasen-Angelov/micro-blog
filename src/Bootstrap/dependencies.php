<?php

use App\Helpers\ControllersFactory;
use App\Helpers\InputValidator;
use App\Interfaces\Validator;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

if (isset($app)) {
    $container = $app->getContainer();
}

$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

$container['view'] = function ($container): Twig {
    $view = new Twig( $container->get('settings')['twig']['template_path'], $container->get('settings')['twig']['settings']);

    $view->addExtension(new TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

$container['db'] = function ($container) {
    $capsule = new Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container['validator'] = function (): Validator {
    return new InputValidator();
};

// Inject controllers callables into the container
$controllers = ControllersFactory::controllers_lazy_loader($container->get('view'), $container->get('logger'), $container->get('validator'));
foreach ($controllers as $controller_tag => $controller_callback) {
    $container[$controller_tag] = $controller_callback;
}
