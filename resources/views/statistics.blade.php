<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Statistics') }}
            </h2>
            <span class="text-sm text-gray-500">{{ now()->format('F Y') }}</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- بطاقات الإجماليات --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- إجمالي الدخل --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Total Income') }}</p>
                            <p class="text-2xl font-bold text-green-600">${{ number_format($totalIncome, 2) }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <x-heroicon-o-arrow-down-circle class="w-6 h-6 text-green-600" />
                        </div>
                    </div>
                </div>

                {{-- إجمالي المصروفات --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Total Expenses') }}</p>
                            <p class="text-2xl font-bold text-red-600">${{ number_format($totalExpenses, 2) }}</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <x-heroicon-o-arrow-up-circle class="w-6 h-6 text-red-600" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- مخططات --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Spending Breakdown (دائري) --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Spending Breakdown') }}</h3>
                    <div class="relative" style="height: 280px;">
                        <canvas id="spendingPieChart"></canvas>
                    </div>
                </div>

                {{-- Monthly Income (شريطي) --}}
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Monthly Income') }}</h3>
                    <div class="relative" style="height: 280px;">
                        <canvas id="monthlyIncomeChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- ملخص سريع --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Quick Summary') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500">{{ __('Total Income') }}</p>
                        <p class="text-xl font-bold text-green-600">${{ number_format($totalIncome, 2) }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500">{{ __('Total Expenses') }}</p>
                        <p class="text-xl font-bold text-red-600">${{ number_format($totalExpenses, 2) }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500">{{ __('Net Savings') }}</p>
                        <p class="text-xl font-bold {{ $totalIncome - $totalExpenses >= 0 ? 'text-indigo-600' : 'text-orange-600' }}">
                            ${{ number_format($totalIncome - $totalExpenses, 2) }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // بيانات المخطط الدائري
        const pieCtx = document.getElementById('spendingPieChart').getContext('2d');
        const pieLabels = {!! json_encode($spendingByCategory->pluck('name')) !!};
        const pieData = {!! json_encode($spendingByCategory->pluck('total')) !!};

        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: ['#6366f1', '#8b5cf6', '#d946ef', '#ec4899', '#f43f5e', '#f97316'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'right' } }
            }
        });

        // بيانات المخطط الشريطي للدخل الشهري
        const incomeCtx = document.getElementById('monthlyIncomeChart').getContext('2d');
        const last6Months = {!! json_encode(collect()->range(5,0)->map(fn($i) => now()->subMonths($i)->format('M'))) !!};
        const monthlyData = {!! json_encode($monthlyIncome) !!};

        const incomeData = last6Months.map(month => monthlyData[month]?.total || 0);

        new Chart(incomeCtx, {
            type: 'bar',
            data: {
                labels: last6Months,
                datasets: [{
                    label: 'Income',
                    data: incomeData,
                    backgroundColor: '#6366f1',
                    borderRadius: 6
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