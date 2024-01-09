<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeroomStoreRequest extends FormRequest
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
            'teacher_id' => ['required', 'exists:teachers,id'],
            'class_id' => ['required', 'exists:class_students,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'class_id.required' => 'Kelas tidak boleh kosong',
            'class_id.exists' => 'Kelas tidak ditemukan',
            'teacher_id.required' => 'Guru tidak boleh kosong',
            'teacher_id.exists' => 'Guru tidak ditemukan',
        ];
    }
}
