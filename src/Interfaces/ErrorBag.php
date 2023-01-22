<?php

namespace App\Interfaces;

interface ErrorBag
{
    /**
     * Check if the error bag has errors.
     *
     * @return bool
     */
    public function has_errors(): bool;

    /**
     * Returns the errors in array.
     *
     * @return array
     */
    public function get_errors(): array;
}