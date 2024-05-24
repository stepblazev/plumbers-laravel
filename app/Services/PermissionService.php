<?php

namespace App\Services;

use App\Http\Resources\PermissionResource;
use App\Models\CrmPermission;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionService
{
    public function __construct() {}
    
    public function getList(): ResourceCollection
    {
        $permissions = CrmPermission::all();
        return PermissionResource::collection($permissions);
    }
}
