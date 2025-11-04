<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
            <div class="relative">
                <x-text-input 
                    id="email" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-300 bg-white/50 backdrop-blur-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="Masukkan email Anda" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />
            <div class="relative">
                <x-text-input 
                    id="password" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="Masukkan password Anda" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <div class="relative">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        class="sr-only"
                        name="remember" />
                    <div class="w-5 h-5 bg-white border-2 border-gray-300 rounded-md group-hover:border-amber-400 transition-colors duration-300 flex items-center justify-center">
                        <svg class="w-3 h-3 text-amber-600 opacity-0 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="absolute inset-0 rounded-md bg-gradient-to-r from-amber-500 to-orange-500 opacity-0 scale-50 group-hover:scale-100 transition-all duration-300"></div>
                </div>
                <span class="ms-3 text-sm text-gray-600 font-medium group-hover:text-gray-800 transition-colors duration-300">
                    {{ __('Remember me') }}
                </span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-amber-600 hover:text-amber-700 transition-colors duration-300 underline-offset-4 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 flex items-center justify-center space-x-2 group">
                <span>{{ __('Log in') }}</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
            </button>
        </div>
    </form>

    <!-- Register Button -->
    @if (Route::has('register'))
        <div class="pt-4">
            <a href="{{ route('register') }}" class="w-full block text-center bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 py-3 px-4 rounded-xl font-semibold shadow hover:shadow-md transition-all duration-300 hover:scale-[1.02] transform focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                {{ __('Register') }}
            </a>
        </div>
    @endif

    <style>
        input:checked + div + div {
            opacity: 1;
        }
        
        input:checked + div svg {
            opacity: 1;
        }
        
        input:checked + div {
            border-color: #f59e0b;
        }
    </style>
</x-guest-layout>