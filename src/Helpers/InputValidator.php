<?php

namespace App\Helpers;

use App\Interfaces\ErrorBag;
use App\Interfaces\FormValidator;
use App\Interfaces\ImageValidator;
use Slim\Http\UploadedFile;

class InputValidator implements FormValidator, ErrorBag, ImageValidator
{
    /**
     * Regex patterns for validating input
     *
     * @var array $patterns
     */
    public array $patterns = array(
        'alpha' => '[\p{L}]+',
        'alphanumeric' => '[\p{L}0-9]+',
        'slug' => '^[a-z0-9]+(?:-[a-z0-9]+)*$',
    );

    /**
     * Error bag
     *
     * @var array $errors
     */
    public array $errors = [];

    /**
     * Name of input.
     *
     * @var string
     */
    private string $input_name;

    /**
     * Data to validate
     *
     * @var mixed
     */
    private mixed $input_value;

    /**
     *
     *
     * @var mixed
     */
    private UploadedFile $file;

    /**
     * Type of the data to be validated
     *
     * @param string $input_name
     * @return InputValidator
     */
    public function name(string $input_name ): InputValidator
    {
        $this->input_name = ucfirst($input_name);

        return $this;
    }

    /**
     * Data to be validated
     *
     * @param mixed $data
     * @return InputValidator
     */
    public function value(mixed $data): InputValidator
    {
        $this->input_value = $data;

        return $this;
    }

    /**
     * File to be validated
     *
     * @param UploadedFile $file
     * @return InputValidator
     */
    public function file(UploadedFile $file): InputValidator
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Add error to error bag.
     *
     * @param string $error
     * @return void
     */
    public function add_error(string $error): void
    {
        $this->errors[] = $error;
    }
    /**
     * Validate the input value against the given pattern.
     *
     * @param string $pattern available patterns
     * @return InputValidator
     */
    public function pattern(string $pattern): InputValidator
    {
        if (!array_key_exists($pattern, $this->patterns)) {
            $this->errors[] = "$this->input_name data pattern not supported!";

            return $this;
        }

        if ($pattern === 'array') {
            is_array($this->input_value) ?: $this->errors[] = "$this->input_name data is not an array!";
        } else {
            $regex = '/^(' . $this->patterns[$pattern] . ')$/u';
            if (!empty($this->input_value) && !preg_match($regex, $this->input_value)) {
                $this->errors[] = "$this->input_name input data, is not valid pattern: $pattern";
            }
        }

        return $this;
    }

    /**
     * Custom pattern validation
     *
     * @param string $pattern regex pattern
     * @return InputValidator
     */
    public function preg_match(string $pattern): InputValidator
    {
        $regex = '/^(' . $pattern . ')$/u';
        if ( !empty($this->input_value) && !preg_match($regex, $this->input_value)) {
            $this->errors[] = "$this->input_name input data, is not valid!";
        }

        return $this;
    }

    /**
     * Input data is required
     *
     * @return InputValidator
     */
    public function is_required(): InputValidator
    {
        if ((isset($this->file) && $this->file->getError() !== 0) || empty($this->input_value)) {
            $this->errors[] = "$this->input_name input is required!";
        }

        return $this;
    }

    /**
     * Input data is required
     *
     * @return InputValidator
     */
    public function file_required(): InputValidator
    {

        if ((isset($this->file) && $this->file->getError() !== 0)) {

            $this->errors[] = "$this->input_name is required!";
        }

        return $this;
    }

    /**
     * Data value length/value is more than $length
     *
     * @param int $length
     * @return InputValidator
     */
    public function min_length(int $length): InputValidator
    {
        $count = $this->get_count_value($this->input_value);

        if (false === $count){
            $this->errors[] = "$this->input_name input data cant be validated with min operator!";

            return $this;
        }

        if (false === $this->compare_integers($count, $length, '>')) {
            $this->errors[] = "$this->input_name input is too short!";
        }

        return $this;
    }

    /**
     * Check if value exceeds the max length
     *
     * @param int $length
     * @return InputValidator
     */
    public function max_length(int $length):InputValidator
    {
        $count = $this->get_count_value($this->input_value);

        if (false === $count){
            $this->errors[] = "$this->input_name input data cant be validated with max operator!";

            return $this;
        }

        if (false === $this->compare_integers($count, $length, '<')) {
            $this->errors[] = "$this->input_name input is too long!";
        }

        return $this;
    }

