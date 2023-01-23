<?php

namespace App\Interfaces;

interface ImageValidator extends Validator
{
    /**
     * Validates that the file is an image.
     *
     * @return ImageValidator
     */
    public function is_image(): ImageValidator;

    /**
     * Validates if the file size is not exceeding the limit.
     *
     * @param int $max_size in MB
     * @return ImageValidator
     */
    public function file_max_size(int $max_size): ImageValidator;

    /**
     * Validates the file extension.
     *
     * @param string $type
     * @return ImageValidator
     */
    public function file_is_type(string $type): ImageValidator;
}