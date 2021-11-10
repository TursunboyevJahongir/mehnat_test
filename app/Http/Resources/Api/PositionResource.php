<?php

namespace App\Http\Resources\Api;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
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
         * @var Position $this
         */
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
