<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\CompanyCreateRequest;
use App\Http\Requests\Api\CompanyUpdateRequest;
use App\Http\Requests\Api\MyCompanyUpdateRequest;
use App\Http\Resources\Api\AllCompaniesResource;
use App\Http\Resources\Api\CompanyResource;
use App\Http\Resources\Api\PaginationResourceCollection;
use App\Models\Company;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends ApiController
{
    public function __construct(
        protected CompanyService $service,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $size = $request->get('per_page') ?? config('app.per_page');
        try {
            return $this->success(__('messages.success'),
                new PaginationResourceCollection($this->service->index($size), AllCompaniesResource::class));
        } catch (Exception $e) {
            return $this->error($e->getMessage(), null, $e->getCode());
        }
    }

    public function show(Company $id): JsonResponse
    {
        return $this->success(__('messages.success'), new CompanyResource($id));
    }

    public function create(CompanyCreateRequest $request): JsonResponse
    {
        return $this->success(__('messages.success'),
            new CompanyResource($this->service->create($request->validated())));
    }

    public function update(CompanyUpdateRequest $request): JsonResponse
    {
        $company = Company::find($request->id);
        $this->service->update($company, $request->validated());
        return $this->success(__('messages.success'), new CompanyResource($company));
    }

    public function delete(Company $id): JsonResponse
    {
        $id->delete();
        return $this->success(__('messages.company_deleted', ['attribute' => $id->name]));
    }

    public function myCompany(): JsonResponse
    {
        return $this->success(__('messages.success'), new CompanyResource(auth()->user()->company));
    }

    public function updateMyCompany(MyCompanyUpdateRequest $request): JsonResponse
    {
        $this->service->update(auth()->user()->director, $request->validated());
        return $this->success(__('messages.success'), new CompanyResource(auth()->user()->director));
    }
}
