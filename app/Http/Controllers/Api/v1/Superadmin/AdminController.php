<?php

namespace App\Http\Controllers\Api\v1\Superadmin;

use App\DTO\User\CreateAdminPayload;
use App\DTO\User\DeleteAdminPayload;
use App\DTO\User\GetAdminsPayload;
use App\DTO\User\GetDetailAdminPayload;
use App\DTO\User\UpdateAdminPayload;
use App\Exceptions\Api\AlreadyExistsException;
use App\Exceptions\Api\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Services\Company\CompanyService;
use App\Services\User\AdminService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

class AdminController extends Controller
{
    
    public function __construct(
        private ResponseFactory $response,
        private UserService $userService,
        private AdminService $adminService,
        private CompanyService $companyService,
    ) {}
    
    
    public function filtered(Request $request): ApiResponse {
        $payload = GetAdminsPayload::validateAndCreate($request);
        $admins = $this->adminService->getFiltered($payload);
        return $this->response->api($admins);
    }
    
    
    public function detail(Request $request): ApiResponse {
        $data = array_merge($request->all(), ['id' => $request->id]);
        $payload = GetDetailAdminPayload::validateAndCreate($data);
        $admin = $this->adminService->getDetail($payload);
        
        if ($admin) {
            return $this->response->api($admin);
        } 
        
        throw new NotFoundException('Пользователь не найден, либо не является админом');
    }
    
    
    public function create(Request $request): ApiResponse {
        $payload = CreateAdminPayload::validateAndCreate($request);

        if ($this->userService->exists($payload->email, 'email') ) {
            throw new AlreadyExistsException('Пользователь с таким Email уже существует');
        }
        
        if ($this->companyService->exists($payload->company_name, 'name')) {
            throw new AlreadyExistsException('Компания с таким названием уже существует');
        }
        
        $admin = $this->adminService->create($payload);
        return $this->response->api($admin);
    }
    
    
    public function update(Request $request): ApiResponse {
        $data = array_merge($request->all(), ['id' => $request->id]);
        $payload = UpdateAdminPayload::validateAndCreate($data);

        if (!$this->adminService->isAdmin($payload->id)) {
            throw new NotFoundException('Пользователь не найден, либо не является админом');
        }
        if ($payload->company_name && $this->companyService->exists($payload->company_name, 'name')) {
            throw new AlreadyExistsException('Компания с таким названием уже существует');
        }
        
        $updatedAdmin = $this->adminService->update($payload);
        return $this->response->api($updatedAdmin);
    }
    
    
    public function delete(Request $request): ApiResponse {
        $data = array_merge($request->all(), ['id' => $request->id]);
        $payload = DeleteAdminPayload::validateAndCreate($data);
        
        if (!$this->adminService->isAdmin($payload->id)) {
            throw new NotFoundException('Пользователь не найден, либо не является админом');
        }
        
        $result = $this->adminService->delete($payload);
        return $this->response->api($result);
    }
    
}
