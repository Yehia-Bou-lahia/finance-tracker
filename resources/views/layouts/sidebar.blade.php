<aside class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-200 flex flex-col z-50">
    
    {{-- الشعار --}}
    <div class="flex items-center space-x-3 px-6 py-5 border-b border-gray-100">
        <x-heroicon-o-wallet class="w-8 h-8 text-indigo-600" />
        <span class="text-xl font-bold text-gray-800">FinanceTracker Pro</span>
    </div>

    {{-- قائمة التنقل --}}
    <nav class="flex-1 px-4 py-6 space-y-1">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium 
                  {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
            <x-heroicon-o-chart-bar class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-400' }}" />
            <span>{{ __('Dashboard') }}</span>
        </a>

        {{-- Wallet / Transactions --}}
        <a href="{{ route('transactions.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium 
                  {{ request()->routeIs('transactions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
            <x-heroicon-o-wallet class="w-5 h-5 {{ request()->routeIs('transactions.*') ? 'text-indigo-600' : 'text-gray-400' }}" />
            <span>{{ __('Wallet') }}</span>
        </a>

        {{-- Statistics --}}
        <a href="{{ route('statistics') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium 
                  {{ request()->routeIs('statistics') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
            <x-heroicon-o-chart-pie class="w-5 h-5 {{ request()->routeIs('statistics') ? 'text-indigo-600' : 'text-gray-400' }}" />
            <span>{{ __('Statistics') }}</span>
        </a>

        {{-- Categories --}}
        <a href="{{ route('categories.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium 
                  {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
            <x-heroicon-o-tag class="w-5 h-5 {{ request()->routeIs('categories.*') ? 'text-indigo-600' : 'text-gray-400' }}" />
            <span>{{ __('Categories') }}</span>
        </a>

        {{-- Settings --}}
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium 
                  {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
            <x-heroicon-o-cog-8-tooth class="w-5 h-5 {{ request()->routeIs('profile.*') ? 'text-indigo-600' : 'text-gray-400' }}" />
            <span>{{ __('Settings') }}</span>
        </a>
    </nav>

    {{-- معلومات المستخدم وتسجيل الخروج --}}
    <div class="border-t border-gray-100 px-4 py-4">
        <div class="flex items-center space-x-3 mb-3">
            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                <x-heroicon-o-user-circle class="w-5 h-5 text-indigo-600" />
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5" />
                <span>{{ __('Log Out') }}</span>
            </button>
        </form>
    </div>

</aside>