<x-guest-layout>
    <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-envelope-open-text text-white text-sm"></i>
            </div>
            <p class="text-sm text-green-700 font-medium">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-200">
            <div class="flex items-center space-x-3">
                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-white text-xs"></i>
                </div>
                <p class="text-sm text-blue-700 font-medium">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </p>
            </div>
        </div>
    @endif

    <div class="mt-6 flex items-center justify-between space-x-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-500 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 flex items-center justify-center space-x-2 group">
                <span>{{ __('Resend Verification Email') }}</span>
                <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform duration-300"></i>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors duration-300 underline-offset-4 hover:underline flex items-center space-x-2 group py-3 px-4 border border-gray-300 rounded-xl hover:border-gray-400">
                <i class="fas fa-sign-out-alt group-hover:-translate-x-1 transition-transform duration-300"></i>
                <span>{{ __('Log Out') }}</span>
            </button>
        </form>
    </div>
</x-guest-layout>