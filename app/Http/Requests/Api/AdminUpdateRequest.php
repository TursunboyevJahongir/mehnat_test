<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can('update admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                'exists:admins',
                function ($attribute, $value, $fail) {
                    if ($value === Auth::id()) {
                        $fail(__('messages.fail'), 403);
                    }
                }
            ],
            'name' => 'nullable|string',
            'login' => ['required', 'unique:admins,login,' . $this->id . 'id'],
            'password' => 'nullable|min:6',
            'roles.*' => ['nullable', 'exists:roles,name', Rule::notIn('superadmin')],
        ];
    }
}
