<?php

namespace App\Http\Controllers\Api\v1\Auth;

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
    
    // Выполнение входа в учетную запись
    public function login(Request $request): ApiResponse {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        $user = $this->authService->login($request->email, $request->password);
        
        if ($user) {
            return $this->response->api($user);
        } else {
            throw new NotFoundException('Некорректные данные для входа');
        }
    }
    
    // Выполнение выхода из учетной записи
    public function logout(Request $request): ApiResponse {
        $this->authService->logout();
        return $this->response->api(null);
    }
    
    // Получение данных текущего пользователя
    public function user(Request $request): ApiResponse {
        $user = $this->authService->user();
        return $this->response->api($user);
    }
    
}