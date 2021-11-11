<?php

namespace App\Http\Resources\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "fathers_name" => $this->fathers_name,
            "position" => $this->position->name,
            "company" => new CompanyResource($this->company),
            "login" => $this->login,
            "phone" => $this->phone,
            "address" => $this->address,
            "passport" => $this->passport,
        ];
    }
}
