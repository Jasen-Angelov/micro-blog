<?php

namespace App\Helpers;

use App\Controllers\Admin\Admin;
use App\Controllers\Admin\LogIn;
use App\Controllers\Admin\Blog as BlogEdit;
use App\Controllers\BaseController;
use App\Controllers\Public\Blog;
use App\Interfaces\Validator;
use Monolog\Logger;
use Slim\Flash\Messages;
use Slim\Views\Twig;

class ControllersFactory
{
    private static array $controllers = [
        'blog.controller'       => Blog::class,
        'login.controller'      => LogIn::class,
        'admin.controller'      => Admin::class,
        'admin.blog.controller' => BlogEdit::class,
    ];

    public static function controllers_lazy_loader(Twig $view, Logger $logger, Validator $validator, Messages $flash_message): array
    {
        $controllers = [];
        foreach (self::$controllers as $controller_tag => $controller_class) {
            $controllers[$controller_tag] = function () use ($view, $logger, $controller_class, $validator, $flash_message): BaseController {

                return new $controller_class($view, $logger, $validator, $flash_message);
            };
        }

        return $controllers;
    }

}