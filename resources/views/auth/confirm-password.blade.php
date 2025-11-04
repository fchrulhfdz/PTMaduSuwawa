<x-guest-layout>
    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-200">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-shield-alt text-white text-sm"></i>
            </div>
            <p class="text-sm text-blue-700 font-medium">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

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

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-500 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 flex items-center justify-center space-x-2 group">
                <span>{{ __('Confirm') }}</span>
                <i class="fas fa-check group-hover:scale-110 transition-transform duration-300"></i>
            </button>
        </div>
    </form>
</x-guest-layout>