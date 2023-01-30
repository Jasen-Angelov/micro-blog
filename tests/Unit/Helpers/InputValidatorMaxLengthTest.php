<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorMaxLengthTest extends TestCase
{

    public function test_max_length_with_valid_string_smaller_than_max_length()
    {
        $validator = new InputValidator();
        $validator->name('age')->value('twenty five')->max_length(25);
        $this->assertTrue($validator->is_valid());
    }

    public function test_max_length_with_valid_string_equal_to_max_length()
    {
        $validator = new InputValidator();
        $validator->name('age')->value('twenty five')->max_length(11);
        $this->assertTrue($validator->is_valid());
    }

    public function test_max_length_with_valid_string_greater_than_max_length()
    {
        $validator = new InputValidator();
        $validator->name('age')->value('twenty five')->max_length(10);
        $this->assertFalse($validator->is_valid());
    }

    public function test_max_length_with_countable_data_smaller_than_max_length()
    {
        $validator = new InputValidator();
        $validator->name('age')->value([25])->max_length(2);
        $this->assertTrue($validator->is_valid());
    }

    public function test_max_length_with_countable_data_equal_to_max_length()
    {
        $validator = new InputValidator();
        $validator->name('age')->value([25])->max_length(1);
        $this->assertTrue($validator->is_valid());
    }

    public function test_max_length_with_countable_data_greater_than_max_length()
    {
        $validator = new InputValidator();
        $validator->name('age')->value([25, 26])->max_length(1);
        $this->assertFalse($validator->is_valid());
    }


    public function test_max_length_with_boolean_data_type()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(false)->max_length(1);
        $this->assertFalse($validator->is_valid());
    }

    public function test_max_length_with_null_data_value()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(null)->max_length(1);
        $this->assertFalse($validator->is_valid());
    }

    public function test_max_length_with_empty_string_data_value()
    {
        $validator = new InputValidator();
        $validator->name('age')->value('')->max_length(2);
        $this->assertTrue($validator->is_valid());
    }

    public function test_max_length_with_empty_array_data_value()
    {
        $validator = new InputValidator();
        $validator->name('age')->value([])->max_length(1);
        $this->assertTrue($validator->is_valid());
    }

    public function test_max_length_with_empty_object_data_value()
    {
        $validator = new InputValidator();
        $validator->name('age')->value(new \stdClass())->max_length(1);
        $this->assertFalse($validator->is_valid());
    }

}
