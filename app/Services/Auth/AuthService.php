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
        if (Auth::attempt(['active' => true, 'email' => $payload->email, 'password' => $payload->password])) {
            $user = User::find(Auth::id());
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
        $id = Auth::id();
        if ($id) {
            $user = User::find($id);
            return new UserResource($user);
        }
        return null;
    }
}
