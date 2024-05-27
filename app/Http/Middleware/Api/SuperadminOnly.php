<?php

namespace App\Http\Middleware\Api;

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

        // NOTE снять коммент
        if ($user && $user->role()->first()->name == RoleType::SUPERADMIN->value) {
            return $next($request);
        }
        
        throw new ForbiddenException('Доступ запрещен');
    }
}
