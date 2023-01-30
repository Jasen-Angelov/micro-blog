<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;
use Slim\Http\UploadedFile;

class InputValidatorFileIsTypeTest extends TestCase
{

    public function test_file_is_type_with_valid_file()
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        $file->method('getClientMediaType')->willReturn('image/jpeg');
        $input = new InputValidator();
        $input->name('file')->file($file)->file_is_type('image/jpeg');
        $this->assertTrue($input->is_valid());
        $this->assertEmpty($input->get_errors());
    }

    public function test_file_is_type_with_invalid_file()
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        $file->method('getClientMediaType')->willReturn('image/jpeg');
        $input = new InputValidator();
        $input->name('file')->file($file)->file_is_type('image/png');
        $this->assertFalse($input->is_valid());
        $this->assertNotEmpty($input->get_errors());
    }
}
