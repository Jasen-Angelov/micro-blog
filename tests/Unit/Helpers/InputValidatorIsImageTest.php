<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;
use Slim\Http\UploadedFile;

class InputValidatorIsImageTest extends TestCase
{

    public function test_is_image_with_valid_file_extension()
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        $file->method('getClientMediaType')->willReturn('image/jpeg');

        $validator = new InputValidator();
        $validator->name('image')->file($file)->is_image();
        $this->assertTrue($validator->is_valid());
    }

    public function test_is_image_with_invalid_file_extension()
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        $file->method('getClientMediaType')->willReturn('image/tiff');

        $validator = new InputValidator();
        $validator->name('image')->file($file)->is_image();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_image_with_invalid_file_extension_null()
    {
        $file = $this->createMock(UploadedFile::class);
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        $file->method('getClientMediaType')->willReturn(null);

        $validator = new InputValidator();
        $validator->name('image')->file($file)->is_image();
        $this->assertFalse($validator->is_valid());
    }
}
