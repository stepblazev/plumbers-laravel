<?php

namespace App\DTO\News;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;

class CreateNewsPayload extends Data {
    #[Max(255)]
    public string $title;
    
    #[Max(5000)]
    public string $content;
}