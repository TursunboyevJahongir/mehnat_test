<?php

namespace App\Http\Requests\Api\Director;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProjectUpdateRequest
 * @package App\Http\Requests
 */
class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $id = Auth::id();
        return [
            'phone' => [
                'required',
                'regex:/^998[0-9]{9}/',
                'unique:employees,phone,' . $id . ',id'
            ],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'fathers_name' => 'required|string',
            'current_password' => ['required_with:new_password', 'min:6', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password))
                    $fail(__('messages.invalid_password'));
            }],
            'new_password' => 'required_with:current_password|confirmed|min:6',
            'passport' => [
                'required',
                'string',
                'unique:employees,passport,' . $id . ',id'
            ],
            'address' => 'required|string',
        ];
    }
}
