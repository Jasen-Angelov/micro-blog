<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorIsUrlTest extends TestCase
{

    public function test_is_url()
    {
        $validator = new InputValidator();
        $validator->name('url')->value('https://www.google.com')->is_url();
        $this->assertTrue($validator->is_valid());
    }

    public function test_is_url_with_invalid_data()
    {
        $validator = new InputValidator();
        $validator->name('url')->value('www.google.com')->is_url();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_url_with_invalid_data_type()
    {
        $validator = new InputValidator();
        $validator->name('url')->value(['https://www.google.com'])->is_url();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_url_with_invalid_data_value_null()
    {
        $validator = new InputValidator();
        $validator->name('url')->value(null)->is_url();
        $this->assertFalse($validator->is_valid());
    }
}
