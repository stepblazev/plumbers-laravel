<?php

namespace App\DTO\User;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;

class CreateAdminPayload extends Data {
    #[Max(255)]
    public string $fio;
    
    #[Max(255)]
    public string $company_name;
    
    #[Max(255)]
    public string $phone;
    
    #[Min(3)]
    #[Max(255)]
    #[Email()]
    public string $email;
    
    #[Password(
        min: 4,
        letters: true,
        mixedCase: true,
        numbers: true
    )]
    public string $password;
}