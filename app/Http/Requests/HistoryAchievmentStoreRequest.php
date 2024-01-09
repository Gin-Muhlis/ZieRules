<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryAchievmentStoreRequest extends FormRequest
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
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'achievment_id' => ['required', 'exists:achievments,id'],
            'date' => ['required', 'date'],
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
        ];
    }
}
