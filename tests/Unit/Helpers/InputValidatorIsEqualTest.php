<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorIsEqualTest extends TestCase
{

    public function test_is_equal_with_valid_data()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(25)->is_equal(25);
        $this->assertTrue($validator->is_valid());
    }

    public function test_is_equal_with_invalid_data()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(25)->is_equal(26);
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_equal_with_invalid_data_type()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(25)->is_equal('25');
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_equal_with_invalid_data_value_null()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(25)->is_equal(null);
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_equal_with_null_data_value_and_empty_string_to_match()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(null)->is_equal('');
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_equal_with_null_data_value_and_false_to_match()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(null)->is_equal(false);
        $this->assertFalse($validator->is_valid());
    }
}
