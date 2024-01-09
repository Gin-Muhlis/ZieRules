<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViolationStoreRequest extends FormRequest
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
            'point' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama pelanggaran tidak boleh kosong',
            'name.max' => 'Nama pelanggaran tidak boleh lebih dari 255 karakter',
            'name.string' => 'Nama pelanggaran harus berupa string',
            'point.required' => 'Poin pelanggaran tidak boleh kosong',
            'point.numeric' => 'Poin pelanggaran harus berupa angka'
        ];
    }
}
