<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * هل يحق للمستخدم عرض قائمة الفئات؟
     * أي مستخدم مسجل الدخول يمكنه رؤية فئاته الخاصة (سيتم تصفيتها لاحقاً في الـ Controller).
     */
    public function viewAny(User $user): bool
    {
        return true; // نسمح بالدخول للصفحة، وسنفلتر البيانات لاحقاً
    }

    /**
     * هل يحق للمستخدم عرض تفاصيل فئة محددة؟
     * فقط إذا كان هو مالك الفئة.
     */
    public function view(User $user, Category $category): bool
    {
        return $user->id === $category->user_id;
    }

    /**
     * هل يحق للمستخدم إنشاء فئة جديدة؟
     * أي مستخدم مسجل الدخول يمكنه ذلك.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * هل يحق للمستخدم تحديث هذه الفئة؟
     * فقط إذا كان هو مالك الفئة.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->id === $category->user_id;
    }

    /**
     * هل يحق للمستخدم حذف هذه الفئة؟
     * فقط إذا كان هو مالك الفئة.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->id === $category->user_id;
    }

    /**
     * هل يحق للمستخدم استعادة فئة محذوفة (إذا استخدمنا Soft Deletes)؟
     */
    public function restore(User $user, Category $category): bool
    {
        return $user->id === $category->user_id;
    }

    /**
     * هل يحق للمستخدم حذف الفئة نهائياً من قاعدة البيانات؟
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return $user->id === $category->user_id;
    }
}