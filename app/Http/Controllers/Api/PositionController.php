<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\PositionCreateRequest;
use App\Http\Requests\Api\PositionUpdateRequest;
use App\Http\Resources\Api\PositionResource;
use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(__('messages.success'), PositionResource::collection(Position::query()->get()));
    }

    /**
     * @param PositionCreateRequest $request
     * @return JsonResponse
     */
    public function create(PositionCreateRequest $request): JsonResponse
    {
        return $this->success(__('messages.success'), new PositionResource(Position::query()->create($request->validated())));
    }

    /**
     * @param PositionUpdateRequest $request
     * @param Position $id
     * @return JsonResponse
     */
    public function update(PositionUpdateRequest $request, Position $id): JsonResponse
    {
        $id->update($request->validated());
        return $this->success(__('messages.success'), new PositionResource($id));
    }

    /**
     * @param Position $id
     * @return JsonResponse
     */
    public function delete(Position $id): JsonResponse
    {
        if ($id->id === 1) {
            return $this->error(__('messages.cannot_delete_using_element'));
        }
        $id->delete();
        return $this->success(__('messages.position_deleted', ['attribute' => $id->name]));
    }
}
