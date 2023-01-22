<?php
// Routes

use App\Middleware\Admin              as AdminMiddleware;
use App\Middleware\Editor             as EditorMiddleware;
use App\Middleware\UserAuthentication as AuthenticationMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;

if (isset($app)) {

    $app->get( '/', function (Request $request, Response $response, array $args) {
       return $response->withRedirect('/blog');
    })->setName('home');

    $app->get( '/blog', 'home.controller')->setName('home.blogs');
    $app->any('/login',          'login.controller')->setName('home.login');
    $app->any('/register',       'registration.controller')->setName('home.register');

    $app->group('/admin', function () use ($app) {
        $this->get('/',             'admin.controller')->setName('admin.panel');
        $this->any('/posts/[{id}]', 'post.controller')->setName('admin.posts');

        $this->group('/users', function () use ($app) {
            $this->any('/[{id}]', 'user.controller')->add(AdminMiddleware::class)->setName('admin.users');
        });
    })->add(AuthenticationMiddleware::class)->add(EditorMiddleware::class);
}