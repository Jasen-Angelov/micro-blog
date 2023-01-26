<?php

namespace App\Middleware;

use App\Helpers\InputValidator;
use App\Interfaces\RequestValidationMiddleware;
use App\Interfaces\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class BlogValidator implements RequestValidationMiddleware
{

    private Validator $validator;
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $this->validator = new InputValidator();

        match ($request->getMethod()) {
            'GET'    => $this->validate_get($request),
            'POST'   => $this->validate_post($request),
            'PUT'    => $this->validate_put($request),
            'DELETE' => $this->validate_delete($request),
        };
        if ($request->getUploadedFiles()){
            self::validate_file($request->getUploadedFiles());
        }

        $request = $request->withAttribute('validation_errors', $this->validator->get_errors());
        $request = $request->withAttribute('validation_success', $this->validator->is_valid());

        return $next($request, $response);
    }

    private function validate_get(Request $request): void
    {
        $route = $request->getAttribute('route');
        $arg = $route->getArguments();
        foreach ($arg as $name => $value){
            match ($name){
                'id'      => $this->validator->name($name)->value($value)->is_int()->is_required(),
                'slug'    => $this->validator->name($name)->value($value)->pattern('slug')->is_required(),
                default   =>  $this->validator->name($name)->value($value)->pattern('alpha'),
            };
        }

    }

    private function validate_post(Request $request): void
    {
        $params = $request->getParams();
        foreach ($params as $name => $value){
            match ($name){
              'title' =>  $this->validator->name($name)->value($value)->max_length(255)->is_required(),
              'content' => $this->validator->name($name)->value($value)->max_length(500)->is_required(),
            };
        }

    }

    private function validate_put(Request $request): void
    {
        $params = $request->getParams();
        foreach ($params as $name => $value){
            match ($name){
                'title'   =>  $this->validator->name($name)->value($value)->max_length(255)->is_required(),
                'content' =>  $this->validator->name($name)->value($value)->max_length(500)->is_required(),
            };
        }

        $this->validate_put($request);
    }

    private function validate_delete(Request $request): void
    {
        $this->validate_put($request);
    }
    private function validate_file(iterable $request): void
    {
        foreach ($request as $key => $file){
            $this->validator->name($key)->value($file)->is_image();
        }
    }

}