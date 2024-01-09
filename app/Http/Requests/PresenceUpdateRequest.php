<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresenceUpdateRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama absensi tidak boleh kosong',
            'name.max' => 'Nama absensi tidak boleh melebihi 255 karakter',
            'name.string' => 'Nama absensi harus berupa string'
        ];
    }
}
