<?php

namespace App\Services;

class SessionManager
{
    public static function start_session(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function destroy_session(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_destroy();
        }
    }

    public static function set_session(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get_session(string $key)
    {
        return $_SESSION[$key];
    }

    public static function unset_session(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function is_session_set(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
}