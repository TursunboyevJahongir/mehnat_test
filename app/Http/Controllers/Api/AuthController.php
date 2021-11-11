<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Services\AdminService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiController
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $attempt = $request->only('login', 'password');
            return $this->success(__('messages.success'), AdminService::login($request->validated()['type'], $attempt));
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }
    }

    public function refresh(string $type): JsonResponse
    {
        return $this->success(__('messages.success'), AdminService::createNewToken(auth($type)->refresh(), $type));
    }

    public function logout(): JsonResponse
    {
        Auth::guard()->logout();
        return $this->success(__('messages.success'));
    }
}
