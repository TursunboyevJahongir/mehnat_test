<?php

namespace App\Http\Resources\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /**
         * @var Employee $this
         */
        return [
            "id" => $this->id,
            "full_name" => $this->full_name,
            "position" => $this->position->name,
            "company" => $this->company?->name,
            "phone" => $this->phone,
        ];
    }
}
