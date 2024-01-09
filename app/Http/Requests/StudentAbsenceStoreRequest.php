<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentAbsenceStoreRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'student_id' => ['required', 'exists:students,id'],
            'presence_id' => ['required', 'exists:presences,id'],
            'time' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Tanggal absensi tidak boleh kosong',
            'date.date' => 'Format tanggal tidak valid',
            'student_id.required' => 'Siswa tidak boleh kosong',
            'student_id.exists' => 'Siswa tidak ditemukan',
            'presence.required' => 'Kehadiran tidak boleh kosong',
            'presence.exists' => 'Kehadiran tidak ditemukan',
        ];
    }
}
