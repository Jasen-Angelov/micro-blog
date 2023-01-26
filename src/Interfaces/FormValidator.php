<?php

namespace App\Interfaces;

interface FormValidator extends Validator
{
   public function is_email(): FormValidator;

    public function is_required(): FormValidator;

    public function min_length(int $length): FormValidator;

    public function max_length(int $length): FormValidator;

    public function is_equal(mixed $evaluator): FormValidator;

    public function is_url(): FormValidator;

    public function is_bool(): FormValidator;

    public function is_int(): FormValidator;

    public function is_float(): FormValidator;

}