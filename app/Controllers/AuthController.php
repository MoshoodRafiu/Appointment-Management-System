<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Responses\ViewResponse;

class AuthController
{
    public function showRegister(): ViewResponse
    {
        return ViewResponse::make('auth/register');
    }
}
