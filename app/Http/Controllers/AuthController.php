<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginInvalidException;
use App\Exceptions\ResetPasswordTokenInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\Http\Requests\AuthForgotPasswordRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthResetPasswordRequest;
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

    /**
     * @param AuthRegisterRequest $request
     * @return UserResource
     * @throws UserHasBeenTakenException
     */
    public function register(AuthRegisterRequest $request): UserResource
    {
        $input = $request->validated();
        $user = $this->authService->register($input['firstName'], $input['lastName'] ?? '', $input['email'], $input['password']);

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

    /**
     * @param AuthForgotPasswordRequest $request
     */
    public function forgotPassword(AuthForgotPasswordRequest $request)
    {
        $input = $request->validated();
        $this->authService->forgotPassword($input['email']);
    }

    /**
     * @param AuthResetPasswordRequest $request
     * @throws ResetPasswordTokenInvalidException
     */
    public function resetPassword(AuthResetPasswordRequest $request)
    {
        $input = $request->validated();
        $this->authService->resetPassword($input['email'], $input['password'], $input['token']);
    }
}
