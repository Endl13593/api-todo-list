<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginInvalidException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthVerifyEmailRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param AuthLoginRequest $request
     * @return UserResource
     * @throws LoginInvalidException
     */
    public function login(AuthLoginRequest $request): UserResource
    {
        $input = $request->validated();
        $token = $this->authService->login($input['email'], $input['password']);

        return (new UserResource(auth()->user()))->additional($token);
    }

    public function register(AuthRegisterRequest $request)
    {
        $input = $request->validated();
        $user = $this->authService->register($input['first_name'], $input['last_name'] ?? '', $input['email'], $input['password']);

        return new UserResource($user);
    }

    /**
     * @param AuthVerifyEmailRequest $request
     * @return UserResource
     * @throws VerifyEmailTokenInvalidException
     */
    public function verifyEmail(AuthVerifyEmailRequest $request): UserResource
    {
        $input = $request->validated();

        $user = $this->authService->verifyEmail($input['token']);

        return new UserResource($user);
    }
}
