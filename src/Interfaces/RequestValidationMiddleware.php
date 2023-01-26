<?php

namespace App\Interfaces;

use Slim\Http\Request;
use Slim\Http\Response;

interface RequestValidationMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next);
}