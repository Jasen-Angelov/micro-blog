<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorIsFloatTest extends TestCase
{

    public function test_is_float()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(25.5)->is_float();
        $this->assertTrue($validator->is_valid());
    }

    public function test_is_float_with_invalid_data()
    {
        $validator = new InputValidator();
        $validator->name('age')->value('twenty five')->is_float();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_float_with_invalid_data_type()
    {
        $validator = new InputValidator();
        $validator->name('age')->value([25])->is_float();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_float_with_invalid_data_value_null()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(null)->is_float();
        $this->assertFalse($validator->is_valid());
    }
}
