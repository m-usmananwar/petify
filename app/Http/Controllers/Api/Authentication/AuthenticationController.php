<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    public function __construct(private readonly AuthenticationService $service)
    {
        
    }
}
