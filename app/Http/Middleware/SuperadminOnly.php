<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\RoleType;
use App\Exceptions\Api\ForbiddenException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperadminOnly
{
    const ALIAS = 'superadmin';

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role()->first()->name == RoleType::SUPERADMIN) {
            return $next($request);
        }
        
        throw new ForbiddenException('Доступ запрещен');
    }
}
