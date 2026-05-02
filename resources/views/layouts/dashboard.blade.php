<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Financial Dashboard') }}
            </h2>
            <span class="text-sm text-gray-500">{{ now()->format('F d, Y') }}</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- صف البطاقات الأربع --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- 1. Total Spent --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Total Spent') }}</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($totalExpenses, 2) }}</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <x-heroicon-o-arrow-trending-up class="w-6 h-6 text-red-600" />
                        </div>
                    </div>
                </div>

                {{-- 2. Monthly Budget --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Monthly Budget') }}</p>
                            <p class="text-2xl font-bold text-gray-900">$1,500.00</p>
                            <p class="text-xs text-green-600">$249.25 {{ __('remaining') }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <x-heroicon-o-banknotes class="w-6 h-6 text-blue-600" />
                        </div>
                    </div>
                </div>

                {{-- 3. Savings Progress --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Savings Progress') }}</p>
                            <p class="text-2xl font-bold text-gray-900">$2,350.00</p>
                            <p class="text-xs text-gray-600">78% {{ __('of $3,000 goal') }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <x-heroicon-o-arrow-trending-up class="w-6 h-6 text-green-600" />
                        </div>
                    </div>
                    <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 78%"></div>
                    </div>
                </div>

                {{-- 4. Net Balance --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Net Balance') }}</p>
                            <p class="text-2xl font-bold {{ $netBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($netBalance, 2) }}
                            </p>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-full">
                            <x-heroicon-o-scale class="w-6 h-6 text-indigo-600" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- صف المخططات --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Spending Breakdown (مخطط دائري) --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Spending Breakdown') }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ __('Your expense categories this month') }}</p>
                    <div class="relative" style="height: 250px;">
                        <canvas id="spendingChart"></canvas>
                    </div>
                    <p class="text-center text-sm font-medium text-gray-900 mt-3">
                        {{ __('Total Spent') }}: <span class="font-bold">${{ number_format($totalExpenses, 2) }}</span>
                    </p>
                </div>

                {{-- Spending Trends (مخطط خطي) --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Spending Trends') }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ __('6-month spending overview') }}</p>
                    <div class="relative" style="height: 250px;">
                        <canvas id="trendsChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- صف الإجراءات السريعة وأحدث النشاطات --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Quick Actions --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Quick Actions') }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ __('Manage your finances efficiently') }}</p>
                    <div class="space-y-3">
                        <a href="{{ route('transactions.create') }}" class="flex items-center p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                            <x-heroicon-o-plus-circle class="w-6 h-6 text-indigo-600 mr-3" />
                            <span class="text-sm font-medium text-indigo-700">{{ __('Add Transaction') }}</span>
                        </a>
                        <a href="{{ route('categories.create') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <x-heroicon-o-folder-plus class="w-6 h-6 text-green-600 mr-3" />
                            <span class="text-sm font-medium text-green-700">{{ __('Add Category') }}</span>
                        </a>
                        <a href="{{ route('transactions.index') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <x-heroicon-o-document-chart-bar class="w-6 h-6 text-blue-600 mr-3" />
                            <span class="text-sm font-medium text-blue-700">{{ __('View Transactions') }}</span>
                        </a>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Recent Activity') }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ __('Your latest transactions') }}</p>
                    <div class="space-y-4">
                        @forelse ($recentTransactions as $transaction)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 {{ $transaction->type === 'income' ? 'bg-green-100' : 'bg-red-100' }} rounded-full">
                                        @if($transaction->type === 'income')
                                            <x-heroicon-o-arrow-down-circle class="w-5 h-5 text-green-600" />
                                        @else
                                            <x-heroicon-o-arrow-up-circle class="w-5 h-5 text-red-600" />
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $transaction->description ?? $transaction->category->name ?? '' }}</p>
                                        <p class="text-xs text-gray-500">{{ $transaction->date->format('M d') }} · {{ $transaction->category->name ?? '' }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">{{ __('No transactions yet. Start by adding one!') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- تضمين Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // بيانات المخطط الدائري
        const spendingCtx = document.getElementById('spendingChart').getContext('2d');
        const spendingLabels = {!! json_encode($spendingByCategory->pluck('name')) !!};
        const spendingData = {!! json_encode($spendingByCategory->pluck('total')) !!};

        new Chart(spendingCtx, {
            type: 'doughnut',
            data: {
                labels: spendingLabels,
                datasets: [{
                    data: spendingData,
                    backgroundColor: ['#6366f1', '#8b5cf6', '#d946ef', '#ec4899', '#f43f5e', '#f97316'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });

        // بيانات المخطط الخطي
        const trendsCtx = document.getElementById('trendsChart').getContext('2d');
        const monthLabels = {!! json_encode(collect()->range(5,0)->map(fn($i) => now()->subMonths($i)->format('M'))) !!};
        const trendsData = [850, 920, 780, 1100, 950, {{ $totalExpenses }}];

        new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Spending',
                    data: trendsData,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</x-app-layout>