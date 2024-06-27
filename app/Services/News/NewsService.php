<?php

namespace App\Services\News;

use App\DTO\News\CreateNewsPayload;
use App\DTO\News\GetNewsPayload;
use App\Http\Resources\News\NewsResource;
use App\Models\News;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsService
{
    public function __construct() {}
    
    public function getList(GetNewsPayload $payload): ResourceCollection
    {
        $news = News::orderBy($payload->order_column ?? 'id', $payload->order_by ?? 'DESC')
            ->paginate($payload->per_page, ['*'], 'page', $payload->page);

        return NewsResource::collection($news);
    }
    
    public function create(CreateNewsPayload $payload)
    {
        $news = new News();
        
        $news->title = $payload->title;
        $news->content = $payload->content;
        $news->company_id = 2;
        $news->created_by = 5;
        $news->save();
        
        return $news;
    }
}
