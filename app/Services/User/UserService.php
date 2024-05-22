<?php

namespace App\Services\User;

use App\DTO\User\CreateAdminPayload;
use App\Enums\RoleType;
use App\Models\Role;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Company\CompanyService;

class UserService
{
    public function __construct(
        private AuthService $authService,
        private CompanyService $companyService
    ) {
    }

    public function exists(string $email): bool
    {
        // ищем пользователя по его email
        $targetUser = User::where('email', $email)->first();
        if ($targetUser) {
            return true;
        }
        return false;
    }

    public function createAdmin(CreateAdminPayload $payload): User|null
    {
        // получаем пользователя который создает нового админа
        $creator = $this->authService->user();
        
        // находим роль админа
        $adminRole = Role::where(['name' => RoleType::ADMIN])->first();

        // создаем нового админа
        $admin = new User();
        $admin->role()->associate($adminRole);
        $admin->createdBy()->associate($creator);
        $admin->name = $payload->fio;
        $admin->email = $payload->email;
        $admin->phone = $payload->phone;
        $admin->password = bcrypt($payload->password);
        $admin->save();

        // создаем новую компанию для админа
        $this->companyService->create($admin->id, $payload->company_name);

        return $admin;
    }
}
