<?php

namespace App\Http\Controllers\Api\v1\News;

use App\DTO\News\CreateNewsPayload;
use App\DTO\News\DeleteNewsPayload;
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
        $total = $this->newsService->getTotal($payload);
        $meta = ['total_count' => $total, 'current_page' => $payload->page, 'per_page' => $payload->per_page];
        
        return $this->response->api($news, $meta);
    }
    
    
    public function create(Request $request): ApiResponse {
        $payload = CreateNewsPayload::validateAndCreate($request);
        $news = $this->newsService->create($payload);
        return $this->response->api($news);
    }
    
    
    public function delete(Request $request): ApiResponse {
        $payload = DeleteNewsPayload::validateAndCreate(array_merge($request->all(), ['id' => $request->id]));
        $result = $this->newsService->delete($payload);
        return $this->response->api($result);
    }
    
}