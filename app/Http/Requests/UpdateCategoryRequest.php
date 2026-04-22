<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['income', 'expense'])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الفئة مطلوب.',
            'name.max' => 'اسم الفئة يجب ألا يتجاوز 255 حرفاً.',
            'type.required' => 'نوع الفئة مطلوب.',
            'type.in' => 'نوع الفئة يجب أن يكون إما "دخل" أو "مصروف".',
        ];
    }
}