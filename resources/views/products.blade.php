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
        <!-- Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-4 mb-16">
            <button class="category-filter px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 active" data-category="all">
                <span class="flex items-center">
                    <i class="fas fa-boxes mr-3"></i>
                    Semua Produk
                </span>
            </button>
            
            <!-- Dynamic Category Buttons -->
            @php
                $categories = $products->pluck('category')->unique()->sort();
            @endphp
            
            @foreach($categories as $category)
                @php
                    $icons = [
                        'Madu Hutan' => 'tree',
                        'Madu Budidaya' => 'seedling', 
                        'Madu Organik' => 'leaf',
                        'Madu Spesial' => 'star',
                        'default' => 'tag'
                    ];
                    
                    $icon = $icons[$category] ?? $icons['default'];
                @endphp
                
                <button class="category-filter px-8 py-4 rounded-2xl bg-white text-gray-700 font-bold border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:border-amber-300 group" data-category="{{ $category }}">
                    <span class="flex items-center group-hover:text-amber-600">
                        <i class="fas fa-{{ $icon }} mr-3 text-green-500 group-hover:text-green-600"></i>
                        {{ $category }}
                    </span>
                </button>
            @endforeach
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8" id="products-container">
            @forelse($products as $product)
            <div class="product-card group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2" data-category="{{ $product->category }}">
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

                    <!-- Category Badge -->
                    <div class="absolute top-6 left-6">
                        <span class="bg-white/90 backdrop-blur-sm text-amber-600 px-4 py-2 rounded-full text-sm font-bold shadow-lg flex items-center border border-amber-200">
                            <i class="fas fa-tag mr-2"></i>
                            {{ $product->category }}
                        </span>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-8">
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
                    
                    <p class="text-gray-600 mb-6 leading-relaxed line-clamp-2">{{ $product->description }}</p>
                    
                    <!-- Price and Stock -->
                    <div class="flex items-center justify-between mb-6">
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

                    <!-- Progress Bar -->
                    <div class="mb-6">
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
            @empty
            <!-- Empty State -->
            <div class="col-span-3 text-center py-20">
                <div class="max-w-md mx-auto">
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
            @endforelse
        </div>

        <!-- Empty State for Filter -->
        <div id="no-products" class="hidden text-center py-20">
            <div class="max-w-md mx-auto">
                <div class="w-32 h-32 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-5xl text-amber-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Tidak ada produk dalam kategori ini</h3>
                <p class="text-gray-600 mb-6">Coba kategori lainnya untuk menemukan madu yang tepat</p>
                <button class="category-filter bg-gradient-to-r from-amber-500 to-orange-500 text-white px-8 py-4 rounded-2xl font-bold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1" data-category="all">
                    Lihat Semua Produk
                </button>
            </div>
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
    const filterButtons = document.querySelectorAll('.category-filter');
    const productCards = document.querySelectorAll('.product-card');
    const productsContainer = document.getElementById('products-container');
    const noProducts = document.getElementById('no-products');

    // Function to update active button
    function updateActiveButton(activeButton) {
        filterButtons.forEach(btn => {
            btn.classList.remove(
                'bg-gradient-to-r', 'from-amber-500', 'to-orange-500', 
                'text-white', 'shadow-lg', 'active'
            );
            btn.classList.add(
                'bg-white', 'text-gray-700', 'border-2', 
                'border-gray-200', 'shadow-lg'
            );
        });
        
        activeButton.classList.remove(
            'bg-white', 'text-gray-700', 'border-2', 
            'border-gray-200', 'shadow-lg'
        );
        activeButton.classList.add(
            'bg-gradient-to-r', 'from-amber-500', 'to-orange-500', 
            'text-white', 'shadow-lg', 'active'
        );
    }

    // Function to filter products
    function filterProducts(category) {
        let visibleProducts = 0;

        productCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            
            if (category === 'all' || cardCategory === category) {
                card.style.display = 'block';
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                // Animate in
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
                
                visibleProducts++;
            } else {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });

        // Show/hide no products message
        if (visibleProducts === 0) {
            productsContainer.style.display = 'none';
            noProducts.classList.remove('hidden');
            noProducts.style.opacity = '0';
            noProducts.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                noProducts.style.transition = 'all 0.5s ease';
                noProducts.style.opacity = '1';
                noProducts.style.transform = 'translateY(0)';
            }, 50);
        } else {
            noProducts.classList.add('hidden');
            productsContainer.style.display = 'grid';
        }
    }

    // Add click event listeners to filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Update active button
            updateActiveButton(this);
            
            // Filter products
            filterProducts(category);
        });
    });

    // Add hover effects for product cards
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Initialize with all products showing
    filterProducts('all');
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-card {
        transition: all 0.3s ease;
    }
    
    .category-filter {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .category-filter.active {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
`;
document.head.appendChild(style);
</script>
@endsection