<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // الإجماليات
        $totals = DB::table('transactions')
            ->where('user_id', $userId)
            ->selectRaw("
                SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income,
                SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expenses
            ")
            ->first();

        $totalIncome = $totals->total_income ?? 0;
        $totalExpenses = $totals->total_expenses ?? 0;

        // توزيع المصروفات حسب الفئة
        $spendingByCategory = DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $userId)
            ->where('transactions.type', 'expense')
            ->groupBy('categories.name')
            ->select('categories.name', DB::raw('SUM(transactions.amount) as total'))
            ->orderByDesc('total')
            ->get();

        // الدخل الشهري (آخر 6 أشهر)
        $monthlyIncome = DB::table('transactions')
            ->where('user_id', $userId)
            ->where('type', 'income')
            ->where('date', '>=', now()->subMonths(6))
            ->groupBy(DB::raw("DATE_TRUNC('month', date)"))
            ->select(DB::raw("DATE_TRUNC('month', date) as month"), DB::raw('SUM(amount) as total'))
            ->orderBy('month')
            ->get()
            ->keyBy(fn($item) => \Carbon\Carbon::parse($item->month)->format('M'));

        return view('statistics', compact(
            'totalIncome',
            'totalExpenses',
            'spendingByCategory',
            'monthlyIncome'
        ));
    }
}