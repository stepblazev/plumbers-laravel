<?php

namespace App\DTO\Auth;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class LoginPayload extends Data {
    #[Required()]
    #[Min(3)]
    #[Max(255)]
    #[Email()]
    public string $email;
    
    #[Required()]
    #[Password(min: 4)]
    public string $password;
}