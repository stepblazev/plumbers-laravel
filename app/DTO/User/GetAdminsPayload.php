<?php

namespace App\DTO\User;

use App\DTO\PaginationAndOrderPayload;
use Spatie\LaravelData\Attributes\Validation\Max;

class GetAdminsPayload extends PaginationAndOrderPayload {
    #[Max(255)]
    public ?string $search;
}