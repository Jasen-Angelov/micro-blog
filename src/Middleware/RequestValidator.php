<?php

namespace App\Middleware;

use App\Helpers\InputValidator;
use App\Interfaces\RequestValidationMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class RequestValidator implements RequestValidationMiddleware
{
    protected InputValidator $validator;

    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    public function __invoke(Request $request, Response $response, callable $next)
    {
        match ($request->getMethod()) {
            'GET'    => $this->validate_get($request),
            'POST'   => $this->validate_post($request),
            'PUT'    => $this->validate_put($request),
            'DELETE' => $this->validate_delete($request),
        };

        $request = $request->withAttribute('validation_errors', $this->validator->get_errors());
        $request = $request->withAttribute('validation_success', $this->validator->is_valid());

        return $next($request, $response);
    }

    protected abstract function validate_get(Request $request);

    protected abstract function validate_post(Request $request);

    protected abstract function validate_put(Request $request);

    protected abstract function validate_delete(Request $request);
}