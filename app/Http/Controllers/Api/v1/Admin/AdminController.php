<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\DTO\User\CreateAdminPayload;
use App\Exceptions\Api\AlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Services\Company\CompanyService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

class AdminController extends Controller
{
    public function __construct(
        private ResponseFactory $response,
        private UserService $userService,
        private CompanyService $companyService,
    ) {}
    
    public function create(Request $request): ApiResponse {
        $payload = CreateAdminPayload::validateAndCreate($request);

        // если такой пользователь или компания уже существуют, выбрасываем ошибку
        if ($this->userService->exists($payload->email) ) {
            throw new AlreadyExistsException('Пользователь с таким Email уже существует');
        }
        
        if ($this->companyService->exists($payload->company_name)) {
            throw new AlreadyExistsException('Компания с таким названием уже существует');
        }
        
        $admin = $this->userService->createAdmin($payload);
        
        return $this->response->api($admin);
    }
}
