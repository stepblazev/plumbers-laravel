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
use App\Services\ImageService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// NOTE можно изменить возращаемый тип на spatie data

class AdminService
{

    public function __construct(
        private AuthService $authService,
        private CompanyService $companyService,
        private ImageService $imageService
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
        $creator = Auth::user();

        // находим роль админа
        $adminRole = Role::where(['name' => RoleType::ADMIN->value])->first();

        // создаем нового админа
        $admin = new User();
        $admin->role()->associate($adminRole);
        $admin->creator()->associate($creator);
        
        if ($payload->image) {
            $admin->avatar = $this->imageService->saveImage($payload->image, 'users');
        }
        
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

        $admins = User::whereHas('role', function ($query) {
            $query->where('name', RoleType::ADMIN->value);
        })
            ->where(function ($query) use ($payload) {
                // выполняем поиск подстроки в email админов
                $query->whereRaw('LOWER(email) LIKE ? OR LOWER(name) LIKE ?', ["%{$payload->search}%", "%{$payload->search}%"])
                    ->orWhereHas('company', function ($query) use ($payload) {
                    // выполняем поиск в подстроке названия организации (с нижним регистром)
                    $query->whereRaw('LOWER(name) LIKE ?', ["%{$payload->search}%"]);
                });
            })
            ->orderBy($payload->order_column ?? 'id', $payload->order_by ?? 'DESC')
            ->paginate($payload->per_page, ['*'], 'page', $payload->page);

        return AdminResource::collection($admins);
    }

    
    public function getFilteredTotalCount(GetAdminsPayload $payload): int
    {
        // приводим искому подстроку к нижнему регистру
        $payload->search = mb_strtolower($payload->search);

        $count = User::whereHas('role', function ($query) {
            $query->where('name', RoleType::ADMIN->value);
        })
            ->where(function ($query) use ($payload) {
                // выполняем поиск подстроки в email админов
                $query->whereRaw('LOWER(email) LIKE ? OR LOWER(name) LIKE ?', ["%{$payload->search}%", "%{$payload->search}%"])
                    ->orWhereHas('company', function ($query) use ($payload) {
                    // выполняем поиск в подстроке названия организации (с нижним регистром)
                    $query->whereRaw('LOWER(name) LIKE ?', ["%{$payload->search}%"]);
                });
            })
            ->count();

        return $count;
    }


    public function getDetail(GetDetailAdminPayload $payload): AdminResource
    {
        $admin = User::whereHas('role', function ($query) {
                $query->where('name', RoleType::ADMIN->value);
            })
            ->find($payload->id);

        return new AdminResource($admin);
    }


    public function update(UpdateAdminPayload $payload): AdminResource
    {
        // получаем нужного админа вместе с его компанией
        $admin = User::find($payload->id);

        // обновляем данные компании админа
        if ($payload->company_name && $admin->company->name !== $payload->company_name) {
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
        
        if (is_null($payload->image)) {
            if ($admin->avatar) {
                Storage::disk('public')->delete($admin->avatar); // удаляем старую аватарку
            }
            $admin->avatar = null; // устанавливаем null
        } else if ($payload->image->getClientOriginalName() !== pathinfo($admin->avatar, PATHINFO_BASENAME)) {
            if ($admin->avatar) {
                Storage::disk('public')->delete($admin->avatar); // удаляем старую аватарку
            }
            $admin->avatar = $this->imageService->saveImage($payload->image, 'users'); // сохраняем и устанавливаем новую
        }
        
        if ($payload->fio) {
            $admin->name = $payload->fio;
        }
        if ($payload->short_name) {
            $admin->short_name = $payload->short_name;
        }
        if ($payload->email) {
            $admin->email = $payload->email;
        }
        if (is_string($payload->phone) || (is_string($payload->phone) && strlen($payload->phone) === 0)) {
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

        Storage::disk('public')->delete($admin->avatar);
        
        return $admin->delete();
    }

}
