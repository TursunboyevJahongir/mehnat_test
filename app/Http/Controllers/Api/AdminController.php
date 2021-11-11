<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\AdminCreateRequest;
use App\Http\Requests\Api\AdminProfileUpdateRequest;
use App\Http\Requests\Api\AdminUpdateRequest;
use App\Http\Resources\Api\AdminResource;
use App\Http\Resources\Api\AllAdminResource;
use App\Http\Resources\Api\PaginationResourceCollection;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\Request;
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

    public function updateProfile(AdminProfileUpdateRequest $request): JsonResponse
    {
        $this->service->updateProfile($request->validated());
        return $this->success(__('messages.success'), new AdminResource(auth()->user()));
    }

    public function index(Request $request): JsonResponse
    {
        $size = $request->get('per_page') ?? config('app.per_page');
        $role = $request->role ?? null;
        try {
            return $this->success(__('messages.success'),
                new PaginationResourceCollection($this->service->index($size, $role), AllAdminResource::class));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }
    }

    public function show(Admin $id): JsonResponse
    {
        return $this->success(__('messages.success'), new AdminResource($id));
    }

    public function create(AdminCreateRequest $request): JsonResponse
    {
        try {
            return $this->success(__('messages.success'),
                new AdminResource($this->service->create($request->validated())));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }

    }

    public function update(AdminUpdateRequest $request): JsonResponse
    {
        $Admin = Admin::find($request->id);
        try {
            $this->service->update($Admin, $request->validated());
            return $this->success(__('messages.success'), new AdminResource($Admin));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }

    }

    /**
     * @param Admin $id
     * @return JsonResponse
     */
    public function delete(Admin $id): JsonResponse
    {
        try {
            return $this->success(__('messages.admin_deleted', ['attribute' => $this->service->delete($id)]));
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }
    }
}
