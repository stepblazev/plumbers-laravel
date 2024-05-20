<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAPI
{
    const ALIAS = 'auth.api';
    
    public function handle(Request $request, Closure $next): Response
    {
        // FIXME Здесь нужно написать логику проверки на авторизованность
        return $next($request);
    }
}
