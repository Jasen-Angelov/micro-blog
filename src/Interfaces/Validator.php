<?php

namespace App\Interfaces;

interface Validator
{
    /**
     * Returns true if validation passes, false otherwise.
     *
     * @return bool
     */
    public function is_valid(): bool;
}