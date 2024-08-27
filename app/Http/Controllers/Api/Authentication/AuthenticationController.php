<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Service\AuthenticationService;

class AuthenticationController extends Controller
{
    public function __construct(private readonly AuthenticationService $service)
    {
        
    }
}
