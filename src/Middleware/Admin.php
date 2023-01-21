<?php

namespace App\Middleware;

class Admin extends UserPermissions
{
    protected string $role = 'admin';
}