<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
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
            'class' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Tugas tidak boleh kosong',
            'name.max' => 'Nama Tugas tidak boleh melebihi 255 karakter',
            'name.string' => 'Nama Tugas harus berupa string',
            'class.required' => 'Kelas tidak boleh kosong',
            'class.max' => 'Kelas tidak boleh melebihi 255 karakter',
            'class.string' => 'Kelas harus berupa string',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'description.max' => 'Deskripsi tidak boleh melebihi 255 karakter',
            'description.string' => 'Deskripsi harus berupa string',
        ];
    }
}
