<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthLoginRequest $request): array
    {
        $input = $request->validated();

        return $this->authService->login($input['email'], $input['password']);
    }
}
