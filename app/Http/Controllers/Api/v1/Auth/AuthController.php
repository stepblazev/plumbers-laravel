<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\DTO\Auth\LoginPayload;
use App\Exceptions\Api\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Services\Auth\AuthService;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Request;

class AuthController extends Controller {
    
    public function __construct(
        private AuthService $authService, 
        private ResponseFactory $response
    ) {}
    
    
    // выполнение входа в учетную запись
    public function login(Request $request): ApiResponse {
        $payload = LoginPayload::validateAndCreate($request);
        $user = $this->authService->login($payload);
        
        if ($user) {
            $request->session()->regenerate();
            return $this->response->api($user);
        } 
        
        throw new NotFoundException('Некорректные данные для входа');
    }
    
    
    // выполнение выхода из учетной записи
    public function logout(Request $request): ApiResponse {
        $this->authService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $this->response->api(null);
    }
    
    
    // получение данных текущего пользователя
    public function user(Request $request): ApiResponse {
        $user = $this->authService->user();
        return $this->response->api($user);
    }
    
}