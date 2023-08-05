<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'unique:users,email', 'email'],
            'nis' => ['nullable', 'unique:users,nis', 'string', 'digits:value'],
            'password' => ['required'],
            'roles' => 'array',
        ];
    }
}
