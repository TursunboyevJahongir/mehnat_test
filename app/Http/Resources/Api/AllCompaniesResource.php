<?php

namespace App\Http\Resources\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllCompaniesResource extends JsonResource
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
         * @var Company $this
         */
        return [
            "id" => $this->id,
            "name" => $this->name,
            "full_name" => $this->chief?->full_name,
            "phone" => $this->phone,
            "address" => $this->address,
        ];
    }
}
