<?php

namespace src\Middleware;

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

        if (!isset($_SESSION['USER']) && !in_array($routeName, $this->allowed_routes)) {

            return $response->withRedirect('/login');
        }

        return $next($request, $response);
    }
}
