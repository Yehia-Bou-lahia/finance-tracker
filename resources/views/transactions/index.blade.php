<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Wallet') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- بطاقة الرصيد الكبيرة --}}
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-indigo-200">{{ __('Available Balance') }}</p>
                        <p class="text-3xl font-bold mt-1">${{ number_format($balance ?? 0, 2) }}</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <x-heroicon-o-wallet class="w-8 h-8 text-white" />
                    </div>
                </div>
                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('transactions.create') }}" class="flex-1 bg-white text-indigo-700 py-2 px-4 rounded-lg text-sm font-semibold text-center hover:bg-indigo-50 transition">
                        {{ __('Add Money') }}
                    </a>
                    <a href="{{ route('transactions.create') }}?type=expense" class="flex-1 bg-indigo-500 text-white py-2 px-4 rounded-lg text-sm font-semibold text-center hover:bg-indigo-400 transition border border-indigo-400">
                        {{ __('Send Money') }}
                    </a>
                </div>
            </div>

            {{-- شريط البحث والفلترة --}}
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('All Transactions') }}</h3>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" placeholder="{{ __('Search transactions...') }}" 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" />
                        </div>
                        <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            <x-heroicon-o-plus-circle class="w-5 h-5 mr-1" />
                            {{ __('Add') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- رسائل النجاح والخطأ --}}
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                    <div class="flex">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-green-400 mr-2" />
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <div class="flex">
                        <x-heroicon-o-exclamation-circle class="w-5 h-5 text-red-400 mr-2" />
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- قائمة المعاملات --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Transaction') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Category') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition">
                                    {{-- تفاصيل المعاملة --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="p-2 {{ $transaction->type === 'income' ? 'bg-green-100' : 'bg-red-100' }} rounded-full mr-3">
                                                @if($transaction->type === 'income')
                                                    <x-heroicon-o-arrow-down-circle class="w-5 h-5 text-green-600" />
                                                @else
                                                    <x-heroicon-o-arrow-up-circle class="w-5 h-5 text-red-600" />
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $transaction->description ?? $transaction->category->name ?? '' }}</p>
                                                <p class="text-xs text-gray-500">{{ $transaction->type === 'income' ? __('Income') : __('Expense') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- التاريخ --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction->date->format('M d, Y') }}
                                    </td>
                                    {{-- الفئة --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    {{-- المبلغ --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                    </td>
                                    {{-- أزرار الإجراءات --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-indigo-600 hover:text-indigo-900 transition">
                                            <x-heroicon-o-pencil-square class="w-5 h-5 inline" />
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition">
                                                <x-heroicon-o-trash class="w-5 h-5 inline" />
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <x-heroicon-o-inbox class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                                        <p class="text-sm text-gray-500">{{ __('No transactions yet.') }}</p>
                                        <a href="{{ route('transactions.create') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-800">{{ __('Add your first transaction') }}</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- الترقيم --}}
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>