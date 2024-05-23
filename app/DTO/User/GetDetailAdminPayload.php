<?php

namespace App\DTO\User;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class GetDetailAdminPayload extends Data {
    #[Required()]
    public string $id;
}