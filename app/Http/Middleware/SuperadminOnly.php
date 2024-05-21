<?php

namespace App\Http\Middleware;

use App\Exceptions\Api\ForbiddenException;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperadminOnly
{
    const ALIAS = 'superadmin';

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if ($user) {
            $role = Role::find($user->role_id);
        
            if ($role && $role->name == 'superadmin') {
                return $next($request);
            }
        }
        
        throw new ForbiddenException('Доступ запрещен');
    }
}