    /**
     * Check if input is equal to $value
     *
     * @param mixed $evaluator
     * @return InputValidator
     */
    public function is_equal(mixed $evaluator): InputValidator
    {
        if ($this->input_value !== $evaluator) {
            $this->errors[] = "$this->input_name input is not equal to the compared data!";
        }

        return $this;
    }

    /**
     * Validate file size
     *
     * @param int $max_size file size in MB
     * @return InputValidator
     */
    public function file_max_size(int $max_size): InputValidator
    {
        $size_in_bites = $max_size * 1024 * 1024;
        if (isset($this->file) && $this->file->getError() !== 4) {
            if ($this->file->getSize() > $size_in_bites) {
                $this->errors[] = "$this->input_name file is too big!";
            }
        }

        return $this;
    }

    /**
     * Validate file extension
     *
     * @param string $type
     * @return InputValidator
     */
    public function file_is_type( string $type): InputValidator
    {
        if (isset($this->file) && $this->file->getError() !== 4) {
            $file_ext = pathinfo($this->file->getClientFilename(), PATHINFO_EXTENSION);
            if ($file_ext !== $type) {
                $this->errors[] = "$this->input_name file extension is not valid!";
            }
        }

        return $this;
    }

    /**
     * Return true if the input value is valid.
     *
     * @return boolean
     */
    public function is_valid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Returns the error bag
     *
     * @return array
     */
    public function get_errors(): array
    {
        return $this->errors;
    }

    /**
     * Check if input value is integer.
     *
     * @return InputValidator
     */
    public function is_int(): InputValidator
    {
        if (false === filter_var($this->input_value, FILTER_VALIDATE_INT)){
            $this->errors[] = "$this->input_name input data is not an integer!";
        }

        return $this;
    }

    /**
     * Check if input value is float.
     *
     * @return InputValidator
     */
    public function is_float(): InputValidator
    {
        if (false === filter_var($this->input_value, FILTER_VALIDATE_FLOAT)){
            $this->errors[] = "$this->input_name input data is not a float!";
        }

        return $this;
    }

    /**
     * Validate if input value is a valid URL.
     *
     * @return InputValidator
     */
    public function is_url(): InputValidator
    {
        if (false === filter_var($this->input_value, FILTER_VALIDATE_URL)){
            $this->errors[] = "$this->input_name input data is not a valid URL!";
        }

        return $this;
    }

    /**
     * Validate if value is boolean.
     *
     * @return InputValidator
     */
    public function is_bool(): InputValidator
    {
        if (false === filter_var($this->input_value, FILTER_VALIDATE_BOOLEAN)){
            $this->errors[] = "$this->input_name input data is not a boolean!";
        }

        return $this;
    }

    /**
     * Validate if input value is a valid email.
     *
     * @return InputValidator
     */
    public function is_email(): InputValidator
    {
        if (false === filter_var($this->input_value, FILTER_VALIDATE_EMAIL)){
            $this->errors[] = "$this->input_name input data is not a valid email!";
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function is_image(): InputValidator
    {
        if (isset($this->file) && $this->file->getError() !== 4) {
            $file_ext = pathinfo($this->file->getClientFilename(), PATHINFO_EXTENSION);
            if (!in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                $this->errors[] = "$this->input_name file is not an image!";
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function has_errors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Returns the count of input value or false if value can't be counted.
     *
     * @param mixed $value
     * @return int|false
     */
    private function get_count_value(mixed $value): int | false
    {
        return match (gettype($value)) {
            'string'  => strlen($value),
            'integer' => $value,
            'array'   => count($value),
            default   => false,
        };
    }

    /**
     * Compare two values.
     *
     * @param int $value
     * @param int $length
     * @param string $operator
     * @return bool
     */
    private function compare_integers(int $value, int $length, string $operator): bool
    {
        return match ($operator) {
            '==' => $value == $length,
            '!=' => $value != $length,
            '>'  => $value > $length,
            '>=' => $value >= $length,
            '<'  => $value < $length,
            '<=' => $value <= $length,
            default => false,
        };
    }
}