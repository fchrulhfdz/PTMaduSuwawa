@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmYmJmMjQiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDE2YzAtMi4yMSAxLjc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0wIDI4YzAtMi4yMSAxLjc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0tMjAgMGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLjc5LTQtNHptMC0yOGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLjc5LTQtNHoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-amber-200/30 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-yellow-200/30 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 text-center z-10">
        <div class="inline-block mb-6 px-6 py-3 bg-white/80 backdrop-blur-sm rounded-full text-amber-700 font-semibold text-sm shadow-lg">
            Madu Premium Asli Suwawa
        </div>
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold bg-gradient-to-r from-amber-600 via-yellow-600 to-orange-600 bg-clip-text text-transparent mb-6">
            Madu Suwawa
        </h1>
        <p class="text-xl md:text-2xl text-gray-700 max-w-3xl mx-auto leading-relaxed">
            Keaslian dalam setiap tetes, kualitas premium dari jantung alam Suwawa untuk 
            <span class="font-semibold text-amber-600">kesehatan optimal keluarga Anda.</span>
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mt-12">
            <a href="{{ route('products') }}" 
               class="group bg-gradient-to-r from-amber-500 to-orange-500 text-white px-12 py-5 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-1 transform flex items-center gap-3">
                <span>Jelajahi Produk</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
            <a href="{{ route('about') }}" 
               class="group bg-white/80 backdrop-blur-sm text-gray-700 border-2 border-amber-200 px-12 py-5 rounded-2xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-1 transform flex items-center gap-3 hover:border-amber-300">
                <i class="fas fa-play-circle text-amber-500"></i>
                <span>Tentang Kami</span>
            </a>
        </div>

        <!-- Trust Indicators -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
            <div class="text-center group">
                <div class="bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-2">1+</div>
                    <div class="text-gray-600 font-medium text-sm">Tahun Pengalaman</div>
                </div>
            </div>
            <div class="text-center group">
                <div class="bg-gradient-to-br from-yellow-100 to-amber-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-yellow-600 to-amber-600 bg-clip-text text-transparent mb-2">500+</div>
                    <div class="text-gray-600 font-medium text-sm">Petani Mitra</div>
                </div>
            </div>
            <div class="text-center group">
                <div class="bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">50K+</div>
                    <div class="text-gray-600 font-medium text-sm">Pelanggan</div>
                </div>
            </div>
            <div class="text-center group">
                <div class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">100%</div>
                    <div class="text-gray-600 font-medium text-sm">Garansi Asli</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                Produk Unggulan
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Pilihan Terbaik</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Pilihan terbaik madu Suwawa dengan kualitas premium yang sudah teruji</p>
        </div>
        
        <!-- Products Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
    @foreach($products->take(3) as $product)
    <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2 flex flex-col h-full">
        <!-- Product Image -->
        <div class="relative h-80 bg-gradient-to-br from-amber-50 to-orange-100 overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-honey-pot text-8xl text-amber-400 mb-4"></i>
                        <p class="text-amber-600 font-bold text-lg">Madu Suwawa</p>
                    </div>
                </div>
            @endif
            
            <!-- Stock Badge -->
            <div class="absolute top-6 right-6">
                @if($product->stock > 0)
                    <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Tersedia
                    </span>
                @else
                    <span class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        Habis
                    </span>
                @endif
            </div>

            <!-- Hover Action -->
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0">
            </div>
        </div>

        <!-- Product Info -->
        <div class="p-8 flex-1 flex flex-col">
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h3>
                <div class="flex items-center text-amber-400 text-sm">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
            
            <p class="text-gray-600 mb-6 leading-relaxed line-clamp-2 flex-1">{{ $product->description }}</p>
            
            <!-- Price and Stock - Sticky di bagian bawah -->
            <div class="mt-auto pt-6 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-3xl font-bold text-amber-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <div class="text-sm text-gray-500 mt-1">per 500ml</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-semibold text-gray-700">Stok</div>
                        <div class="text-lg font-bold text-gray-900">{{ $product->stock }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
        
        <!-- View All Button -->
        <div class="text-center">
            <a href="{{ route('products') }}" 
               class="group bg-white border-2 border-amber-200 text-amber-600 px-12 py-5 rounded-2xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-1 transform inline-flex items-center gap-3 hover:border-amber-300">
                <span>Lihat Semua Produk</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                Keunggulan Kami
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Mengapa Memilih Madu Suwawa?</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Keunggulan yang membuat madu Suwawa menjadi pilihan terbaik untuk kesehatan Anda</p>
        </div>
        
        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group relative bg-white rounded-3xl p-10 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100 to-transparent rounded-bl-full opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-amber-100 to-orange-100 p-4 rounded-2xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-leaf text-3xl text-amber-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">100% Alami & Murni</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Diproses secara tradisional tanpa campuran bahan kimia, gula, atau pengawet. 
                        Setiap tetes menjaga kemurnian alami dari alam Suwawa.
                    </p>
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="group relative bg-white rounded-3xl p-10 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-100 to-transparent rounded-bl-full opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-yellow-100 to-amber-100 p-4 rounded-2xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-award text-3xl text-yellow-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">Kualitas Premium</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Standar kualitas tertinggi dengan proses seleksi ketat. 
                        Setiap batch melalui uji laboratorium untuk memastikan khasiat optimal.
                    </p>
                </div>
            </div>
            
            <!-- Feature 3 -->
            <div class="group relative bg-white rounded-3xl p-10 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-100 to-transparent rounded-bl-full opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-orange-100 to-red-100 p-4 rounded-2xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-shipping-fast text-3xl text-orange-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">Pengiriman Ekspres</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Pesanan diproses maksimal 24 jam dan dikirim dengan packaging khusus 
                        untuk menjaga kualitas madu selama perjalanan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <i class="fas fa-certificate text-3xl text-amber-600 mb-3"></i>
                <div class="font-bold text-gray-900">Sertifikasi Halal</div>
            </div>
            <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <i class="fas fa-heart text-3xl text-amber-600 mb-3"></i>
                <div class="font-bold text-gray-900">Ramah Lingkungan</div>
            </div>
            <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <i class="fas fa-users text-3xl text-amber-600 mb-3"></i>
                <div class="font-bold text-gray-900">Dukung Petani</div>
            </div>
            <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <i class="fas fa-shield-alt text-3xl text-amber-600 mb-3"></i>
                <div class="font-bold text-gray-900">Garansi Asli</div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Section -->
<section class="relative py-20 bg-gradient-to-r from-amber-500 to-orange-500 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
    
    <!-- Decorative blobs -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 text-center z-10">
        <div class="inline-block mb-6 px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full text-white font-semibold text-sm">
            Mari Berkolaborasi
        </div>
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Siap Merasakan Khasiat Madu Asli?</h2>
        <p class="text-amber-50 text-xl mb-10 leading-relaxed max-w-2xl mx-auto">
            Bergabung dengan ribuan pelanggan yang telah merasakan manfaat madu Suwawa untuk kesehatan keluarga mereka.
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('products') }}" 
               class="group bg-white text-amber-600 px-12 py-5 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-1 transform flex items-center justify-center gap-3">
                <i class="fas fa-shopping-bag"></i>
                Beli Sekarang
            </a>
            <a href="{{ route('contact') }}" 
               class="group border-2 border-white text-white px-12 py-5 rounded-2xl font-bold text-lg hover:bg-white hover:text-amber-600 transition-all duration-500 hover:-translate-y-1 transform flex items-center justify-center gap-3">
                <i class="fas fa-comments"></i>
                Konsultasi Gratis
            </a>
        </div>
    </div>
</section>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection