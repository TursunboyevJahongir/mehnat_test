<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'nullable|string',
//            'login' => 'required|unique:users,email',//login will not be updated
            'current_password' => ['required_with:new_password', 'min:6', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password))
                    $fail(__('messages.invalid_password'));
            }],
            'new_password' => 'required_with:current_password|confirmed|min:6'
        ];
    }
}
