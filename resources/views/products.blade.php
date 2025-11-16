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
            Produk Premium
        </div>
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold bg-gradient-to-r from-amber-600 via-yellow-600 to-orange-600 bg-clip-text text-transparent mb-6">
            Madu Suwawa
        </h1>
        <p class="text-xl md:text-2xl text-gray-700 max-w-3xl mx-auto leading-relaxed">
            Temukan keaslian dalam setiap tetes. Madu berkualitas premium langsung dari jantung alam Suwawa untuk kesehatan optimal Anda.
        </p>
    </div>
</section>

<!-- Products Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header Products -->
        <div class="text-center mb-16">
            <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                Koleksi Eksklusif
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Produk Madu Kami</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Pilih dari berbagai varian madu berkualitas tinggi yang kami tawarkan</p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8" id="products-container">
            @forelse($products as $product)
            <div class="product-card group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2 flex flex-col h-full">
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
                </div>

                <!-- Product Info -->
                <div class="p-8 flex-1 flex flex-col">
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h3>
                    </div>
                    
                    <p class="text-gray-600 mb-6 leading-relaxed line-clamp-2 flex-1">{{ $product->description }}</p>
                    
                    <!-- Price and Stock - Sticky di bagian bawah -->
                    <div class="mt-auto space-y-6">
                        <!-- Price and Stock -->
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-3xl font-bold text-amber-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                @if($product->berat_isi && $product->satuan_berat)
                                <div class="text-sm text-gray-500 mt-1">per {{ $product->berat_isi }} {{ $product->satuan_berat }}</div>
                                @else
                                <div class="text-sm text-gray-500 mt-1">per botol</div>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-gray-700">Stok</div>
                                <div class="text-lg font-bold text-gray-900">{{ $product->stock }}</div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div>
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Stok Tersedia</span>
                                <span>{{ min(100, ($product->stock / 50) * 100) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-amber-400 to-orange-500 h-2 rounded-full transition-all duration-1000" 
                                     style="width: {{ min(100, ($product->stock / 50) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State - Full width dan stick di bawah -->
            <div class="col-span-3 flex flex-col min-h-[400px]">
                <div class="flex-1 flex items-center justify-center">
                    <div class="max-w-md mx-auto text-center">
                        <div class="w-32 h-32 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-inbox text-5xl text-amber-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada produk tersedia</h3>
                        <p class="text-gray-600 mb-6">Produk berkualitas akan segera hadir untuk Anda</p>
                        <button class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-8 py-4 rounded-2xl font-bold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <i class="fas fa-bell mr-2"></i>Beritahu Saya
                        </button>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                Manfaat Premium
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Khasiat Madu Suwawa</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Setiap tetes madu Suwawa membawa khasiat alami untuk kesehatan dan kebugaran tubuh Anda</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Benefit 1 -->
            <div class="group relative bg-white rounded-3xl p-10 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100 to-transparent rounded-bl-full opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-amber-100 to-orange-100 p-4 rounded-2xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-heart text-3xl text-amber-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">Meningkatkan Imunitas</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Madu alami kaya antioksidan dan enzim yang membantu memperkuat sistem kekebalan tubuh, melindungi dari penyakit sehari-hari.
                    </p>
                </div>
            </div>
            
            <!-- Benefit 2 -->
            <div class="group relative bg-white rounded-3xl p-10 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-100 to-transparent rounded-bl-full opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-yellow-100 to-amber-100 p-4 rounded-2xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-brain text-3xl text-yellow-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">Energi Alami</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Sumber energi instan yang alami tanpa efek samping, memberikan vitalitas optimal untuk aktivitas harian yang padat.
                    </p>
                </div>
            </div>
            
            <!-- Benefit 3 -->
            <div class="group relative bg-white rounded-3xl p-10 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-100 to-transparent rounded-bl-full opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-orange-100 to-red-100 p-4 rounded-2xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-shield-alt text-3xl text-orange-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">Anti Bakteri</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Sifat antibakteri alami membantu melawan infeksi, menyembuhkan luka, dan menjaga kesehatan sistem pencernaan secara optimal.
                    </p>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-3xl p-12 text-white text-center">
            <div class="max-w-2xl mx-auto">
                <h3 class="text-3xl font-bold mb-6">100% Garansi Keaslian</h3>
                <p class="text-amber-100 text-lg mb-8 leading-relaxed">
                    Kami menjamin setiap botol madu Suwawa adalah produk asli tanpa campuran, diproses secara alami dengan standar kualitas tertinggi.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <div class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Tanpa Pengawet</span>
                    </div>
                    <div class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Tanpa Gula Tambahan</span>
                    </div>
                    <div class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Halal & Organik</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects for product cards
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-card {
        transition: all 0.3s ease;
    }
`;
document.head.appendChild(style);
</script>
@endsection