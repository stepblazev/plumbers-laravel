<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    protected $fillable = ['admin_id', 'name', 'logo', 'storage_limit'];

    
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(CrmPermission::class, 'company_permissions', 'company_id', 'permission_id');
    }
    
    
    public function employees_count(): BelongsTo
    {
        // FIXME костыль на получение кол-ва работников
        return $this->belongsTo(User::class)->withDefault(function () {
            $adminId = $this->admin_id;
            $employees = User::where('active', true)
                ->where(function($query) use ($adminId) {
                    $query->where('id', $adminId)
                        ->orWhere('created_by', $adminId);
                })
                ->get();
            return $employees->count();
        });
    }
    
    
    /** Добавляет новое разрешение для компании */
    public function addPermission(int $permissionId): void
    {
        $this->permissions()->attach($permissionId);
    }
    
    
    /** Удаляет разрешение у компании */
    public function removePermission(int $permissionId): void
    {
        $this->permissions()->detach($permissionId);
    }
    
    
    /** Удаляет все разрешения у компании */
    public function clearPermissions(): void
    {
        $this->permissions()->detach();
    }
    
    
    /** Синхронизирует разрешения у компании */
    public function syncPermissions(array $permissionIds): void
    {
        $this->permissions()->sync($permissionIds);
    }
    
}
