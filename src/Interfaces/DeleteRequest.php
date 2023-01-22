<?php

namespace App\Interfaces;

use Slim\Http\Request;
use Slim\Http\Response;

interface DeleteRequest
{
    public function delete(Request $request, Response $response, array $args = []): Response;
}