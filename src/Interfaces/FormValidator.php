<?php

namespace App\Interfaces;

interface FormValidator extends Validator
{
   public function is_email(string $email): FormValidator;

    public function is_required(): FormValidator;

    public function min_length(int $length): FormValidator;

    public function max_length(int $length): FormValidator;

    public function is_equal(mixed $input, mixed $evaluator): FormValidator;

    public function is_url(string $url): FormValidator;

    public function is_bool(string|bool $data): FormValidator;

    public function is_int(string|int $data): FormValidator;

    public function is_float(string|float $data): FormValidator;

}