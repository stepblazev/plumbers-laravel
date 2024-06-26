<?php

namespace App\DTO\Admin;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class GetDetailAdminPayload extends Data {
    #[Required()]
    public string $id;
}