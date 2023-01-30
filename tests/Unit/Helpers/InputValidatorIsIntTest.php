<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorIsIntTest extends TestCase
{

    public function test_is_int_with_valid_data()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(25)->is_int();
        $this->assertTrue($validator->is_valid());
    }

    public function test_is_int_with_invalid_data()
    {
        $validator = new InputValidator();
        $validator->name('age')->value('twenty five')->is_int();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_int_with_invalid_data_type()
    {
        $validator = new InputValidator();
        $validator->name('age')->value([25])->is_int();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_int_with_invalid_data_value_null()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(null)->is_int();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_int_with_invalid_data_value_empty_string()
    {
        $validator = new InputValidator();
        $validator->name('age')->value('')->is_int();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_int_with_invalid_data_value_false()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(false)->is_int();
        $this->assertFalse($validator->is_valid());
    }
}
