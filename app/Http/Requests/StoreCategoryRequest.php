<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    /**
     * هل يحق للمستخدم إجراء هذا الطلب؟
     */
    public function authorize(): bool
    {
        return true; // سيتم التحقق من الصلاحية في الـ Policy لاحقاً
    }

    /**
     * قواعد التحقق من البيانات.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['income', 'expense'])],
        ];
    }

    /**
     * رسائل الخطأ المخصصة بالعربية (اختياري).
     */
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