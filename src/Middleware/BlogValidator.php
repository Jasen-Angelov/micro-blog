<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class BlogValidator extends RequestValidator
{
    protected final function validate_get(Request $request): void
    {
        $route = $request->getAttribute('route');
        $arg   = $route->getArguments();
        foreach ($arg as $name => $value){
            match ($name){
                'id'      =>  $this->validator->name($name)->value($value)->is_int()->is_required(),
                'slug'    =>  $this->validator->name($name)->value($value)->pattern('slug')->is_required(),
                default   =>  $this->validator->add_error("Unhandled URL parameter with name: {$name}"),
            };
        }

    }

    protected final function validate_post(Request $request): void
    {
        $params = $request->getParams();
        foreach ($params as $name => $value){
            match ($name){
              'title' =>  $this->validator->name($name)->value($value)->max_length(255)->is_required(),
              'content' => $this->validator->name($name)->value($value)->max_length(500)->is_required(),
              default   =>  $this->validator->add_error("Unhandled POST parameter with name: {$name}"),
            };
        }
        if ($request->getUploadedFiles()){
            self::validate_file($request->getUploadedFiles());
        }

    }

    protected final function validate_put(Request $request): void
    {
        $route = $request->getAttribute('route');
        $params = $request->getParams();
        $params = array_merge($params, $route->getArguments());
        foreach ($params as $name => $value){
            match ($name){
                'id'      =>  $this->validator->name($name)->value($value)->is_int()->is_required(),
                'title'   =>  $this->validator->name($name)->value($value)->max_length(255)->is_required(),
                'content' =>  $this->validator->name($name)->value($value)->max_length(500)->is_required(),
                '_METHOD' =>  $this->validator->name($name)->value($value)->is_equal('PUT')->is_required(),
                default   =>  $this->validator->add_error("Unhandled PUT parameter with name: {$name}"),
            };
        }
        if ($request->getUploadedFiles()){
            self::validate_file($request->getUploadedFiles());
        }
    }

    protected final function validate_delete(Request $request): void
    {
        $route = $request->getAttribute('route');
        $arg   = $route->getArguments();

        foreach ($arg as $name => $value){
            match ($name){
                'id'      =>  $this->validator->name($name)->value($value)->is_int()->is_required(),
                default   =>  $this->validator->add_error("Unhandled DELETE parameter with name: {$name}"),
            };
        }
    }
    private function validate_file(iterable $uploaded_files): void
    {
        foreach ($uploaded_files as $key => $file){
            $this->validator->name($key)->value($file)->is_image();
        }
    }

}