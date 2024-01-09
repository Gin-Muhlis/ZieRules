<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataAchievmentStoreRequest extends FormRequest
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
            'achievment_id' => ['required', 'exists:achievments,id'],
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'achievment_id.required' => 'Prestasi tidak boleh kosong',
            'achievment_id.exists' => 'Prestasi tidak ditemukan',
            'student_id.required' => 'Siswa tidak boleh kosong',
            'student_id.exists' => 'Siswa tidak ditemukan',
            'teacher_id.required' => 'Guru tidak boleh kosong',
            'teacher_id.exists' => 'Guru tidak ditemukan',
            'date.required' => 'Tanggal tidak boleh kosong',
            'date.date' => 'Format tanggal tidak valid',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'description.string' => 'Deskrip harus berupa string'
        ];
    }
}
