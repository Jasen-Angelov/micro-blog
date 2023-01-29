<?php

use App\Middleware\BlogValidator;
use App\Middleware\LoginValidator;
use App\Middleware\UserAuthentication as AuthenticationMiddleware;

if (isset($app)) {
    $app->get( '/',            'blog.controller')->setName('home.blogs');
    $app->get( '/blog/{slug}', 'blog.controller')->setName('home.blog');
    $app->any('/login',        'login.controller')->setName('admin.login')->add(LoginValidator::class);

    // Administration routes
    $app->group('/admin', function () use ($app) {
        $this->get('',                     'admin.controller')->setName('admin.dashboard');
        $this->get('/dashboard',           'admin.controller')->setName('admin.dashboard');
        $this->get('/blog/[{id}]',         'admin.blog.controller')->setName('admin.blog.get');
        $this->put('/blog/{id}',           'admin.blog.controller')->setName('admin.blog.update');
        $this->post('/blog',               'admin.blog.controller')->setName('admin.blog.create');
        $this->get('/blog/delete/{id}',    'admin.blog.controller:delete')->setName('admin.blog.delete');
        $this->get('/logout',              'login.controller:delete')->setName('admin.logout');
    })->add(AuthenticationMiddleware::class)->add(BlogValidator::class);
}