<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    
                    {{-- أيقونة اختبار نجاح تركيب Heroicons --}}
                    <div class="mt-4 flex items-center space-x-2">
                        <x-heroicon-o-wallet class="w-10 h-10 text-blue-500" />
                        <span class="text-sm text-gray-500">Heroicons wallet icon loaded successfully</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>