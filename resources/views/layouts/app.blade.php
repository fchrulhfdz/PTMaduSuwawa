<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madu Suwawa - Madu Asli Berkualitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body class="font-sans bg-gray-50">
    <!-- Enhanced Navigation with Prominent Buttons -->
    <nav class="bg-white/95 backdrop-blur-sm shadow-2xl sticky top-0 z-50 border-b border-amber-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo dengan Gambar -->
                <div class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 overflow-hidden">
                            <img src="{{ asset('storage/logo/logo madu suwawa.jpg') }}" 
                                 alt="Madu Suwawa Logo" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -inset-1 bg-gradient-to-r from-amber-400 to-orange-400 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">Madu Suwawa</span>
                </div>
                
                <!-- Enhanced Desktop Menu with Prominent Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="group relative px-6 py-3 text-gray-700 hover:text-amber-600 transition-all duration-300 font-semibold">
                        <span class="relative z-10 flex items-center space-x-2">
                            <i class="fas fa-home text-amber-500 text-sm"></i>
                            <span>Home</span>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl scale-95 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-300"></div>
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full group-hover:w-3/4 transition-all duration-300"></div>
                    </a>
                    
                    <a href="{{ route('products') }}" class="group relative px-6 py-3 text-gray-700 hover:text-amber-600 transition-all duration-300 font-semibold">
                        <span class="relative z-10 flex items-center space-x-2">
                            <i class="fas fa-shopping-bag text-amber-500 text-sm"></i>
                            <span>Produk</span>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl scale-95 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-300"></div>
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full group-hover:w-3/4 transition-all duration-300"></div>
                    </a>

                    <!-- Testimoni Menu -->
                    <a href="{{ route('testimoni') }}" class="group relative px-6 py-3 text-gray-700 hover:text-amber-600 transition-all duration-300 font-semibold">
                        <span class="relative z-10 flex items-center space-x-2">
                            <i class="fas fa-comment text-amber-500 text-sm"></i>
                            <span>Testimoni</span>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl scale-95 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-300"></div>
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full group-hover:w-3/4 transition-all duration-300"></div>
                    </a>
                    
                    <a href="{{ route('about') }}" class="group relative px-6 py-3 text-gray-700 hover:text-amber-600 transition-all duration-300 font-semibold">
                        <span class="relative z-10 flex items-center space-x-2">
                            <i class="fas fa-info-circle text-amber-500 text-sm"></i>
                            <span>Tentang Kami</span>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl scale-95 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-300"></div>
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full group-hover:w-3/4 transition-all duration-300"></div>
                    </a>
                    
                    <a href="{{ route('contact') }}" class="group relative px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 font-semibold hover:scale-105 transform">
                        <span class="relative z-10 flex items-center space-x-2">
                            <i class="fas fa-phone text-white text-sm"></i>
                            <span>Hubungi Kami</span>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>

                <!-- Enhanced Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="group w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 text-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 flex items-center justify-center relative overflow-hidden">
                        <i class="fas fa-bars text-lg relative z-10"></i>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-600 to-orange-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Enhanced Mobile Menu - SUDAH DIPERBAIKI -->
    <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-sm shadow-2xl border-b border-amber-100">
        <div class="px-6 py-6 space-y-4">
            <a href="{{ route('home') }}" class="group flex items-center space-x-4 px-5 py-4 text-gray-700 hover:text-amber-600 hover:bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl transition-all duration-300 border border-transparent hover:border-amber-200">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                    <i class="fas fa-home text-amber-600"></i>
                </div>
                <div class="flex-1">
                    <span class="font-semibold text-lg">Home</span>
                    <p class="text-gray-500 text-sm mt-1">Halaman utama</p>
                </div>
                <i class="fas fa-chevron-right text-amber-400 text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
            
            <a href="{{ route('products') }}" class="group flex items-center space-x-4 px-5 py-4 text-gray-700 hover:text-amber-600 hover:bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl transition-all duration-300 border border-transparent hover:border-amber-200">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                    <i class="fas fa-shopping-bag text-amber-600"></i>
                </div>
                <div class="flex-1">
                    <span class="font-semibold text-lg">Produk</span>
                    <p class="text-gray-500 text-sm mt-1">Lihat koleksi madu</p>
                </div>
                <i class="fas fa-chevron-right text-amber-400 text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>

            <!-- Testimoni Menu - YANG DITAMBAHKAN -->
            <a href="{{ route('testimoni') }}" class="group flex items-center space-x-4 px-5 py-4 text-gray-700 hover:text-amber-600 hover:bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl transition-all duration-300 border border-transparent hover:border-amber-200">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                    <i class="fas fa-comment text-amber-600"></i>
                </div>
                <div class="flex-1">
                    <span class="font-semibold text-lg">Testimoni</span>
                    <p class="text-gray-500 text-sm mt-1">Ulasan pelanggan</p>
                </div>
                <i class="fas fa-chevron-right text-amber-400 text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
            
            <a href="{{ route('about') }}" class="group flex items-center space-x-4 px-5 py-4 text-gray-700 hover:text-amber-600 hover:bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl transition-all duration-300 border border-transparent hover:border-amber-200">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                    <i class="fas fa-info-circle text-amber-600"></i>
                </div>
                <div class="flex-1">
                    <span class="font-semibold text-lg">Tentang Kami</span>
                    <p class="text-gray-500 text-sm mt-1">Cerita kami</p>
                </div>
                <i class="fas fa-chevron-right text-amber-400 text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
            
            <a href="{{ route('contact') }}" class="group flex items-center space-x-4 px-5 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-phone text-white"></i>
                </div>
                <div class="flex-1">
                    <span class="font-semibold text-lg">Hubungi Kami</span>
                    <p class="text-amber-100 text-sm mt-1">Butuh bantuan?</p>
                </div>
                <i class="fas fa-arrow-right text-white text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Enhanced Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-amber-900 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wMiI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-20"></div>
        
        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 py-16 z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Brand Section -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300 overflow-hidden">
                            <img src="{{ asset('storage/logo/logo madu suwawa.jpg') }}" 
                                 alt="Madu Suwawa Logo" 
                                 class="w-full h-full object-cover">
                        </div>
                        <span class="text-2xl font-bold text-white">Madu Suwawa</span>
                    </div>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        Madu asli berkualitas dari alam Suwawa yang kaya akan manfaat untuk kesehatan Anda. Setiap tetes menjaga kemurnian alami.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-gray-300 hover:text-amber-400 hover:bg-white/20 transition-all duration-300 hover:scale-110">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-gray-300 hover:text-amber-400 hover:bg-white/20 transition-all duration-300 hover:scale-110">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-gray-300 hover:text-amber-400 hover:bg-white/20 transition-all duration-300 hover:scale-110">
                            <i class="fab fa-whatsapp text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-gray-300 hover:text-amber-400 hover:bg-white/20 transition-all duration-300 hover:scale-110">
                            <i class="fab fa-tiktok text-lg"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-white mb-6">Tautan Cepat</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('home') }}" class="group flex items-center space-x-2 text-gray-300 hover:text-amber-400 transition-all duration-300">
                            <i class="fas fa-chevron-right text-xs text-amber-500 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span>Home</span>
                        </a>
                        <a href="{{ route('products') }}" class="group flex items-center space-x-2 text-gray-300 hover:text-amber-400 transition-all duration-300">
                            <i class="fas fa-chevron-right text-xs text-amber-500 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span>Produk</span>
                        </a>
                        <a href="{{ route('about') }}" class="group flex items-center space-x-2 text-gray-300 hover:text-amber-400 transition-all duration-300">
                            <i class="fas fa-chevron-right text-xs text-amber-500 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span>Tentang Kami</span>
                        </a>
                        <a href="{{ route('testimoni') }}" class="group flex items-center space-x-2 text-gray-300 hover:text-amber-400 transition-all duration-300">
                            <i class="fas fa-chevron-right text-xs text-amber-500 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span>Testimoni</span>
                        </a>
                        <a href="{{ route('contact') }}" class="group flex items-center space-x-2 text-gray-300 hover:text-amber-400 transition-all duration-300">
                            <i class="fas fa-chevron-right text-xs text-amber-500 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span>Kontak</span>
                        </a>
                    </div>
                    
                    <!-- Trust Badges -->
                    <div class="pt-6 border-t border-gray-700">
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center space-x-2 text-amber-400">
                                <i class="fas fa-check-circle text-sm"></i>
                                <span class="text-xs font-medium">100% Asli</span>
                            </div>
                            <div class="flex items-center space-x-2 text-amber-400">
                                <i class="fas fa-check-circle text-sm"></i>
                                <span class="text-xs font-medium">Halal</span>
                            </div>
                            <div class="flex items-center space-x-2 text-amber-400">
                                <i class="fas fa-check-circle text-sm"></i>
                                <span class="text-xs font-medium">Organik</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Section -->
            <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-gray-400 text-sm">
                    &copy; 2024 Madu Suwawa. All rights reserved.
                </p>
                <div class="flex items-center space-x-6 text-sm text-gray-400">
                    <a href="#" class="hover:text-amber-400 transition-colors duration-300">Privacy Policy</a>
                    <a href="#" class="hover:text-amber-400 transition-colors duration-300">Terms of Service</a>
                    <a href="#" class="hover:text-amber-400 transition-colors duration-300">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    
    <!-- jQuery untuk Mobile Menu -->
    <script>
        $(document).ready(function() {
            // Enhanced Mobile menu toggle dengan jQuery
            $('#mobile-menu-button').click(function(e) {
                e.stopPropagation();
                $('#mobile-menu').slideToggle(300);
                
                // Toggle button icon
                const icon = $(this).find('i');
                if ($('#mobile-menu').is(':visible')) {
                    icon.removeClass('fa-bars').addClass('fa-times');
                } else {
                    icon.removeClass('fa-times').addClass('fa-bars');
                }
            });

            // Close mobile menu when clicking on a link
            $('#mobile-menu a').click(function() {
                $('#mobile-menu').slideUp(300);
                $('#mobile-menu-button i').removeClass('fa-times').addClass('fa-bars');
            });

            // Close mobile menu when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('#mobile-menu, #mobile-menu-button').length) {
                    if ($('#mobile-menu').is(':visible')) {
                        $('#mobile-menu').slideUp(300);
                        $('#mobile-menu-button i').removeClass('fa-times').addClass('fa-bars');
                    }
                }
            });

            // Prevent menu from closing when clicking inside menu
            $('#mobile-menu').click(function(e) {
                e.stopPropagation();
            });

            // Add scroll effect to navbar dengan jQuery
            $(window).scroll(function() {
                const nav = $('nav');
                if ($(window).scrollTop() > 50) {
                    nav.addClass('shadow-2xl bg-white/98');
                } else {
                    nav.removeClass('shadow-2xl bg-white/98');
                }
            });
        });
    </script>
</body>
</html>