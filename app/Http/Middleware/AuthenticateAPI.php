<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\Api\UnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAPI
{
    const ALIAS = 'auth.api';
    
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            return $next($request);
        }

        throw new UnauthorizedException('Пользователь не авторизован');
    }
}
