<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totals = DB::table('transactions')
            ->where('user_id', $userId)
            ->selectRaw("
                SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income,
                SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expenses
            ")
            ->first();

        $totalIncome = $totals->total_income ?? 0;
        $totalExpenses = $totals->total_expenses ?? 0;
        $netBalance = $totalIncome - $totalExpenses;

        $spendingByCategory = DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $userId)
            ->where('transactions.type', 'expense')
            ->groupBy('categories.name')
            ->select('categories.name', DB::raw('SUM(transactions.amount) as total'))
            ->orderByDesc('total')
            ->get();

        $recentTransactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->latest('date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalIncome',
            'totalExpenses',
            'netBalance',
            'spendingByCategory',
            'recentTransactions'
        ));
    }
}