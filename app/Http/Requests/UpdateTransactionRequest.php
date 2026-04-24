<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
{
    /**
     * هل يحق للمستخدم إجراء هذا الطلب؟
     */
    public function authorize(): bool
    {
        return true; // الصلاحية الرئيسية ستُفحص في Policy
    }

    /**
     * قواعد التحقق من البيانات.
     * مطابقة للتخزين تقريباً، لكن نترك التاريخ بدون 'before_or_equal' للسماح بتصحيح سجلات قديمة.
     */
    public function rules(): array
    {
        return [
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'type'        => ['required', Rule::in(['income', 'expense'])],
            'category_id' => [
                'required',
                'exists:categories,id',
                // نفس قاعدة التحقق من ملكية الفئة
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\Category::where('id', $value)
                        ->where('user_id', auth()->id())
                        ->exists();
                    if (!$exists) {
                        $fail('الفئة المختارة غير موجودة أو لا تخصك.');
                    }
                },
            ],
            'date'        => ['required', 'date'],  // بدون 'before_or_equal' لإعطاء مرونة في التعديل
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * رسائل الخطأ المخصصة بالعربية.
     */
    public function messages(): array
    {
        return [
            'amount.required'        => 'المبلغ مطلوب.',
            'amount.numeric'         => 'المبلغ يجب أن يكون رقماً.',
            'amount.min'              => 'المبلغ يجب أن يكون أكبر من صفر.',
            'type.required'           => 'نوع المعاملة مطلوب.',
            'type.in'                 => 'نوع المعاملة يجب أن يكون "دخل" أو "مصروف".',
            'category_id.required'    => 'الفئة مطلوبة.',
            'category_id.exists'      => 'الفئة المختارة غير موجودة.',
            'date.required'           => 'التاريخ مطلوب.',
            'date.date'               => 'التاريخ غير صالح.',
            'description.max'         => 'الوصف لا يتجاوز 500 حرف.',
        ];
    }
}