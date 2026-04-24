<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    /**
     * هل يحق للمستخدم عرض قائمة معاملاته؟
     */
    public function viewAny(User $user): bool
    {
        return true; // سيتم تصفية النتائج لاحقاً في الـ Controller
    }

    /**
     * هل يحق للمستخدم عرض تفاصيل معاملة محددة؟
     * فقط إذا كان هو مالك المعاملة.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id;
    }

    /**
     * هل يحق للمستخدم إنشاء معاملة جديدة؟
     * أي مستخدم مسجل الدخول يمكنه ذلك.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * هل يحق للمستخدم تعديل هذه المعاملة؟
     * فقط إذا كان هو مالكها.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id;
    }

    /**
     * هل يحق للمستخدم حذف هذه المعاملة؟
     * فقط إذا كان هو مالكها.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id;
    }
}