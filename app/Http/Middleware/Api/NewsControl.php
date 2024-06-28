<?php

namespace App\Http\Middleware\Api;

use Closure;
use App\Enums\RoleType;
use App\Exceptions\Api\ForbiddenException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NewsControl
{
    const ALIAS = 'newscontrol.api';

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && (
            $user->role->name == RoleType::ADMIN->value || 
            $user->role->name == RoleType::SUBADMIN->value ||
            $user->role->name == RoleType::LOGIST->value
        )) {
            return $next($request);
        }
        
        throw new ForbiddenException('Доступ запрещен');
    }
}
