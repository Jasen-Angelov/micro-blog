<?php
// Application middleware

use src\Middleware\UserAuthentication;

if (isset($app)) {
    $app->add(UserAuthentication::class);
}
