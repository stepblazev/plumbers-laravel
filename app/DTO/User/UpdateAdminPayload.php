<?php

namespace App\DTO\User;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Between;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UpdateAdminPayload extends Data
{
    #[Required()]
    public string $id;

    #[BooleanType]
    public ?bool $active;

    #[File]
    #[Mimes('png', 'jpg', 'jpeg', 'gif', 'bmp', 'tiff', 'webp', 'svg', 'ico')]
    #[Nullable()]
    public ?UploadedFile $image;
    
    #[Max(255)]
    public ?string $fio;

    #[Max(255)]
    public ?string $short_name;

    #[Max(255)]
    public ?string $company_name;

    #[Max(255)]
    public ?string $phone;

    #[Min(3)]
    #[Max(255)]
    #[Email()]
    public ?string $email;

    #[Password(
        min: 4,
        letters: true,
        mixedCase: true,
        numbers: true
    )]
    public ?string $password;

    #[Between(0, 1000)]
    public ?int $storage_limit;

    #[ArrayType()]
    public ?array $permission_ids;
}