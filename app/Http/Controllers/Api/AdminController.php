<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\AdminUpdateRequest;
use App\Http\Resources\Api\AdminResource;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminController extends ApiController
{

    public function __construct(private AdminService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->success(__('messages.success'), new AdminResource(auth()->user()));
    }

    public function updateProfile(AdminUpdateRequest $request): JsonResponse
    {
        $this->service->updateProfile($request->validated());
        return $this->success(__('messages.success'), new AdminResource(auth()->user()));
    }
}
