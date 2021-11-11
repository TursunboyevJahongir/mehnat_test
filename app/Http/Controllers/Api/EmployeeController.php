<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\EmployeeCreateRequest;
use App\Http\Requests\Api\EmployeeUpdateProfileRequest;
use App\Http\Requests\Api\EmployeeUpdateRequest;
use App\Http\Resources\Api\AllEmployeeResource;
use App\Http\Resources\Api\EmployeeResource;
use App\Http\Resources\Api\PaginationResourceCollection;
use App\Models\Company;
use App\Models\Employee;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends ApiController
{
    public function __construct(
        protected EmployeeService $service,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $size = $request->get('per_page') ?? config('app.per_page');
        $position = $request->position_id ?? null;
        try {
            return $this->success(__('messages.success'),
                new PaginationResourceCollection($this->service->index($size, $position), AllEmployeeResource::class));
        } catch (Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }
    }

    public function companyEmployees(Request $request, Company $company): JsonResponse
    {
        $size = $request->get('per_page') ?? config('app.per_page');
        $position = $request->position_id ?? null;
        try {
            return $this->success(__('messages.success'),
                new PaginationResourceCollection($this->service->companyEmployees($company, $size, $position), AllEmployeeResource::class));
        } catch (Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }
    }

    public function show(Employee $id): JsonResponse
    {
        return $this->success(__('messages.success'), new EmployeeResource($id));
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
        $id->delete();
        return $this->success(__('messages.employee_deleted', ['attribute' => $id->first_name]));
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

    public function updateProfile(EmployeeUpdateProfileRequest $request): JsonResponse
    {
        $this->service->updateProfile($request->validated());
        return $this->success(__('messages.success'), new EmployeeResource(auth()->user()));
    }
}
