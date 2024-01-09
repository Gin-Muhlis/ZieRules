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
            'name' => ['required', 'max:255', 'string'],
            'password' => ['required'],
            'email' => ['required', 'unique:users,email', 'email'],
            'roles' => ['array', 'required'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama siswa tidak boleh kosong',
            'name.max' => 'Nama siswa tidak boleh melebihi 255 karakter',
            'name.string' => 'Nama siswa harus berupa string',
            'email.required' => 'email siswa tidak boleh kosong',
            'email.unique' => 'email telah digunakan, tidak diperbolehkan sama',
            'email.email' => 'email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
            'role.required' => 'Role tidak boleh kosong',
            'role.array' => 'Format role tidak valid',
        ];
    }
}
