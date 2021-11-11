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
class MyCompanyUpdateRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'regex:/^998[0-9]{9}/',
                'unique:companies,phone,' . auth()->user()->director->id . ',id'
            ],
            'name' => 'required|string',
            'email' => 'required|email',
            'site' => 'required|url',
            'address' => 'required|string',
        ];
    }
}
