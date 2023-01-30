<?php

namespace Helpers;

use App\Controllers\Admin\Admin;
use App\Controllers\Admin\LogIn;
use App\Controllers\Public\Blog;
use App\Helpers\ControllersFactory;
use App\Interfaces\Validator;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Slim\Flash\Messages;
use Slim\Views\Twig;

class ControllersFactoryTest extends TestCase
{

    public function test_controllers_lazy_loader_if_it_will_return_the_correct_controllers()
    {
        $view = $this->createMock(Twig::class);
        $logger = $this->createMock(Logger::class);
        $validator = $this->createMock(Validator::class);
        $flash_message = $this->createMock(Messages::class);

        $controllers = ControllersFactory::controllers_lazy_loader($view, $logger, $validator, $flash_message);

        $this->assertArrayHasKey('blog.controller', $controllers);
        $this->assertArrayHasKey('login.controller', $controllers);
        $this->assertArrayHasKey('admin.controller', $controllers);
        $this->assertArrayHasKey('admin.blog.controller', $controllers);
    }

    public function test_controllers_lazy_loader_if_it_will_return_the_correct_controllers_classes()
    {
        $view = $this->createMock(Twig::class);
        $logger = $this->createMock(Logger::class);
        $validator = $this->createMock(Validator::class);
        $flash_message = $this->createMock(Messages::class);

        $controllers = ControllersFactory::controllers_lazy_loader($view, $logger, $validator, $flash_message);

        $this->assertInstanceOf(Blog::class, $controllers['blog.controller']());
        $this->assertInstanceOf(LogIn::class, $controllers['login.controller']());
        $this->assertInstanceOf(Admin::class, $controllers['admin.controller']());
        $this->assertInstanceOf(\App\Controllers\Admin\Blog::class, $controllers['admin.blog.controller']());
    }

}
