<?php

namespace Services;

use App\Services\AuthManager;
use PHPUnit\Framework\TestCase;

class AuthManagerTest extends TestCase
{

    public function test_if_is_authenticated_returns_true_when_session_is_set()
    {
        $_SESSION['user'] = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'test@email.bg'];
        $this->assertTrue(AuthManager::is_authenticated());
    }
    public function test_if_log_out_user_works_when_session_is_set()
    {
        $_SESSION['user'] = [
            'id' => 1,
            'name' => 'John Doe',
            ];
        AuthManager::logout_current_user();
        $this->assertFalse(AuthManager::is_authenticated());
    }

    public function test_if_get_authenticated_user_returns_array_when_session_is_set()
    {
        $user = [
            'id' => 1,
            'name' => 'John Doe',
        ];
        $_SESSION['user'] = $user;
        $this->assertEquals($user, AuthManager::get_authenticated_user());
    }

    public function test_if_get_authenticated_user_id_will_return_correct_id_when_session_is_set()
    {
        $user = [
            'id' => 1,
            'name' => 'John Doe',
        ];
        $_SESSION['user'] = $user;
        $this->assertEquals($user['id'], AuthManager::get_authenticated_user_id());
    }

    public function test_if_login_user_will_set_session_when_session_is_not_set()
    {
        $user = [
            'id' => 1,
            'name' => 'John Doe',
        ];
        AuthManager::login_user($user);
        $this->assertEquals($user, AuthManager::get_authenticated_user());
    }
}
