@extends('layouts.admin')

@section('title', 'Transaksi Kasir')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Daftar Produk -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Daftar Produk</h2>
                    <p class="text-gray-600 mt-1">Pilih produk untuk ditambahkan ke keranjang</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-honey-100 to-honey-50 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-cube text-honey-600 text-lg"></i>
                </div>
            </div>
            
            <!-- Search Products -->
            <div class="mb-6">
                <div class="relative">
                    <input 
                        type="text" 
                        id="searchProduct"
                        placeholder="Cari produk berdasarkan nama atau kategori..."
                        class="w-full px-4 py-3 pl-12 bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-honey-500 focus:bg-white transition-all duration-200 shadow-sm"
                    >
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <div id="searchClear" class="absolute right-3 top-1/2 transform -translate-y-1/2 hidden">
                        <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Search Results Info -->
                <div id="searchInfo" class="mt-2 hidden">
                    <div class="flex items-center justify-between text-sm">
                        <span id="resultCount" class="text-gray-600"></span>
                        <button id="clearSearch" class="text-honey-600 hover:text-honey-700 font-medium flex items-center space-x-1">
                            <i class="fas fa-times"></i>
                            <span>Hapus pencarian</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[500px] overflow-y-auto pr-2" id="productList">
                @foreach($products as $product)
                <div class="product-item border border-gray-200 rounded-2xl p-5 hover:shadow-lg transition-all duration-300 hover:border-honey-200 group" 
                     data-name="{{ strtolower($product->name) }}" 
                     data-category="{{ strtolower($product->category) }}"
                     data-price="{{ $product->price }}"
                     data-stock="{{ $product->stock }}">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-semibold text-gray-900 text-lg group-hover:text-honey-700 transition-colors">{{ $product->name }}</h3>
                        <span class="text-sm bg-gradient-to-r from-honey-100 to-amber-100 text-honey-700 px-3 py-1 rounded-full font-medium">
                            {{ $product->category }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-xl font-bold text-honey-600 bg-honey-50 px-3 py-2 rounded-xl">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        <div class="text-sm font-medium {{ $product->stock <= 10 ? 'text-red-600 bg-red-50 px-3 py-1 rounded-lg' : 'text-green-600 bg-green-50 px-3 py-1 rounded-lg' }}">
                            Stok: {{ $product->stock }}
                        </div>
                    </div>

                    <button 
                        onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})"
                        class="w-full bg-gradient-to-r from-honey-500 to-honey-600 text-white py-3 px-4 rounded-xl hover:from-honey-600 hover:to-honey-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold flex items-center justify-center group/btn {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $product->stock == 0 ? 'disabled' : '' }}
                    >
                        <i class="fas fa-plus mr-2 group-hover/btn:scale-110 transition-transform"></i>
                        Tambah ke Keranjang
                    </button>
                </div>
                @endforeach
            </div>

            <!-- No Results State -->
            <div id="noResults" class="hidden text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Produk tidak ditemukan</h3>
                <p class="text-gray-500 text-sm">Coba gunakan kata kunci lain atau lihat semua produk</p>
                <button id="showAllProducts" class="mt-4 bg-honey-500 text-white px-6 py-2 rounded-xl hover:bg-honey-600 transition-colors font-medium">
                    Tampilkan Semua Produk
                </button>
            </div>
        </div>
    </div>

    <!-- Keranjang Belanja -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sticky top-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Keranjang Belanja</h2>
                    <p class="text-gray-600 mt-1">Ringkasan transaksi Anda</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-shopping-cart text-green-600 text-lg"></i>
                </div>
            </div>
            
            <form id="transactionForm" action="{{ route('admin.transactions.store') }}" method="POST">
                @csrf
                
                <!-- Cart Items -->
                <div class="space-y-3 mb-6 max-h-64 overflow-y-auto pr-2" id="cartItems">
                    <!-- Empty State -->
                    <div id="emptyCart" class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shopping-cart text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm">Keranjang masih kosong</p>
                    </div>
                </div>

                <!-- Transaction Summary -->
                <div class="border-t border-gray-200 pt-6 space-y-4">
                    <!-- Total -->
                    <div class="flex justify-between items-center text-lg font-bold">
                        <span class="text-gray-700">Total:</span>
                        <span id="totalAmount" class="text-2xl text-honey-600 bg-honey-50 px-4 py-2 rounded-xl">Rp 0</span>
                    </div>

                    <!-- Payment Input -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pembayaran</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-bold">Rp</span>
                            <input 
                                type="number" 
                                id="payment"
                                name="payment"
                                class="w-full px-4 py-3 pl-12 bg-gray-50 border-0 rounded-xl focus:ring-2 focus:ring-green-500 focus:bg-white transition-all duration-200 shadow-sm text-lg font-semibold"
                                min="0"
                                placeholder="0"
                                required
                            >
                        </div>
                    </div>

                    <!-- Change -->
                    <div class="flex justify-between items-center text-lg font-bold">
                        <span class="text-gray-700">Kembalian:</span>
                        <span id="changeAmount" class="text-xl bg-gradient-to-r from-green-50 to-green-100 text-green-700 px-4 py-2 rounded-xl">Rp 0</span>
                    </div>

                    <!-- Process Button -->
                    <button 
                        type="submit" 
                        id="processBtn"
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-6 rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center group/process"
                        disabled
                    >
                        <i class="fas fa-credit-card mr-3 group-hover/process:scale-110 transition-transform"></i>
                        Proses Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let cart = [];
    let total = 0;
    let allProducts = [];

    document.addEventListener('DOMContentLoaded', function() {
        const productItems = document.querySelectorAll('.product-item');
        allProducts = Array.from(productItems).map(item => ({
            element: item,
            name: item.getAttribute('data-name'),
            category: item.getAttribute('data-category'),
            price: parseFloat(item.getAttribute('data-price')),
            stock: parseInt(item.getAttribute('data-stock'))
        }));
        
        updateCartDisplay();
        setupSearch(); // aktifkan fungsi pencarian
    });

    // 🔍 Setup fungsi search
    function setupSearch() {
        const searchInput = document.getElementById('searchProduct');
        const searchClear = document.getElementById('searchClear');
        const searchInfo = document.getElementById('searchInfo');
        const clearSearchBtn = document.getElementById('clearSearch');
        const showAllBtn = document.getElementById('showAllProducts');
        const noResults = document.getElementById('noResults');

        if (!searchInput) return; // antisipasi jika elemen tidak ada

        // Event ketika user mengetik
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();

            if (searchTerm === '') {
                // Jika input kosong, tampilkan semua produk
                showAllProducts();
                searchClear.classList.add('hidden');
                searchInfo.classList.add('hidden');
                noResults.classList.add('hidden');
                return;
            }

            // Filter produk
            let visibleCount = 0;
            allProducts.forEach(product => {
                const matches = product.name.includes(searchTerm) ||
                                product.category.includes(searchTerm) ||
                                product.price.toString().includes(searchTerm);
                if (matches) {
                    product.element.style.display = 'block';
                    product.element.classList.add('search-match');
                    visibleCount++;
                } else {
                    product.element.style.display = 'none';
                    product.element.classList.remove('search-match');
                }
            });

            // Tampilkan info hasil pencarian
            searchClear.classList.remove('hidden');
            searchInfo.classList.remove('hidden');
            document.getElementById('resultCount').textContent = `Ditemukan ${visibleCount} produk`;

            // Jika tidak ada hasil
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }

            // Add highlight animation
            highlightMatchedProducts();
        });

        // Tombol untuk hapus pencarian
        if (searchClear) {
            searchClear.addEventListener('click', clearSearch);
        }
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', clearSearch);
        }
        if (showAllBtn) {
            showAllBtn.addEventListener('click', clearSearch);
        }

        // Shortcut keyboard
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
            if (e.key === 'Escape') {
                if (document.activeElement === searchInput && searchInput.value.length > 0) {
                    clearSearch();
                    searchInput.focus();
                }
            }
        });
    }

    function clearSearch() {
        const searchInput = document.getElementById('searchProduct');
        const searchClear = document.getElementById('searchClear');
        const searchInfo = document.getElementById('searchInfo');
        const noResults = document.getElementById('noResults');

        if (!searchInput) return;
        searchInput.value = '';
        searchClear.classList.add('hidden');
        searchInfo.classList.add('hidden');
        noResults.classList.add('hidden');
        showAllProducts();
        searchInput.focus();
    }

    function showAllProducts() {
        allProducts.forEach(product => {
            product.element.style.display = 'block';
            product.element.classList.remove('search-match');
        });
    }

    // Highlight matched products with animation
    function highlightMatchedProducts() {
        const matchedProducts = document.querySelectorAll('.product-item.search-match');
        
        matchedProducts.forEach((product, index) => {
            product.style.animation = 'none';
            setTimeout(() => {
                product.style.animation = 'pulseHighlight 0.6s ease-in-out';
            }, index * 100);
        });
    }

    // Tambah ke keranjang
    function addToCart(productId, productName, price, stock) {
        const existingItem = cart.find(item => item.productId === productId);
        
        if (existingItem) {
            if (existingItem.quantity < stock) {
                existingItem.quantity++;
                existingItem.subtotal = existingItem.quantity * price;
            } else {
                showNotification('Stok tidak mencukupi!', 'error');
                return;
            }
        } else {
            if (stock > 0) {
                cart.push({
                    productId: productId,
                    name: productName,
                    price: price,
                    quantity: 1,
                    subtotal: price
                });
            } else {
                showNotification('Stok habis!', 'error');
                return;
            }
        }
        
        updateCartDisplay();
        showNotification('Produk ditambahkan ke keranjang', 'success');
    }

    // Update tampilan keranjang
    function updateCartDisplay() {
        const cartItems = document.getElementById('cartItems');
        const emptyCart = document.getElementById('emptyCart');
        const totalAmount = document.getElementById('totalAmount');
        const changeAmount = document.getElementById('changeAmount');
        const processBtn = document.getElementById('processBtn');
        
        // Hide empty state if cart has items
        if (cart.length > 0) {
            emptyCart.style.display = 'none';
        } else {
            emptyCart.style.display = 'block';
        }
        
        // Update items
        cartItems.innerHTML = '';
        total = 0;
        
        cart.forEach((item, index) => {
            total += item.subtotal;
            
            const itemElement = document.createElement('div');
            itemElement.className = 'flex justify-between items-center bg-gradient-to-r from-gray-50 to-gray-100/50 p-4 rounded-xl border border-gray-200/60';
            itemElement.innerHTML = `
                <div class="flex-1">
                    <div class="font-semibold text-gray-900">${item.name}</div>
                    <div class="text-sm text-gray-500 mt-1">Rp ${item.price.toLocaleString('id-ID')} x ${item.quantity}</div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="font-bold text-honey-600 text-lg">Rp ${item.subtotal.toLocaleString('id-ID')}</span>
                    <button type="button" onclick="removeFromCart(${index})" 
                            class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors duration-200">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </div>
            `;
            cartItems.appendChild(itemElement);
            
            // Add hidden input for form submission
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `items[${index}][product_id]`;
            hiddenInput.value = item.productId;
            cartItems.appendChild(hiddenInput);
            
            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = `items[${index}][quantity]`;
            qtyInput.value = item.quantity;
            cartItems.appendChild(qtyInput);
        });
        
        // Update total
        totalAmount.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        
        // Update kembalian
        updateChange();
        
        // Enable/disable process button
        processBtn.disabled = cart.length === 0;
    }

    // Hapus dari keranjang
    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCartDisplay();
        showNotification('Produk dihapus dari keranjang', 'warning');
    }

    // Hitung kembalian
    function updateChange() {
        const payment = parseFloat(document.getElementById('payment').value) || 0;
        const change = payment - total;
        const changeAmount = document.getElementById('changeAmount');
        
        if (change >= 0) {
            changeAmount.textContent = `Rp ${change.toLocaleString('id-ID')}`;
            changeAmount.className = 'text-xl bg-gradient-to-r from-green-50 to-green-100 text-green-700 px-4 py-2 rounded-xl';
        } else {
            changeAmount.textContent = `-Rp ${Math.abs(change).toLocaleString('id-ID')}`;
            changeAmount.className = 'text-xl bg-gradient-to-r from-red-50 to-red-100 text-red-700 px-4 py-2 rounded-xl';
        }
    }

    // Event listener untuk input pembayaran
    document.getElementById('payment').addEventListener('input', updateChange);

    // Form submission
    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        if (cart.length === 0) {
            e.preventDefault();
            showNotification('Keranjang kosong!', 'error');
            return;
        }
        
        const payment = parseFloat(document.getElementById('payment').value) || 0;
        if (payment < total) {
            e.preventDefault();
            showNotification('Pembayaran kurang dari total!', 'error');
            return;
        }

        // Show loading state
        const processBtn = document.getElementById('processBtn');
        processBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        processBtn.disabled = true;
    });

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
        const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';
        
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-xl shadow-lg z-50 transform transition-transform duration-300 translate-x-full`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas ${icon} text-lg"></i>
                <span class="font-semibold">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
</script>

<style>
    @keyframes pulseHighlight {
        0% {
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4);
            transform: scale(1);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(245, 158, 11, 0);
            transform: scale(1.02);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
            transform: scale(1);
        }
    }

    .product-item.search-match {
        border-color: rgb(245, 158, 11);
        background: linear-gradient(135deg, #fff, #fefce8);
    }

    #searchProduct:focus {
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    /* Smooth transition for product items */
    .product-item {
        transition: all 0.3s ease-in-out;
    }
</style>
@endsection