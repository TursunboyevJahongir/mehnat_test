<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Director\EmployeeCreateRequest;
use App\Http\Requests\Api\Director\EmployeeUpdateRequest;
use App\Http\Requests\Api\Director\UpdateProfileRequest;
use App\Http\Resources\Api\AllEmployeeResource;
use App\Http\Resources\Api\EmployeeResource;
use App\Http\Resources\Api\PaginationResourceCollection;
use App\Models\Employee;
use App\Services\DirectorEmployeeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DirectorEmployeeController extends ApiController
{
    public function __construct(
        protected DirectorEmployeeService $service,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $size = $request->get('per_page') ?? config('app.per_page');
        $position = $request->position_id ?? null;
        try {
            return $this->success(__('messages.success'),
                new PaginationResourceCollection($this->service->companyEmployees(auth()->user()->director, $size, $position), AllEmployeeResource::class));
        } catch (Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }
    }

    public function show(Employee $id): JsonResponse
    {
        try {
            return $this->success(__('messages.success'), new EmployeeResource($this->service->show($id)));
        } catch (Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }

    }

    public function create(EmployeeCreateRequest $request): JsonResponse
    {
        return $this->success(__('messages.success'),
            new EmployeeResource($this->service->create($request->validated())));
    }

    public function update(EmployeeUpdateRequest $request): JsonResponse
    {
        $employee = Employee::find($request->id);
        $this->service->update($employee, $request->validated());
        return $this->success(__('messages.success'), new EmployeeResource($employee));
    }

    /**
     * @param Employee $id
     * @return JsonResponse
     */
    public function delete(Employee $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return $this->success(__('messages.employee_deleted', ['attribute' => $id->first_name]));
        } catch (Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->success(__('messages.success'), new EmployeeResource(auth()->user()));
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $this->service->updateProfile($request->validated());
        return $this->success(__('messages.success'), new EmployeeResource(auth()->user()));
    }
}
