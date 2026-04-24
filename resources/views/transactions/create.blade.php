<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- عرض الأخطاء العامة --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        {{-- المبلغ --}}
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">{{ __('Amount') }}</label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0.01" step="0.01"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="0.00">
                        </div>

                        {{-- النوع (دخل / مصروف) --}}
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                            <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">{{ __('Select Type') }}</option>
                                <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>{{ __('Income') }}</option>
                                <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>{{ __('Expense') }}</option>
                            </select>
                        </div>

                        {{-- الفئة --}}
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                            <select name="category_id" id="category_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->type === 'income' ? __('Income') : __('Expense') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- التاريخ --}}
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">{{ __('Date') }}</label>
                            <input type="date" name="date" id="date" value="{{ old('date') }}" required max="{{ now()->toDateString() }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        {{-- الوصف --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                            <textarea name="description" id="description" rows="3" maxlength="500"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                      placeholder="{{ __('Optional description') }}">{{ old('description') }}</textarea>
                        </div>

                        {{-- أزرار الإجراءات --}}
                        <div class="flex items-center justify-end">
                            <a href="{{ route('transactions.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>