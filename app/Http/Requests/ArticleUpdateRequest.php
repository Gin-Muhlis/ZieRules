<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
            'title' => ['required', 'max:255', 'string'],
            'banner' => ['image', 'max:1024', 'nullable'],
            'content' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul artikel tidak boleh kosong',
            'title.max' => 'Nama Prestasi tidak boleh lebih dari 255 karakter',
            'title.string' => 'Nama harus berupa string',
            'banner.required' => 'Banner tidak boleh kosong',
            'banner.max' => 'Baner tidak boleh lebih dari 1MB',
            'content.required' => 'Konten artikel tidak boleh kosong'
        ];
    }
}
