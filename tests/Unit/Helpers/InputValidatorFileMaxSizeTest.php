<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;
use Slim\Http\UploadedFile;

class InputValidatorFileMaxSizeTest extends TestCase
{

    public function test_file_max_size_with_valid_file_size()
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        // 1 KB
        $file->method('getSize')->willReturn(1024);
        $input = new InputValidator();
        $input->name('file')->file($file)->file_max_size(1);
        $this->assertTrue($input->is_valid());
        $this->assertEmpty($input->get_errors());
    }

    public function test_file_max_size_with_invalid_file_size()
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        // 1 MB + 1 byte
        $file->method('getSize')->willReturn(1024 * 1024 * 1024 + 1);
        $input = new InputValidator();
        $input->name('file')->file($file)->file_max_size(1);
        $this->assertFalse($input->is_valid());
        $this->assertNotEmpty($input->get_errors());
    }
}
