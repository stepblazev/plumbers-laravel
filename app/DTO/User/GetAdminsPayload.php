<?php

namespace App\DTO\User;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;

class GetAdminsPayload extends Data {
    #[Max(255)]
    public ?string $search;
}