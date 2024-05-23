<?php

namespace App\Services\Auth;

use App\DTO\Auth\LoginPayload;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    // FIXME заменить возращаемый тип (ресурс)
    public function login(LoginPayload $payload): User|null
    {
        if (Auth::attempt(['email' => $payload->email, 'password' => $payload->password])) {
            session()->regenerate();
            return Auth::user();
        }
        return null;
    }

    public function logout()
    {
        Auth::logoutCurrentDevice();
    }

    // FIXME заменить возращаемый тип (ресурс)
    public function user(): User|null
    {
        return Auth::user();
    }
}
