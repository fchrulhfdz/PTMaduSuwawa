<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
            <div class="relative">
                <x-text-input 
                    id="email" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-300 bg-white/50 backdrop-blur-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email', $request->email)" 
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
                    autocomplete="new-password"
                    placeholder="Password baru" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-gray-700" />
            <div class="relative">
                <x-text-input 
                    id="password_confirmation" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                    type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="Konfirmasi password baru" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end pt-4">
            <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-500 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 flex items-center justify-center space-x-2 group">
                <span>{{ __('Reset Password') }}</span>
                <i class="fas fa-redo group-hover:rotate-180 transition-transform duration-300"></i>
            </button>
        </div>
    </form>
</x-guest-layout>