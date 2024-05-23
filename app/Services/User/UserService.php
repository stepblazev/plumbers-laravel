<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Company\CompanyService;

class UserService
{
    public function __construct(
        private AuthService $authService,
    ) {
    }

    public function exists(string $value, string $column = 'id'): bool
    {
        // ищем пользователя по значению в выбранном столбце (по умолчанию - id)
        $targetUser = User::where($column, $value)->first();
        if ($targetUser) {
            return true;
        }
        return false;
    }
}
