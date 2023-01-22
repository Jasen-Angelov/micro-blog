<?php

namespace App\Interfaces;

use Slim\Http\Request;
use Slim\Http\Response;

interface Controller extends GetRequest, PostRequest, PutRequest, DeleteRequest
{
    public function __invoke(Request $request, Response $response, array $args = []): Response;
}