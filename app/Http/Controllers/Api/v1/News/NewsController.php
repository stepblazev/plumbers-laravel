<?php

namespace App\Http\Controllers\Api\v1\News;

use App\DTO\News\CreateNewsPayload;
use App\DTO\News\GetNewsPayload;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Services\Auth\AuthService;
use App\Services\News\NewsService;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Request;

class NewsController extends Controller {
    
    public function __construct(
        private AuthService $authService, 
        private NewsService $newsService, 
        private ResponseFactory $response
    ) {}
    
    
    public function get(Request $request): ApiResponse {
        $payload = GetNewsPayload::validateAndCreate($request);
        $news = $this->newsService->getList($payload);
        return $this->response->api($news);
    }
    
    
    public function create(Request $request): ApiResponse {
        $payload = CreateNewsPayload::validateAndCreate($request);
        $news = $this->newsService->create($payload);
        return $this->response->api($news);
    }
    
    
    public function delete(Request $request): ApiResponse {
        // ... логика удаления
        return $this->response->api(null);
    }
    
}