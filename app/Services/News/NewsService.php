<?php

namespace App\Services\News;

use App\DTO\News\CreateNewsPayload;
use App\DTO\News\DeleteNewsPayload;
use App\DTO\News\GetNewsPayload;
use App\Http\Resources\News\NewsResource;
use App\Models\News;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class NewsService
{
    public function __construct() {}
    
    public function getList(GetNewsPayload $payload): ResourceCollection
    {
        $user = Auth::user();
        $news = News::where('company_id', $user->company->id)
            ->orderBy($payload->order_column ?? 'created_at', $payload->order_by ?? 'DESC')
            ->paginate($payload->per_page, ['*'], 'page', $payload->page);

        return NewsResource::collection($news);
    }
    
    
    public function getTotal(GetNewsPayload $payload): int
    {
        $user = Auth::user();
        $count = News::where('company_id', $user->company->id)->count();

        return $count;
    }
    
    
    public function create(CreateNewsPayload $payload): NewsResource
    {
        $user = Auth::user();
        
        $news = new News();
        
        $news->title = $payload->title;
        $news->content = $payload->content;
        $news->company_id = $user->company->id;
        $news->created_by = $user->id;
        $news->save();
        
        return new NewsResource($news);
    }
    
    
    public function delete(DeleteNewsPayload $payload): bool
    {
        $user = Auth::user();
        $news = News::find($payload->id);
        
        // елси текущая новость не принадлежит к текущей компании, возвращаем false
        if ($news->company_id !== $user->company->id) {
            return false;
        }
        
        return $news->delete();
    }
}
