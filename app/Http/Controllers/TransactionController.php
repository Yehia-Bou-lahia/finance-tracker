<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * عرض قائمة المعاملات الخاصة بالمستخدم الحالي.
     */
    public function index()
    {
        $transactions = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);
    
        // حساب الرصيد للمحفظة
        $totals = \Illuminate\Support\Facades\DB::table('transactions')
            ->where('user_id', Auth::id())
            ->selectRaw("
                SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income,
                SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expenses
            ")
            ->first();
    
        $balance = ($totals->total_income ?? 0) - ($totals->total_expenses ?? 0);
    
        return view('transactions.index', compact('transactions', 'balance'));
    }

    /**
     * عرض صفحة إنشاء معاملة جديدة.
     */
    public function create()
    {
        // نمرر فئات المستخدم فقط ليختار منها
        $categories = Category::where('user_id', Auth::id())->orderBy('name')->get();

        return view('transactions.create', compact('categories'));
    }

    /**
     * تخزين معاملة جديدة في قاعدة البيانات.
     */
    public function store(StoreTransactionRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        Transaction::create($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'تمت إضافة المعاملة بنجاح.');
    }

    /**
     * عرض صفحة تعديل معاملة.
     */
    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $categories = Category::where('user_id', Auth::id())->orderBy('name')->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * تحديث بيانات معاملة في قاعدة البيانات.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validated();
        $transaction->update($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'تم تحديث المعاملة بنجاح.');
    }

    /**
     * حذف معاملة من قاعدة البيانات.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'تم حذف المعاملة بنجاح.');
    }
}