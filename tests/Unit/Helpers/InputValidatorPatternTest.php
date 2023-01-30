<?php

namespace Helpers;

use App\Helpers\InputValidator;
use PHPUnit\Framework\TestCase;

class InputValidatorPatternTest extends TestCase
{

    public function test_pattern_alpha_with_valid_value()
    {
        $data = [
            'name' => 'John',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alpha')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_alpha_with_invalid_value()
    {
        $data = [
            'name' => 'John123',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alpha')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alpha_with_empty_value()
    {
        $data = [
            'name' => '',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alpha')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alpha_with_null_value()
    {
        $data = [
            'name' => null,
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alpha')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alpha_with_int_value()
    {
        $data = [
            'name' => 123,
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alpha')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alpha_with_empty_value_and_not_required()
    {
        $data = [
            'name' => '',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alpha');

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_valid_value()
    {
        $data = [
            'name' => 'John123',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alphanumeric')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_invalid_value()
    {
        $data = [
            'name' => 'John@123',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alphanumeric')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_empty_value()
    {
        $data = [
            'name' => '',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alphanumeric')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_null_value()
    {
        $data = [
            'name' => null,
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alphanumeric')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_int_value()
    {
        $data = [
            'name' => 123,
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alphanumeric')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_alphanumeric_with_empty_value_and_not_required()
    {
        $data = [
            'name' => '',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('alphanumeric');

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_slug_with_valid_value()
    {
        $data = [
            'name' => 'john-doe',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('slug')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_slug_with_invalid_value()
    {
        $data = [
            'name' => 'john@doe',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('slug')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_slug_with_empty_value()
    {
        $data = [
            'name' => '',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('slug')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_slug_with_null_value()
    {
        $data = [
            'name' => null,
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('slug')->is_required();

        $this->assertFalse($validator->is_valid());
    }

    public function test_pattern_slug_with_int_value()
    {
        $data = [
            'name' => 123,
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('slug')->is_required();

        $this->assertTrue($validator->is_valid());
    }

    public function test_pattern_slug_with_empty_value_and_not_required()
    {
        $data = [
            'name' => '',
        ];
        $validator = new InputValidator();

        $validator->name('name')->value($data['name'])->pattern('slug');

        $this->assertTrue($validator->is_valid());
    }

}
