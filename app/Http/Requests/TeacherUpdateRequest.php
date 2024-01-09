<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TeacherUpdateRequest extends FormRequest
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
            'email' => [
                'required',
                Rule::unique('teachers', 'email')->ignore($this->teacher),
                'email',
            ],
            'password' => ['nullable'],
            'image' => ['nullable', 'image', 'max:1024'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'role' => ['required', 'in:guru-mapel,wali-kelas'],
            'class_id' => ['exists:class_students,id'],
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
            'image.image' => 'Gambar siswa harus berupa gambar',
            'image.max' => 'Gambar siswa tidak boleh melebihi 1MB' ,
            'gender.required' => 'Gender siswa tidak boleh kosong',
            'gender.in' => 'Gender siswa tidak valid',
            'role.required' => 'Role tidak boleh kosong',
            'role.in' => 'Role tidak valid',
            'class_id.exists' => 'Kelas tidak ditemukan'
        ];
    }
}
