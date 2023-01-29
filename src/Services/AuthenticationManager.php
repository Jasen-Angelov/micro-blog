<?php

namespace App\Services;

use App\Controllers\Admin\Admin;

class AuthenticationManager
{
    public static function is_authenticated(): bool
    {
        return SessionManager::is_session_set('user');
    }

    public static function get_authenticated_user(): array
    {
        return SessionManager::get_session('user');
    }

    public static function get_authenticated_user_id(): int
    {
        return SessionManager::get_session('user')['id'];
    }

    public static function authenticate_user(array $user): void
    {
        SessionManager::set_session('user', $user);
    }

    public static function logout_current_user(): void
    {
        SessionManager::unset_session('user');
    }

    public static function login_user(string $email, string $password): bool
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $user = Admin::where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            self::authenticate_user($user);

            return true;
        }

        return false;
    }
}