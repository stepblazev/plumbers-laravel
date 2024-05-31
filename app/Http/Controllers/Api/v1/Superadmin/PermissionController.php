<?php

namespace App\Http\Controllers\Api\v1\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Services\Company\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

class PermissionController extends Controller
{
    public function __construct(
        private ResponseFactory $response,
        private PermissionService $permissionService,
    ) {}
    
    public function permissions(Request $request): ApiResponse {
        $permissions = $this->permissionService->getList();
        return $this->response->api($permissions);
    }
}
