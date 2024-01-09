<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassStudentUpdateRequest extends FormRequest
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
            'code' => ['required', 'max:255', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Kelas tidak boleh kosong',
            'name.max' => 'Nama kelas tidak boleh lebih dari 255 karakter',
            'name.string' => 'Nama Kelas harus berupa string',
            'code.required' => 'Kode Kelas tidak boleh kosong',
            'code.max' => 'Kode Kelas tidak boleh lebih dari 255 karakter',
            'code.string' => 'Kode Kelas harus berupa string',
        ];
    }
}
