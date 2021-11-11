<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProjectUpdateRequest
 * @package App\Http\Requests
 */
class CompanyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can(['update company']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:companies',
            'phone' => [
                'required',
                'regex:/^998[0-9]{9}/',
                'unique:companies,phone,' . $this->id . ',id'
            ],
            'name' => 'required|string',
            'chief_id' => [
                'required',
                'exists:employees,id',
                'unique:companies,chief_id,' . $this->id . ',id'
            ],
            'email' => 'required|email',
            'site' => 'required|url',
            'address' => 'required|string',
        ];
    }
}
