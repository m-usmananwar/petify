<?php

namespace App\Enum;

enum VerificationEnum: string
{
    case EMAIL = 'email';
    case PASSWORD = 'password';
}