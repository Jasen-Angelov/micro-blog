<?php

namespace App\Services;

use App\Models\User;

class AuthManager
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

    public static function login_user(array $user): void
    {
        SessionManager::set_session('user', $user);
    }

    public static function logout_current_user(): void
    {
        SessionManager::unset_session('user');
    }

    public static function authenticate_user(string $email, string $password): bool
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $user = User::where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            self::login_user($user->toArray());

            return true;
        }

        return false;
    }
}