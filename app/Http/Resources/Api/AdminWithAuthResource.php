<?php

namespace App\Http\Resources\Api;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminWithAuthResource extends JsonResource
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
            "auth_token" => $this->auth_token,
        ];
    }
}
