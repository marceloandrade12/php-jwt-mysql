<?php

namespace App\Services;

use App\Controllers\AuthController;

class AuthService
{
    public function login()
    {
        return AuthController::login();
    }
}
