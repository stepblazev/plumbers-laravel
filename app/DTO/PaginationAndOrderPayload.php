<?php

namespace App\DTO;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;

class PaginationAndOrderPayload extends Data {
    #[IntegerType]
    public ?int $page;
    
    #[IntegerType]
    public ?int $per_page;
    
    #[Max(255)]
    public ?string $order_column;
    
    #[Max(4)]
    public ?string $order_by;
}