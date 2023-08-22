<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'nis' => ['required', 'unique:students,nis', 'digits:9', 'numeric'],
            'password' => ['required'],
            'image' => ['nullable', 'image', 'max:1024'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'class_id' => ['required', 'exists:class_students,id'],
            'code' => ['required', 'numeric', 'digits:11'],
        ];
    }
}
