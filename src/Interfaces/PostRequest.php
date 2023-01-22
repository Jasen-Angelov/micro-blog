<?php

namespace App\Interfaces;

use Slim\Http\Request;
use Slim\Http\Response;

interface PostRequest
{
    public function post(Request $request, Response $response, array $args = []): Response;
}