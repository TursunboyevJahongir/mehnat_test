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
            return $this->success(__('messages.success'), AdminService::Login($request->validated()));
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }
    }

    public function refresh(): JsonResponse
    {
        return $this->success(__('messages.success'), AdminService::createNewToken(auth('api')->refresh()));
    }

    public function logout(): JsonResponse
    {
        Auth::guard()->logout();
        return $this->success(__('messages.success'));
    }
}
