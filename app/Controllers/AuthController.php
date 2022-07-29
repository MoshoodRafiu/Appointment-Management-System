<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Responses\ViewResponse;
use App\Services\AuthService;

class AuthController
{
    public function __construct(protected AuthService $authService)
    {

    }

    public function showRegister(): ViewResponse
    {
        return ViewResponse::make('auth/register');
    }
}
