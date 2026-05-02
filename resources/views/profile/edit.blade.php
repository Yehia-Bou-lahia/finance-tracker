<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- بطاقة الملف الشخصي --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="p-2 bg-indigo-100 rounded-full">
                        <x-heroicon-o-user-circle class="w-6 h-6 text-indigo-600" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Profile Information') }}</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6">{{ __("Update your account's profile information and email address.") }}</p>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required autofocus
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- بطاقة كلمة المرور --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="p-2 bg-yellow-100 rounded-full">
                        <x-heroicon-o-lock-closed class="w-6 h-6 text-yellow-600" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Update Password') }}</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">{{ __('Current Password') }}</label>
                        <input type="password" name="current_password" id="current_password" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">{{ __('New Password') }}</label>
                        <input type="password" name="password" id="password" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- بطاقة حذف الحساب --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="p-2 bg-red-100 rounded-full">
                        <x-heroicon-o-trash class="w-6 h-6 text-red-600" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Delete Account') }}</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="mb-4">
                        <label for="password_delete" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                        <input type="password" name="password" id="password_delete" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                               placeholder="{{ __('Enter your password to confirm') }}">
                        @error('password', 'userDeletion')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="px-6 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>