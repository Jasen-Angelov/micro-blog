<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorIsEmailTest extends TestCase
{

    public function test_is_email_with_valid_data()
    {
        $validator = new InputValidator();
        $validator->name('email')->value('jasen@abv.bg')->is_email();
        $this->assertTrue($validator->is_valid());
    }

    public function test_is_email_with_invalid_data()
    {
        $validator = new InputValidator();
        $validator->name('email')->value('jasen@abv')->is_email();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_email_with_invalid_data_type()
    {
        $validator = new InputValidator();
        $validator->name('email')->value(['email' => 'jasen@abv.bg'])->is_email();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_email_with_invalid_data_value_null()
    {
        $validator = new InputValidator();
        $validator->name('email')->value(null)->is_email();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_email_with_invalid_data_value_empty_string()
    {
        $validator = new InputValidator();
        $validator->name('email')->value('')->is_email();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_email_with_invalid_data_value_false()
    {
        $validator = new InputValidator();
        $validator->name('email')->value(false)->is_email();
        $this->assertFalse($validator->is_valid());
    }

    public function test_is_email_with_invalid_data_value_int()
    {
        $validator = new InputValidator();
        $validator->name('email')->value(123)->is_email();
        $this->assertFalse($validator->is_valid());
    }

}
