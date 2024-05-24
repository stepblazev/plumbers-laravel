<?php

namespace App\Services\User;

use App\DTO\User\CreateAdminPayload;
use App\DTO\User\DeleteAdminPayload;
use App\DTO\User\GetAdminsPayload;
use App\DTO\User\GetDetailAdminPayload;
use App\DTO\User\UpdateAdminPayload;
use App\Enums\RoleType;
use App\Http\Resources\User\AdminResource;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Company\CompanyService;
use Illuminate\Http\Resources\Json\ResourceCollection;

// NOTE можно изменить возращаемый тип на spatie data

class AdminService
{

    public function __construct(
        private AuthService $authService,
        private CompanyService $companyService
    ) {
    }


    public function isAdmin($userId): bool
    {
        $targetUser = User::with('role')->find($userId);
        if ($targetUser && $targetUser->role->name == RoleType::ADMIN->value) {
            return true;
        }
        return false;
    }


    public function create(CreateAdminPayload $payload): AdminResource
    {
        // получаем пользователя который создает нового админа
        $creator = $this->authService->user();

        // находим роль админа
        $adminRole = Role::where(['name' => RoleType::ADMIN->value])->first();

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
        $company = new Company();
        $company->name = $payload->company_name;
        $company->admin()->associate($admin);
        $company->save();

        $admin = User::with('role')->with('company')->find($admin->id);
        return new AdminResource($admin);
    }


    public function getFiltered(GetAdminsPayload $payload): ResourceCollection
    {
        // приводим искому подстроку к нижнему регистру
        $payload->search = mb_strtolower($payload->search);

        $admins = User::with('role')->with('company.permissions')->whereHas('role', function ($query) {
            $query->where('name', RoleType::ADMIN->value);
        })
            ->where(function ($query) use ($payload) {
                // выполняем поиск подстроки в email админов
                $query->whereRaw('email LIKE ?', ["%{$payload->search}%"])
                    ->orWhereHas('company', function ($query) use ($payload) {
                    // выполняем поиск в подстроке названия организации (с нижним регистром)
                    $query->whereRaw('LOWER(name) LIKE ?', ["%{$payload->search}%"]);
                });
            })->get();

        return AdminResource::collection($admins);
    }


    public function getDetail(GetDetailAdminPayload $payload): AdminResource
    {
        $admin = User::with('role')
            ->with('company.permissions')
            ->whereHas('role', function ($query) {
                $query->where('name', RoleType::ADMIN->value);
            })
            ->find($payload->id);

        return new AdminResource($admin);
    }


    public function update(UpdateAdminPayload $payload): AdminResource
    {
        // получаем нужного админа вместе с его компанией
        $admin = User::with('company.permissions')->find($payload->id);

        // обновляем данные компании админа
        if ($payload->company_name) {
            $admin->company->name = $payload->company_name;
        }
        if ($payload->storage_limit) {
            $admin->company->storage_limit = $payload->storage_limit;
        }
        if (is_array($payload->permission_ids)) {
            $admin->company->syncPermissions($payload->permission_ids);
        }
        $admin->company->save();

        // обновляем данные самого админа
        if (isset($payload->active)) {
            $admin->active = $payload->active;
        }
        if ($payload->fio) {
            $admin->name = $payload->fio;
        }
        if ($payload->short_name) {
            $admin->short_name = $payload->short_name;
        }
        if ($payload->phone) {
            $admin->phone = $payload->phone;
        }
        if ($payload->password) {
            $admin->password = bcrypt($payload->password);
        }
        $admin->save();

        return new AdminResource($admin);
    }


    public function delete(DeleteAdminPayload $payload): bool|null
    {
        // находим пользователя с указанным id и ролью "админ"
        $admin = User::whereHas('role', function ($query) {
            $query->where('name', RoleType::ADMIN->value);
        })->find($payload->id);

        return $admin->delete();
    }

}
