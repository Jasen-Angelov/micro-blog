<?php
// Routes

use App\Middleware\Admin              as AdminMiddleware;
use App\Middleware\Editor             as EditorMiddleware;
use App\Middleware\UserAuthentication as AuthenticationMiddleware;


if (isset($app)) {
    $app->get( '/',            'blogs.controller')->setName('home.blogs');
    $app->get( '/blog/{slug}', 'blogs.controller')->setName('home.blog');
    $app->any('/login',        'login.controller')->setName('admin.login');
    $app->any('/register',     'rgstr.controller')->setName('admin.register');

    // Administration routes
    $app->group('/admin', function () use ($app) {
        $this->get('/',             'admin.controller')->setName('admin.panel');
        $this->any('/posts/[{id}]', 'post.controller')->setName('admin.posts');

        $this->group('/users', function () use ($app) {
            $this->any('/[{id}]', 'user.controller')->add(AdminMiddleware::class)->setName('admin.users');
        });
    })->add(AuthenticationMiddleware::class)->add(EditorMiddleware::class);
}