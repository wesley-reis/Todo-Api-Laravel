<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthForgotPasswordRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthResetPasswordRequest;
use App\Http\Requests\AuthVerifyEmailRequest;
use App\Http\Resources\UserResource;
use App\Models\Todo;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthLoginRequest $request)
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

    public function verifyEmail(AuthVerifyEmailRequest $request)
    {
        $input = $request->validated();

        $user = $this->authService->verifyEmail($input['token']);

        return new UserResource($user);
    }

    public function forgotPassword(AuthForgotPasswordRequest $request)
    {
        $input = $request->validated();

        $user = $this->authService->forgotPassword($input['email']);

        return $user;
    }

    public function resetPassword(AuthResetPasswordRequest $request)
    {

        $input = $request->validated();
        $user = $this->authService->resetPassword($input['email'], $input['password'], $input['token']);

        return $user;
    }
}
