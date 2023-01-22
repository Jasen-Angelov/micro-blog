<?php

namespace App\Interfaces;

use Slim\Http\Request;
use Slim\Http\Response;

interface GetRequest
{
    public function get(Request $request, Response $response, array $args = []): Response;
}