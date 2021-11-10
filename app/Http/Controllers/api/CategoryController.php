<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\api\CategoryCreateRequest;
use App\Http\Requests\api\CategoryUpdateRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\PaginationResourceCollection;
use App\Http\Resources\Api\ProductResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function __construct(private CategoryService $service)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $orderBy = $request->orderby ?? "position";
        $sort = $request->sort ?? "DESC";
        $categories = $this->service->index($orderBy, $sort);
        return $this->success(__('messages.success'), CategoryResource::collection($categories));
    }

    /**
     * Display a listing of the resource.
     *
     * @param CategoryCreateRequest $request
     * @return JsonResponse
     */
    public function store(CategoryCreateRequest $request): JsonResponse
    {
        $Category = $this->service->create($request->validated());
        return $this->success(__('messages.success'), new CategoryResource($Category));
    }

    /**
     * Display a listing of the resource.
     *
     * @param CategoryUpdateRequest $request
     * @return JsonResponse
     */
    public function update(CategoryUpdateRequest $request): JsonResponse
    {
        $Category = $this->service->update($request->validated());
        return $this->success(__('messages.success'), new CategoryResource($Category));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Category $id
     * @return JsonResponse
     */
    public function delete(Category $id): JsonResponse
    {
        $this->service->delete($id);
        return $this->success(__('messages.success'));
    }

    /**
     * @param Category $id
     * @param ProductService $productService
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function products(Category $id, ProductService $productService, Request $request): JsonResponse
    {
        $size = $request->per_page ?? config('app.per_page');
        $orderBy = $request->orderby ?? "position";
        $sort = $request->sort ?? "DESC";
        $min = $request->min ?? null;
        $max = $request->max ?? null;

        $data = $productService->categoryProducts($id, $size, $orderBy, $sort, $min, $max);
        return $this->success(__('messages.success'), new PaginationResourceCollection($data['products'],
            ProductResource::class), $data['append']);
    }
}
