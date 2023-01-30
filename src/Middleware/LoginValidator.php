<?php

namespace App\Middleware;

use Slim\Http\Request;

class LoginValidator extends RequestValidator
{
    protected final function validate_get(Request $request): void
    {
        //no validation needed for this route.
    }

    protected final function validate_post(Request $request)
    {
        $params = $request->getParsedBody();
        $required = ['email', 'password'];
        if (count(array_diff($required, array_keys($params))) > 0){
            $this->validator->add_error('Missing required parameters!');
        }
        foreach ($params as $name => $value){
            match ($name){
                'email'    => $this->validator->name($name)->value($value)->is_email()->is_required(),
                'password' => $this->validator->name($name)->value($value)->max_length(255)->is_required(),
            };
        }
    }

    protected final function validate_put(Request $request): void
    {
        //no validation needed for this route.
    }

    protected final function validate_delete(Request $request): void
    {
        //no validation needed for this route.
    }
}