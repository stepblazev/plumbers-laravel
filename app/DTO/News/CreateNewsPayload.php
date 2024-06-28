<?php

namespace App\DTO\News;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class CreateNewsPayload extends Data {
    #[Required()]
    #[Max(255)]
    public string $title;
    
    #[Required()]
    #[Max(5000)]
    public string $content;
    
    // #[Required()]
    // public string $creator_id;
}