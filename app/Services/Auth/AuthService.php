<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

 // FIXME проверить сервис
class AuthService
{
    public function login($email, $password): User|null
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            session()->regenerate();
            return Auth::user();
        }
        return null;
    }

    public function logout()
    {
        Auth::logoutCurrentDevice();
    }

    public function user(): User|null
    {
        return Auth::user();
    }
}
