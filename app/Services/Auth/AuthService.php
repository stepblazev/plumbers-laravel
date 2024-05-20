<?php

namespace App\Services\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login($email, $password): Authenticatable|null
    {
        // if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
        //     return Auth::user();
        // }
        // return null;
    }

    public function logout()
    {
        // Auth::logout();
    }

    public function user()
    {
        // return Auth::user();
    }
}
