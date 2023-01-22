<?php

namespace App\Interfaces;

interface FormValidator extends ErrorBag, FileValidator
{
    /**
     * Returns true if the form is valid, false otherwise.
     *
     * @return bool
     */
    public function is_valid(): bool;

}