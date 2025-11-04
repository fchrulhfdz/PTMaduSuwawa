@extends('layouts.admin')

@section('title', 'Tambah Testimonial - Madu Suwawa')

@section('content')
<div class="flex justify-center p-8">
    <div class="w-full max-w-4xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Tambah Testimonial</h1>
                <p class="text-gray-600">Tambahkan testimonial pelanggan baru</p>
            </div>
            <a href="{{ route('admin.testimonials.index') }}" 
               class="bg-gray-500 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-gray-600 transition-all duration-200 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('admin.testimonials.store') }}" method="POST" id="testimonialForm">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pelanggan *</label>
                                <input type="text" name="customer_name" required 
                                       value="{{ old('customer_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200"
                                       placeholder="Masukkan nama pelanggan">
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan/Profesi</label>
                                <input type="text" name="customer_title" 
                                       value="{{ old('customer_title') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200"
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
                                            class="text-3xl text-gray-300 hover:text-amber-400 transition-all duration-200 transform hover:scale-110"
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
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 resize-none"
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
                                       class="w-5 h-5 text-amber-500 border-gray-300 rounded focus:ring-amber-500 transition duration-200">
                                <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">Aktif</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured"
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="w-5 h-5 text-amber-500 border-gray-300 rounded focus:ring-amber-500 transition duration-200">
                                <label for="is_featured" class="ml-3 text-sm font-medium text-gray-700">Featured</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-center space-x-4">
                        <a href="{{ route('admin.testimonials.index') }}"
                           class="px-8 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition-all duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" id="submitBtn"
                                class="px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-400 text-white rounded-xl shadow-lg hover:shadow-amber-500/25 transition-all duration-200 font-medium transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>Simpan Testimonial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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
@endpush

@push('scripts')
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
            icon.classList.add('fas', 'fa-star', 'text-amber-400');
            star.classList.add('text-amber-400');
            star.classList.remove('text-gray-300');
        } else {
            icon.classList.remove('fas', 'fa-star', 'text-amber-400');
            icon.classList.add('far', 'fa-star');
            star.classList.remove('text-amber-400');
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
@endpush