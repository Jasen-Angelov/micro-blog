<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorAddErrorTest extends TestCase
{

    public function test_add_error_and_assume_validator_is_not_valid()
    {
        $validator = new InputValidator();
        $validator->name('name')->value('John')->add_error('name is invalid');
        $this->assertFalse($validator->is_valid());
    }

    public function test_add_error_and_assume_validator_has_error()
    {
        $validator = new InputValidator();
        $validator->name('name')->value('John')->add_error('name is invalid');
        $this->assertTrue($validator->has_errors());
    }

    public function test_add_error_and_assume_validator_has_error_with_error_message()
    {
        $validator = new InputValidator();
        $validator->name('name')->value('John')->add_error('name is invalid');
        $this->assertEquals('name is invalid', $validator->get_errors()[0]);
    }
}
