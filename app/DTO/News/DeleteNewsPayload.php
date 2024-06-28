<?php

namespace App\DTO\News;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class DeleteNewsPayload extends Data
{
    #[Required()]
    public string $id;
}