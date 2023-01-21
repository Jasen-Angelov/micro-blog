<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

abstract class UserPermissions
{
    protected string $role;
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        if (isset($_SESSION['USER']) && $_SESSION['USER']['role'] !== $this->role ) {
            return $response->withStatus(401);
        }

        return $next($request, $response);
    }
}