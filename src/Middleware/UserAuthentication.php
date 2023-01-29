<?php

namespace App\Middleware;

use App\Services\AuthenticationManager;
use Slim\Http\Request;
use Slim\Http\Response;

class UserAuthentication
{
    private array $allowed_routes = [
        '/login',
        '/register',
        '/logout',
    ];

    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        $route = $request->getAttribute('route');
        $routeName = $route->getName();
        if (!AuthenticationManager::is_authenticated() && !in_array($routeName, $this->allowed_routes)) {

            return $response->withRedirect('/login');
        }

        return $next($request, $response);
    }
}
