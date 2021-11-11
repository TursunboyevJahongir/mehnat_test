<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProjectUpdateRequest
 * @package App\Http\Requests
 */
class PositionUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can('update position');
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
