<?php

namespace App\Interfaces;

interface FileValidator
{
    /**
     * Validates that the file is an image.
     *
     * @return FileValidator
     */
    public function is_image(): FileValidator;

    /**
     * Validates if the file size is not exceeding the limit.
     *
     * @param int $max_size in MB
     * @return FileValidator
     */
    public function file_max_size(int $max_size): FileValidator;

    /**
     * Validates the file extension.
     *
     * @param string $type
     * @return FileValidator
     */
    public function file_is_type(string $type): FileValidator;
}