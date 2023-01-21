<?php

namespace App\Middleware;

class Editor extends UserPermissions
{
    protected string $role = 'editor';
}