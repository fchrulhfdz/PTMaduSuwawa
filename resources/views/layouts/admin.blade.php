<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Madu Suwawa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body 
    class="bg-gradient-to-br from-gray-50 to-gray-100" 
    x-data="{ sidebarOpen: false }"
>
    <!-- Sidebar -->
<div 
class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white 
       transform transition-all duration-300 ease-in-out z-50 shadow-2xl
       lg:translate-x-0 lg:transition-none"
:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
    <div class="p-6 border-b border-gray-700">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-amber-500 rounded-xl shadow-lg">
                <i class="fas fa-honeycomb text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-amber-400 to-amber-300 bg-clip-text text-transparent">
                    Madu Suwawa
                </h1>
                <p class="text-gray-400 text-xs font-medium">Admin Panel</p>
            </div>
        </div>
    </div>
    
    <nav class="mt-6 px-3 space-y-1">
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg shadow-amber-500/25' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white hover:translate-x-1' }}">
            <i class="fas fa-chart-bar w-6 text-center mr-3"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.products.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg shadow-amber-500/25' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white hover:translate-x-1' }}">
            <i class="fas fa-box w-6 text-center mr-3"></i>
            <span class="font-medium">Produk</span>
        </a>
        
        <a href="{{ route('admin.transactions.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg shadow-amber-500/25' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white hover:translate-x-1' }}">
            <i class="fas fa-shopping-cart w-6 text-center mr-3"></i>
            <span class="font-medium">Transaksi</span>
        </a>
        
        <!-- Menu Testimonial Baru -->
        <a href="{{ route('admin.testimonials.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.testimonials.*') ? 'bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg shadow-amber-500/25' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white hover:translate-x-1' }}">
            <i class="fas fa-comment-alt w-6 text-center mr-3"></i>
            <span class="font-medium">Testimonial</span>
        </a>
        
        <a href="{{ route('admin.reports.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg shadow-amber-500/25' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white hover:translate-x-1' }}">
            <i class="fas fa-chart-line w-6 text-center mr-3"></i>
            <span class="font-medium">Laporan</span>
        </a>
        
        <a href="{{ route('admin.settings.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg shadow-amber-500/25' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white hover:translate-x-1' }}">
            <i class="fas fa-cog w-6 text-center mr-3"></i>
            <span class="font-medium">Pengaturan</span>
        </a>
    </nav>
</div>

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-lg border-b border-gray-200/60 shadow-sm sticky top-0 z-40">
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Mobile Toggle Button -->
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="lg:hidden p-2 rounded-xl bg-white shadow-lg border border-gray-200 text-gray-600 hover:text-amber-600 hover:shadow-xl transition-all duration-200">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                
                <!-- Page Title -->
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-xl font-bold text-gray-800">
                        @hasSection('page-title')
                            @yield('page-title')
                        @else
                            Madu Suwawa - Gorontalo 
                        @endif
                    </h1>
                </div>
                
                <!-- User Menu - Dipindahkan ke kanan -->
                <div class="flex items-center space-x-4">
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 p-2 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="w-8 h-8 bg-gradient-to-r from-amber-500 to-amber-400 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-white text-sm font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="hidden md:block text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-200 py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white/60 backdrop-blur-lg border-t border-gray-200/60 py-4 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 text-sm">
                    &copy; {{ date('Y') }} Madu Suwawa. All rights reserved.
                </p>
                <div class="flex space-x-4 mt-2 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-amber-600 transition-colors duration-200">
                        <i class="fab fa-facebook text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-amber-600 transition-colors duration-200">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-amber-600 transition-colors duration-200">
                        <i class="fab fa-whatsapp text-lg"></i>
                    </a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 lg:hidden"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>