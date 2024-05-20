<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Services\Auth\AuthService;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller {
    
    public function __construct(
        private AuthService $authService, 
        private ResponseFactory $response
    ) {}
    
    // Выполнение входа в учетную запись
    public function login(Request $request): ApiResponse {
        return $this->response->api('login HEHE!', Response::HTTP_OK);
    }
    
    // Выполнение выхода из учетной записи
    public function logout(Request $request): ApiResponse {
        return $this->response->api('logout HEHE!', Response::HTTP_OK);
    }
    
    // Получение данных текущего пользователя
    public function user(Request $request): ApiResponse {
        return $this->response->api('user HEHE!', Response::HTTP_OK);
    }
    
}