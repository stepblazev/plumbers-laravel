<?php

namespace App\Services\Auth;

use App\DTO\Auth\LoginPayload;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// NOTE можно заменить возращаемый тип на spatie data

class AuthService
{
    public function login(LoginPayload $payload): UserResource|null
    {      
        if (Auth::attempt(['email' => $payload->email, 'password' => $payload->password])) {
            $user = User::with('role')->find(Auth::user()->id);
            return new UserResource($user);
        }
        return null;
    }

    public function logout()
    {
        Auth::logout();
    }

    public function user(): UserResource|null
    {
        $user = Auth::user();
        if ($user) {
            $user = User::with('role')->find($user->id);
            return new UserResource($user);
        }
        return null;
    }
}
