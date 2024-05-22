<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CrmPermission extends Model
{
    protected $fillable = ['name', 'display_name', 'description'];
    
    public function companies(): BelongsToMany {
        return $this->belongsToMany(Company::class, 'company_permissions', 'permission_id', 'company_id');
    }
}
