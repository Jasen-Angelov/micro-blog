<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorMinLengthTest extends TestCase
{

    public function test_min_length_with_valid_string_smaller_than_min_length()
    {
        $validator = new InputValidator();
        $validator->name('name')->value('John')->min_length(5);
        $this->assertFalse($validator->is_valid());
    }

    public function test_min_length_with_valid_string_equal_to_min_length()
    {
        $validator = new InputValidator();
        $validator->name('name')->value('John')->min_length(4);
        $this->assertTrue($validator->is_valid());
    }

    public function test_min_length_with_valid_string_greater_than_min_length()
    {
        $validator = new InputValidator();
        $validator->name('name')->value('John')->min_length(3);
        $this->assertTrue($validator->is_valid());
    }

    public function test_min_length_with_countable_data_smaller_than_min_length()
    {
        $validator = new InputValidator();
        $validator->name('age')->value([25])->min_length(2);
        $this->assertFalse($validator->is_valid());
    }

    public function test_min_length_with_countable_data_equal_to_min_length()
    {
        $validator = new InputValidator();
        $validator->name('age')->value([25])->min_length(1);
        $this->assertTrue($validator->is_valid());
    }

    public function test_min_length_with_countable_data_greater_than_min_length()
    {
        $validator = new InputValidator();
        $validator->name('age')->value([25, 26])->min_length(1);
        $this->assertTrue($validator->is_valid());
    }

    public function test_min_length_with_boolean_data_type()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(false)->min_length(1);
        $this->assertFalse($validator->is_valid());
    }

    public function test_min_length_with_null_data_type()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(null)->min_length(1);
        $this->assertFalse($validator->is_valid());
    }
}
