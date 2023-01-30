<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorIsRequiredTest extends TestCase
{

    public function test_is_required_with_valid_input()
    {
        $input = new InputValidator();
        $input->name('username')->value('John Doe')->is_required();
        $this->assertTrue($input->is_valid());
        $this->assertEmpty($input->get_errors());
    }

    public function test_is_required_with_invalid_input()
    {
        $input = new InputValidator();
        $input->name('username')->value('')->is_required();
        $this->assertFalse($input->is_valid());
        $this->assertNotEmpty($input->get_errors());
    }
}
