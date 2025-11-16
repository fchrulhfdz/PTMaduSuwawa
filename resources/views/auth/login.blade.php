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
                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-300 bg-white/50 backdrop-blur-sm pr-12"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="Masukkan password Anda" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 space-x-2">
                    <!-- Password Toggle Button -->
                    <button type="button" id="password-toggle" class="text-gray-400 hover:text-amber-500 transition-colors duration-300 focus:outline-none">
                        <i class="fas fa-eye" id="password-toggle-icon"></i>
                    </button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');
            const passwordToggleIcon = document.getElementById('password-toggle-icon');
            
            passwordToggle.addEventListener('click', function() {
                // Toggle password visibility
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle eye icon
                if (type === 'text') {
                    passwordToggleIcon.classList.remove('fa-eye');
                    passwordToggleIcon.classList.add('fa-eye-slash');
                    passwordToggle.classList.remove('text-gray-400');
                    passwordToggle.classList.add('text-amber-500');
                } else {
                    passwordToggleIcon.classList.remove('fa-eye-slash');
                    passwordToggleIcon.classList.add('fa-eye');
                    passwordToggle.classList.remove('text-amber-500');
                    passwordToggle.classList.add('text-gray-400');
                }
            });

            // Handle checkbox styling
            const rememberCheckbox = document.getElementById('remember_me');
            const rememberCheckboxDiv = rememberCheckbox.nextElementSibling;
            const rememberCheckboxSvg = rememberCheckboxDiv.querySelector('svg');
            const rememberCheckboxGradient = rememberCheckboxDiv.nextElementSibling;

            rememberCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rememberCheckboxSvg.style.opacity = '1';
                    rememberCheckboxGradient.style.opacity = '1';
                    rememberCheckboxDiv.style.borderColor = '#f59e0b';
                } else {
                    rememberCheckboxSvg.style.opacity = '0';
                    rememberCheckboxGradient.style.opacity = '0';
                    rememberCheckboxDiv.style.borderColor = '#d1d5db';
                }
            });

            // Initialize checkbox state
            if (rememberCheckbox.checked) {
                rememberCheckboxSvg.style.opacity = '1';
                rememberCheckboxGradient.style.opacity = '1';
                rememberCheckboxDiv.style.borderColor = '#f59e0b';
            }
        });
    </script>

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

        /* Optional: Add some spacing for the password toggle */
        #password-toggle {
            padding: 4px;
            border-radius: 4px;
        }

        #password-toggle:hover {
            background-color: rgba(245, 158, 11, 0.1);
        }
    </style>
</x-guest-layout>