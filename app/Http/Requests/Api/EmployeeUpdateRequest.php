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
class EmployeeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can(['update employee']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:employees',
            'phone' => [
                'required',
                'regex:/^998[0-9]{9}/',
                'unique:employees,phone,' . $this->id . ',id'
            ],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'fathers_name' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'company_id' => 'required|exists:companies,id',
            'login' => [
                'required',
                'string',
                'unique:employees,login,' . $this->id . ',id'
            ],
            'password' => 'required|string|min:6',
            'passport' => [
                'required',
                'string',
                'unique:employees,passport,' . $this->id . ',id'
            ],
            'address' => 'required|string',
        ];
    }
}
