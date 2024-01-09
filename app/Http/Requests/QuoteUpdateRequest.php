<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteUpdateRequest extends FormRequest
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
            'quote' => ['required', 'max:255', 'string'],
            'teacher_id' => ['required', 'exists:teachers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'quote.required' => 'Quote tidak boleh kosong',
            'quote.max' => 'Quote tidak boleh melebihi 255 karakter',
            'quote.string' => 'Quote harus berupa string',
            'teacher_id.required' => 'Guru tidak boleh kosong',
            'teacher_id.exists' => 'Guru tidak ditemukan'
        ];
    }
}
