<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Testimonial - Smart Cashier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r from-blue-600 to-purple-700 text-white shadow-lg">
            <div class="container mx-auto px-4 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold"><i class="fas fa-cash-register mr-3"></i>Smart Cashier</h1>
                        <p class="text-blue-100">Tambah Testimonial Pelanggan</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm opacity-90">{{ date('d F Y') }}</div>
                        <div class="text-lg font-mono font-bold">{{ now()->format('H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b">
            <div class="container mx-auto px-4">
                <div class="flex space-x-8 py-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.transactions.create') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Transaksi Baru</span>
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                        <i class="fas fa-list"></i>
                        <span>Daftar Transaksi</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors">
                        <i class="fas fa-comment-alt"></i>
                        <span>Testimonials</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Tambah Testimonial</h1>
                    <p class="text-gray-600">Tambahkan testimonial pelanggan baru</p>
                </div>
                <a href="{{ route('admin.testimonials.index') }}" 
                   class="bg-gray-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-gray-600 transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('admin.testimonials.store') }}" method="POST" id="testimonialForm">
                        @csrf
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pelanggan *</label>
                                    <input type="text" name="customer_name" required 
                                           value="{{ old('customer_name') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                           placeholder="Masukkan nama pelanggan">
                                    @error('customer_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan/Profesi</label>
                                    <input type="text" name="customer_title" 
                                           value="{{ old('customer_title') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                           placeholder="Contoh: Ibu Rumah Tangga, Karyawan, dll.">
                                    @error('customer_title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Rating *</label>
                                <div class="flex justify-center space-x-2" id="ratingStars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" 
                                                class="text-3xl text-gray-300 hover:text-yellow-400 transition-all duration-200 transform hover:scale-110"
                                                data-rating="{{ $i }}"
                                                onclick="setRating({{ $i }})">
                                            <i class="far fa-star"></i>
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 5) }}" required>
                                <div class="text-center mt-2">
                                    <span id="ratingText" class="text-sm text-gray-600">Rating: {{ old('rating', 5) }}/5</span>
                                </div>
                                @error('rating')
                                    <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Testimonial *</label>
                                <textarea name="testimonial" rows="5" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                                          placeholder="Tulis testimonial pelanggan di sini...">{{ old('testimonial') }}</textarea>
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-500">Minimal 10 karakter</span>
                                    <span class="text-xs text-gray-500" id="charCount">0 karakter</span>
                                </div>
                                @error('testimonial')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex justify-center space-x-8">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" 
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="w-5 h-5 text-blue-500 border-gray-300 rounded focus:ring-blue-500 transition duration-200">
                                    <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">Aktif</label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_featured" id="is_featured"
                                           {{ old('is_featured') ? 'checked' : '' }}
                                           class="w-5 h-5 text-blue-500 border-gray-300 rounded focus:ring-blue-500 transition duration-200">
                                    <label for="is_featured" class="ml-3 text-sm font-medium text-gray-700">Featured</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-center space-x-4">
                            <a href="{{ route('admin.testimonials.index') }}"
                               class="px-8 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-all duration-200 font-medium">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" id="submitBtn"
                                    class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-400 text-white rounded-lg shadow-lg hover:shadow-blue-500/25 transition-all duration-200 font-medium transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>Simpan Testimonial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
    let currentRating = {{ old('rating', 5) }};

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize rating
        setRating(currentRating);
        
        // Character count for testimonial
        const textarea = document.querySelector('textarea[name="testimonial"]');
        const charCount = document.getElementById('charCount');
        
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length + ' karakter';
        });
        
        // Trigger initial character count
        textarea.dispatchEvent(new Event('input'));
        
        // Form validation
        const form = document.getElementById('testimonialForm');
        form.addEventListener('submit', function(e) {
            const customerName = document.querySelector('input[name="customer_name"]').value.trim();
            const testimonial = document.querySelector('textarea[name="testimonial"]').value.trim();
            
            // Validasi
            if (customerName === '') {
                e.preventDefault();
                showNotification('Nama pelanggan harus diisi!', 'error');
                document.querySelector('input[name="customer_name"]').focus();
                return false;
            }
            
            if (testimonial.length < 10) {
                e.preventDefault();
                showNotification('Testimonial harus minimal 10 karakter!', 'error');
                document.querySelector('textarea[name="testimonial"]').focus();
                return false;
            }
            
            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
        });

        // Hover effects untuk rating stars
        const ratingStars = document.querySelectorAll('#ratingStars button');
        ratingStars.forEach(button => {
            button.addEventListener('mouseenter', function() {
                const rating = this.getAttribute('data-rating');
                highlightStars(rating);
            });
            
            button.addEventListener('mouseleave', function() {
                highlightStars(currentRating);
            });
        });
    });

    function setRating(rating) {
        currentRating = rating;
        document.getElementById('ratingInput').value = rating;
        document.getElementById('ratingText').textContent = `Rating: ${rating}/5`;
        highlightStars(rating);
    }

    function highlightStars(rating) {
        const stars = document.querySelectorAll('#ratingStars button');
        stars.forEach((star, index) => {
            const icon = star.querySelector('i');
            const starRating = index + 1;
            
            if (starRating <= rating) {
                icon.classList.remove('far', 'fa-star');
                icon.classList.add('fas', 'fa-star', 'text-yellow-400');
                star.classList.add('text-yellow-400');
                star.classList.remove('text-gray-300');
            } else {
                icon.classList.remove('fas', 'fa-star', 'text-yellow-400');
                icon.classList.add('far', 'fa-star');
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    function showNotification(message, type = 'success') {
        const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
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
    </script>

    <style>
    .btn-loading {
        position: relative;
        color: transparent !important;
    }
    
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    </style>
</body>
</html>