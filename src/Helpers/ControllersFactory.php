<?php

namespace App\Helpers;

use App\Controllers\Admin\Admin;
use App\Controllers\Admin\LogIn;
use App\Controllers\Admin\Logout;
use App\Controllers\Admin\Post;
use App\Controllers\Admin\Registration;
use App\Controllers\Admin\User;
use App\Controllers\BaseController;
use App\Controllers\Public\Blogs;
use App\Interfaces\Validator;
use Monolog\Logger;
use Slim\Views\Twig;

class ControllersFactory
{
    private static array $controllers = [
        'blogs.controller'   => Blogs::class,
        'login.controller'   => LogIn::class,
        'rgstr.controller'   => Registration::class,
        'logout.controller'  => Logout::class,
        'admin.controller'   => Admin::class,
        'post.controller'    => Post::class,
        'user.controller'    => User::class
    ];

    public static function controllers_lazy_loader(Twig $view, Logger $logger, Validator $validator): array
    {
        $controllers = [];
        foreach (self::$controllers as $controller_tag => $controller_class) {
            $controllers[$controller_tag] = function () use ($view, $logger, $controller_class, $validator): BaseController {

                return new $controller_class($view, $logger, $validator);
            };
        }

        return $controllers;
    }

}