<?php

use App\Helpers\ControllersFactory;
use App\Helpers\InputValidator;
use App\Interfaces\Validator;
use Illuminate\Database\Capsule\Manager;
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

$container['flash'] = function (){
  return new Slim\Flash\Messages();
};

$container['view'] = function ($container): Twig {
    $view = new Twig( $container->get('settings')['twig']['template_path'], $container->get('settings')['twig']['settings']);
    $view->addExtension(new TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    //Adds the flash message bag as global.
    $view->getEnvironment()->addGlobal('flash', $container->get('flash'));

    return $view;
};

$container['validator'] = function (): Validator {
    return new InputValidator();
};

// Inject controllers callables into the container
$controllers = ControllersFactory::controllers_lazy_loader(
    $container->get('view'),
    $container->get('logger'),
    $container->get('validator'),
    $container->get('flash'),
);
foreach ($controllers as $controller_tag => $controller_callback) {
    $container[$controller_tag] = $controller_callback;
}

// Eloquent ORM
$capsule = new Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
