<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            'nis' => [
                'required',
                Rule::unique('students', 'nis')->ignore($this->student),
                'digits:9',
                'numeric',
            ],
            'password' => ['nullable'],
            'image' => ['nullable', 'image', 'max:1024'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'class_id' => ['required', 'exists:class_students,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama siswa tidak boleh kosong',
            'name.max' => 'Nama siswa tidak boleh melebihi 255 karakter',
            'name.string' => 'Nama siswa harus berupa string',
            'nis.required' => 'NIS siswa tidak boleh kosong',
            'nis.digits' => 'NIS siswa harus 9 digit',
            'nis.numeric' => 'NIS siswa harus berupa angka',
            'password.required' => 'Password tidak boleh kosong',
            'image.image' => 'Gambar siswa harus berupa gambar',
            'image.max' => 'Gambar siswa tidak boleh melebihi 1MB' ,
            'gender.required' => 'Gender siswa tidak boleh kosong',
            'gender.in' => 'Gender siswa tidak valid',
            'class_id.required' => 'Kelas tidak boleh kosong',
            'class_id.exists' => 'Kelas tidak ditemukan',
            'code.required' => 'Kode siswa tidak boleh kosong',
            'code.numeric' => 'Kode siswa harus berupa angka'
        ];
    }
}
