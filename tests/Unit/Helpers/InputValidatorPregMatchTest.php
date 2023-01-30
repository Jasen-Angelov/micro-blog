<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorPregMatchTest extends TestCase
{

    public function test_preg_match_with_valid_regex_pattern_and_valid_data()
    {
        $data = 'John';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->preg_match('/^[a-zA-Z]+$/u')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_preg_match_with_invalid_regex_pattern()
    {
        $data = 'John';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->preg_match('/^[a-zA-Z]+^/u')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_preg_match_with_valid_regex_pattern_and_invalid_data()
    {
        $data = 'John123';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->preg_match('/^[a-zA-Z]+$/u')->is_required();

        $this->assertFalse($validator->is_valid());
    }
}
