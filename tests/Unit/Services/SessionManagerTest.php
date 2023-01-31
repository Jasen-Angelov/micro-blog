<?php

namespace Services;

use App\Services\SessionManager;
use PHPUnit\Framework\TestCase;

class SessionManagerTest extends TestCase
{
    public function test_if_session_is_started()
    {
        SessionManager::start_session();
        $this->assertEquals(PHP_SESSION_ACTIVE, session_status());
    }

    public function test_if_session_is_destroyed()
    {
        SessionManager::destroy_session();
        $this->assertEquals(PHP_SESSION_NONE, session_status());
    }

    public function test_if_session_is_set()
    {
        SessionManager::set_session('test', 'test');
        $this->assertEquals('test', SessionManager::get_session('test'));
    }

    public function test_if_session_is_unset()
    {
        SessionManager::unset_session('test');
        $this->assertFalse(SessionManager::is_session_set('test'));
    }
}
