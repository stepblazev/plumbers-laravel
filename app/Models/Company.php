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
}
