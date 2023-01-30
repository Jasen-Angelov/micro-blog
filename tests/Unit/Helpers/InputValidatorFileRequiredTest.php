<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;
use Slim\Http\UploadedFile;

class InputValidatorFileRequiredTest extends TestCase
{

    public function test_file_required_with_valid_file()
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        $input = new InputValidator();
        $input->name('file')->file($file)->file_required();
        $this->assertTrue($input->is_valid());
        $this->assertEmpty($input->get_errors());
    }

    public function test_file_required_with_invalid_file()
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('getError')->willReturn(UPLOAD_ERR_NO_FILE);
        $input = new InputValidator();
        $input->name('file')->file($file)->file_required();
        $this->assertFalse($input->is_valid());
        $this->assertNotEmpty($input->get_errors());
    }

}
