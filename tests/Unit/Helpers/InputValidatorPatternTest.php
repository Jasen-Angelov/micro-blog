<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorPatternTest extends TestCase
{

    public function test_pattern_alpha_with_valid_value()
    {
        $data = 'John';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alpha')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_alpha_with_invalid_value()
    {
        $data = 'John123';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alpha')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alpha_with_empty_value()
    {
        $data = '';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alpha')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alpha_with_null_value()
    {
        $data = null;
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alpha')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alpha_with_int_value()
    {
        $data = 123;
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alpha')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alpha_with_empty_value_and_not_required()
    {
        $data = '';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alpha');

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_valid_value()
    {
        $data = 'John123';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alphanumeric')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_invalid_value()
    {
        $data = 'John@123';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alphanumeric')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_empty_value()
    {
        $data = '';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alphanumeric')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_null_value()
    {
        $data = null;
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alphanumeric')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_int_value()
    {
        $data = 123;
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alphanumeric')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_empty_value_and_not_required()
    {
        $data = '';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('alphanumeric');

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_slug_with_valid_value()
    {
        $data = 'john-doe';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('slug')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_slug_with_invalid_value()
    {
        $data = 'john@doe';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('slug')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_slug_with_empty_value()
    {
        $data = '';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('slug')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_slug_with_null_value()
    {
        $data = null;
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('slug')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_slug_with_int_value()
    {
        $data = 123;
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('slug')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_slug_with_empty_value_and_not_required()
    {
        $data = '';
        $validator = new InputValidator();

        $validator->name('name')->value($data)->pattern('slug');

        $this->assertTrue($validator->is_valid());
    }

}
