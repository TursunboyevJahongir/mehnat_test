<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\RoleResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var Admin $this
         */
        return [
            "id" => $this->id,
            "name" => $this->name,
            'roles' => RoleResource::collection($this->roles()->get()),
            'permissions' => $this->getAllPermissions()->pluck('name')->toArray()
        ];
    }
}
