<?php

namespace App\Interfaces;

use Slim\Http\Request;
use Slim\Http\Response;

interface PutRequest
{
    public function put(Request $request, Response $response, array $args = []): Response;
}