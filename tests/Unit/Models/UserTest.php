<?php

namespace Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_if_fillables_are_correct()
    {
        $user = new User();
        $this->assertEquals([
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
        ], $user->getFillable());
    }

    public function test_if_guarded_are_correct()
    {
        $user = new User();
        $this->assertEquals([
            'id',
        ], $user->getGuarded());
    }

    public function test_if_table_name_is_correct()
    {
        $user = new User();
        $this->assertEquals('users', $user->getTable());
    }
}
