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
        $required = ['id', 'slug'];
        if (count(array_diff($required, array_keys($arg))) > 1){
            $this->validator->add_error('Missing required URL parameters!');
        }
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
        $required = ['title', 'content'];
        if (count(array_diff($required, array_keys($params))) > 0){
            $this->validator->add_error('Missing required parameters!');
        }
        foreach ($params as $name => $value){
            match ($name){
              'title' =>  $this->validator->name($name)->value($value)->max_length(255)->is_required(),
              'content' => $this->validator->name($name)->value($value)->max_length(500)->is_required(),
              default   =>  $this->validator->add_error("Unhandled POST parameter with name: {$name}"),
            };
        }

        if ($file = $request->getUploadedFiles()['blog_image'] ?? false){
            $this->validator->name('Image')->file($file)->is_image()->file_required();
        }else{
            $this->validator->add_error('No file was uploaded!');
        }

    }

    protected final function validate_put(Request $request): void
    {
        $route = $request->getAttribute('route');
        $params = $request->getParams();
        $params = array_merge($params, $route->getArguments());
        $required = ['id', 'title', 'content', '_METHOD'];
        if (count(array_diff($required, array_keys($params))) > 0){
            $this->validator->add_error('Missing required parameters!');
        }
        foreach ($params as $name => $value){
            match ($name){
                'id'      =>  $this->validator->name($name)->value($value)->is_int()->is_required(),
                'title'   =>  $this->validator->name($name)->value($value)->max_length(255)->is_required(),
                'content' =>  $this->validator->name($name)->value($value)->max_length(500)->is_required(),
                '_METHOD' =>  $this->validator->name($name)->value($value)->is_equal('PUT')->is_required(),
                default   =>  $this->validator->add_error("Unhandled PUT parameter with name: {$name}"),
            };
        }

        if ($file = $request->getUploadedFiles()['blog_image'] ?? false){
            $this->validator->name('Image')->file($file)->is_image();
        }
    }

    protected final function validate_delete(Request $request): void
    {
        $route = $request->getAttribute('route');
        $arg   = $route->getArguments();
        $required = ['id'];
        if (count(array_diff($required, array_keys($arg))) > 0){
            $this->validator->add_error('Missing required parameters!');
        }
        foreach ($arg as $name => $value){
            match ($name){
                'id'      =>  $this->validator->name($name)->value($value)->is_int()->is_required(),
                default   =>  $this->validator->add_error("Unhandled DELETE parameter with name: {$name}"),
            };
        }
    }

}