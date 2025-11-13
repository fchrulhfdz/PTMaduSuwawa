<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Smart Cashier')</title>
    <!-- CSRF Token Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header - Sticky -->
        <header class="bg-gradient-to-r from-blue-600 to-purple-700 text-white shadow-lg sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold"><i class="fas fa-cash-register mr-3"></i>Smart Cashier</h1>
                        <p class="text-blue-100">@yield('subtitle', 'Dashboard Sistem Kasir Pintar')</p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="text-right">
                            <div class="text-sm opacity-90">{{ date('d F Y') }}</div>
                            <div id="live-clock" class="text-lg font-mono font-bold"></div>
                            <!-- Display user role -->
                            <div class="text-xs opacity-75 mt-1">
                                Role: {{ Auth::user()->role ?? 'Admin' }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('custom.logout') }}" class="inline" id="logout-form">
    @csrf
    <button type="submit" 
            class="flex items-center justify-center w-10 h-10 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors shadow-lg hover:shadow-xl"
            title="Logout">
        <i class="fas fa-sign-out-alt"></i>
    </button>
</form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation - Sticky -->
        <nav class="bg-white shadow-sm border-b sticky top-[72px] z-40">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap gap-3 py-3">
            <!-- Dashboard - Super Admin & Admin -->
            @if(Auth::user()->role === 'super admin' || Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center space-x-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            @endif

            <!-- Kasir - Super Admin & Admin -->
            @if(Auth::user()->role === 'super admin' || Auth::user()->role === 'admin')
            <a href="{{ route('admin.transactions.create') }}" 
               class="flex items-center space-x-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Kasir</span>
            </a>
            @endif

            <!-- Daftar Transaksi - Super Admin & Admin -->
            @if(Auth::user()->role === 'super admin' || Auth::user()->role === 'admin')
            <a href="{{ route('admin.transactions.index') }}" 
               class="flex items-center space-x-2 px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                <i class="fas fa-list"></i>
                <span>Daftar Transaksi</span>
            </a>
            @endif

            <!-- Produk - Super Admin Only -->
            @if(Auth::user()->role === 'super admin')
            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center space-x-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                <i class="fas fa-box"></i>
                <span>Produk</span>
            </a>
            @endif

            <!-- Testimonials - Super Admin Only -->
            @if(Auth::user()->role === 'super admin')
            <a href="{{ route('admin.testimonials.index') }}" 
               class="flex items-center space-x-2 px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors">
                <i class="fas fa-comment-alt"></i>
                <span>Testimonials</span>
            </a>
            @endif

            <!-- Contact/Keluhan - Super Admin Only -->
            @if(Auth::user()->role === 'super admin')
            <a href="{{ route('admin.contacts.index') }}" 
               class="flex items-center space-x-2 px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-colors">
                <i class="fas fa-inbox"></i>
                <span>Keluhan & Masukan</span>
            </a>
            @endif
            
            <!-- Laporan - Super Admin & Admin -->
            @if(Auth::user()->role === 'super admin' || Auth::user()->role === 'admin')
            <a href="{{ route('admin.reports.index') }}" 
               class="flex items-center space-x-2 px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
            @endif

            <!-- Hitung Laba - Super Admin & Admin -->
@if(Auth::user()->role === 'super admin' || Auth::user()->role === 'admin')
<a href="{{ route('admin.profit.index') }}" 
   class="flex items-center space-x-2 px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors">
    <i class="fas fa-calculator"></i>
    <span>Hitung Laba</span>
</a>
@endif

            <!-- Pengaturan - Super Admin Only -->
            @if(Auth::user()->role === 'super admin')
            <a href="{{ route('admin.settings.index') }}" 
               class="flex items-center space-x-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            @endif
        </div>
    </div>
</nav>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            @yield('content')
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Live Clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            const liveClock = document.getElementById('live-clock');
            if (liveClock) {
                liveClock.textContent = timeString;
            }
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Start live clock
            setInterval(updateClock, 1000);
            updateClock();

            // Setup CSRF token for AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const token = csrfToken.getAttribute('content');
                
                // Override fetch to include CSRF token
                const originalFetch = window.fetch;
                window.fetch = function(url, options = {}) {
                    // Add CSRF token to all non-GET requests
                    if (options.method && options.method.toUpperCase() !== 'GET') {
                        options.headers = {
                            ...options.headers,
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        };
                    }
                    return originalFetch(url, options);
                };
            }

            // Confirm logout dan redirect ke login
            const logoutForm = document.getElementById('logout-form');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin logout?')) {
                        // Submit form logout
                        this.submit();
                        
                        // Redirect ke halaman login setelah logout
                        setTimeout(function() {
                            window.location.href = "{{ route('login') }}";
                        }, 1000);
                    }
                });
            }

            // Add active state to current page navigation
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('nav a');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('ring-2', 'ring-white', 'ring-opacity-50');
                }
            });
        });

        // Notification function
        function showNotification(message, type = 'success') {
            const bgColor = type === 'success' ? 'bg-green-500' : 
                           type === 'error' ? 'bg-red-500' :
                           type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
            
            const icon = type === 'success' ? 'fa-check-circle' : 
                        type === 'error' ? 'fa-exclamation-circle' :
                        type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';
            
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-xl shadow-lg transform translate-x-full transition-transform duration-300 z-50`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas ${icon}"></i>
                    <span class="font-medium">${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Make functions globally available
        window.showNotification = showNotification;
    </script>

    @stack('scripts')
</body>
</html>