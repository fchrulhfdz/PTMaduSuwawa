<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Pintar - Transaksi Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r from-blue-600 to-purple-700 text-white shadow-lg">
            <div class="container mx-auto px-4 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold"><i class="fas fa-cash-register mr-3"></i>Smart Cashier</h1>
                        <p class="text-blue-100">Sistem Kasir Pintar - Transaksi Baru</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm opacity-90">{{ date('d F Y') }}</div>
                        <div id="live-clock" class="text-lg font-mono font-bold"></div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b">
            <div class="container mx-auto px-4">
                <div class="flex space-x-4 py-4">
                    <!-- Tombol Kembali -->
                    <a href="{{ route('admin.dashboard') ?? url('/admin') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    
                    <!-- Tombol Transaksi Baru -->
                    <a href="{{ route('admin.transactions.create') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Transaksi Baru</span>
                    </a>
                    
                    <!-- Tombol Daftar Transaksi -->
                    <a href="{{ route('admin.transactions.index') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-list"></i>
                        <span>Daftar Transaksi</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Product Selection & Cart -->
                <div class="lg:col-span-2">
                    <!-- Product List -->
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Produk Tersedia</h2>
                        
                        <!-- Search Bar -->
                        <div class="mb-4">
                            <input type="text" id="product-search" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Cari produk...">
                        </div>

                        <!-- Products Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="products-grid">
                            @foreach($products as $product)
                            <div class="product-card border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                                 data-product-id="{{ $product->id }}"
                                 data-product-name="{{ $product->name }}"
                                 data-product-price="{{ $product->price }}"
                                 data-product-stock="{{ $product->stock }}"
                                 data-product-berat="{{ $product->berat_isi ?? 0 }}"
                                 data-product-satuan="{{ $product->satuan_berat ?? 'kg' }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : 
                                           ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>
                                @if($product->berat_isi)
                                <div class="mb-2">
                                    <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800">
                                        Berat: {{ $product->berat_isi }}{{ $product->satuan_berat }}
                                    </span>
                                </div>
                                @endif
                                <p class="text-lg font-bold text-green-600 mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                
                                <!-- Tombol Tambah ke Keranjang -->
                                <button onclick="addToCart({{ $product->id }})" 
                                        class="w-full bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600 transition-colors text-sm
                                        {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-cart-plus mr-1"></i>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                            @endforeach
                        </div>

                        @if($products->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-3"></i>
                            <p>Tidak ada produk tersedia</p>
                        </div>
                        @endif
                    </div>

                    <!-- Shopping Cart -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Keranjang Belanja</h2>
                        
                        <div class="space-y-3" id="cart-items">
                            <!-- Cart items will be added here -->
                        </div>

                        <div id="empty-cart" class="text-center py-8 text-gray-500">
                            <i class="fas fa-shopping-cart text-4xl mb-3"></i>
                            <p>Keranjang belanja kosong</p>
                            <p class="text-sm">Pilih produk dari daftar di atas</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Transaksi</h2>
                        
                        <!-- Transaction Code -->
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-600">Kode Transaksi</div>
                            <div class="font-mono font-bold text-blue-600">{{ $transactionCode }}</div>
                        </div>

                        <!-- Customer Information -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Customer</label>
                            <input type="text" id="customer-name" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Masukkan nama customer" value="Customer">
                        </div>

                        <!-- Calculation Summary -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span id="subtotal" class="font-medium">Rp 0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Diskon</span>
                                <span id="discount" class="font-medium">Rp 0</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-800">Total</span>
                                <span id="total" class="text-green-600">Rp 0</span>
                            </div>
                            <!-- Total Berat -->
                            <div class="flex justify-between text-sm text-blue-600 mt-2">
                                <span>Total Berat:</span>
                                <span id="total-berat">0 kg</span>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                            <div class="grid grid-cols-2 gap-2">
                                <button onclick="setPaymentMethod('cash')" 
                                        class="payment-method-btn p-3 border border-gray-300 rounded-lg text-center hover:bg-gray-50 transition-colors"
                                        data-method="cash">
                                    <i class="fas fa-money-bill-wave text-green-500 text-xl mb-1"></i>
                                    <div class="text-sm font-medium">Cash</div>
                                </button>
                                <button onclick="setPaymentMethod('transfer')" 
                                        class="payment-method-btn p-3 border border-gray-300 rounded-lg text-center hover:bg-gray-50 transition-colors"
                                        data-method="transfer">
                                    <i class="fas fa-university text-blue-500 text-xl mb-1"></i>
                                    <div class="text-sm font-medium">Transfer</div>
                                </button>
                            </div>
                        </div>

                        <!-- Cash Payment -->
                        <div id="cash-payment-section" class="mb-6 hidden">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Uang Diberikan</label>
                                    <input type="number" id="cash-paid" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           placeholder="0" oninput="calculateChange()">
                                </div>
                                <div class="p-3 bg-green-50 rounded-lg">
                                    <div class="text-sm text-gray-600">Kembalian</div>
                                    <div id="change-amount" class="text-lg font-bold text-green-600">Rp 0</div>
                                </div>
                            </div>
                        </div>

                        <!-- Transfer Payment -->
                        <div id="transfer-payment-section" class="mb-6 hidden">
                            <div class="p-4 bg-blue-50 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                    <span class="text-sm font-medium text-blue-800">Informasi Transfer</span>
                                </div>
                                <div class="text-sm text-blue-700">
                                    <p>Silakan transfer ke rekening berikut:</p>
                                    <p class="font-semibold mt-1">BANK ABC - 123 456 7890</p>
                                    <p class="font-semibold">a.n. SMART CASHIER STORE</p>
                                    <p class="text-xs mt-2">Transaksi akan diproses setelah pembayaran dikonfirmasi</p>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea id="notes" rows="2" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Tambahkan catatan transaksi..."></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <button onclick="processTransaction()" 
                                    class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition-colors font-semibold">
                                <i class="fas fa-check mr-2"></i>Proses Transaksi
                            </button>
                            <button onclick="resetForm()" 
                                    class="w-full bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition-colors">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Transaksi Berhasil!</h3>
                <p class="text-gray-600 mb-6">Transaksi telah berhasil diproses dan disimpan.</p>
                <div class="flex space-x-3">
                    <button onclick="closeSuccessModal()" 
                            class="flex-1 bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        Tutup
                    </button>
                    <button id="print-receipt-btn" 
                            class="flex-1 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-print mr-2"></i>Print Struk
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Product Modal -->
    <div id="detail-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800" id="detail-product-name">Nama Produk</h3>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-600 mb-2">Harga: <span id="detail-product-price" class="font-semibold text-green-600">Rp 0</span></p>
                <p class="text-gray-600">Stok: <span id="detail-product-stock" class="font-semibold">0</span></p>
                <p class="text-gray-600">Berat: <span id="detail-product-berat" class="font-semibold">0 kg</span></p>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <button onclick="decreaseDetailQuantity()" 
                            class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span id="detail-quantity" class="w-12 text-center font-medium text-lg">1</span>
                    <button onclick="increaseDetailQuantity()" 
                            class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <button onclick="addFromDetailModal()" 
                        class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-cart-plus mr-1"></i>Tambah
                </button>
            </div>

            <!-- Centang Harga Sementara di dalam popup -->
            <div class="mb-4 border-t pt-4">
                <label class="flex items-center space-x-2 cursor-pointer mb-3">
                    <input type="checkbox" id="enable-price-override-detail" 
                           class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                           onchange="togglePriceOverrideDetail()">
                    <span class="text-sm font-medium text-gray-700">Harga Sementara</span>
                </label>
                
                <div id="price-override-section-detail" class="mt-3 hidden">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-yellow-800 mb-1">Harga Baru</label>
                                <input type="number" id="override-price-detail" 
                                       class="w-full px-3 py-2 border border-yellow-300 rounded-lg text-sm"
                                       placeholder="Masukkan harga baru">
                            </div>
                            <button onclick="applyPriceOverrideDetail()" 
                                    class="w-full bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600 transition-colors text-sm">
                                <i class="fas fa-check mr-1"></i>Terapkan Harga
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Centang Diskon Per Jumlah di dalam popup -->
            <div class="mb-4 border-t pt-4">
                <label class="flex items-center space-x-2 cursor-pointer mb-3">
                    <input type="checkbox" id="enable-quantity-discount-detail" 
                           class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500"
                           onchange="toggleQuantityDiscountDetail()">
                    <span class="text-sm font-medium text-gray-700">Diskon Per Jumlah</span>
                </label>
                
                <div id="quantity-discount-section-detail" class="mt-3 hidden">
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <div class="space-y-3">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-purple-800 mb-1">Min. Qty</label>
                                    <input type="number" id="discount-min-qty-detail" 
                                           class="w-full px-3 py-2 border border-purple-300 rounded-lg text-sm"
                                           placeholder="Min" min="1">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-purple-800 mb-1">Diskon (%)</label>
                                    <input type="number" id="discount-percentage-detail" 
                                           class="w-full px-3 py-2 border border-purple-300 rounded-lg text-sm"
                                           placeholder="%" min="0" max="100" step="0.1">
                                </div>
                            </div>
                            <button onclick="applyQuantityDiscountDetail()" 
                                    class="w-full bg-purple-500 text-white py-2 rounded-lg hover:bg-purple-600 transition-colors text-sm">
                                <i class="fas fa-percentage mr-1"></i>Terapkan Diskon
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let cart = [];
    let selectedPaymentMethod = '';
    let currentTransactionId = null;
    let priceOverrides = {};
    let quantityDiscounts = {};
    let currentDetailProduct = null;
    let detailQuantity = 1;

    // FUNGSI BARU: Format berat (otomatis konversi gram ke kg jika >= 1000g)
    function formatBerat(berat, satuan) {
        if (satuan === 'g' && berat >= 1000) {
            return (berat / 1000).toFixed(2) + ' kg';
        }
        return berat.toFixed(2) + ' ' + satuan;
    }

    // FUNGSI BARU: Hitung total berat dalam format yang sesuai
    function hitungTotalBeratDisplay() {
        let totalGram = 0;
        
        cart.forEach(item => {
            const beratItem = item.berat_isi || 0;
            const satuan = item.satuan_berat || 'g';
            const totalBeratItem = beratItem * item.quantity;
            
            if (satuan === 'kg') {
                totalGram += totalBeratItem * 1000;
            } else {
                totalGram += totalBeratItem;
            }
        });
        
        // Konversi ke format yang sesuai
        if (totalGram >= 1000) {
            return (totalGram / 1000).toFixed(2) + ' kg';
        } else {
            return totalGram.toFixed(0) + ' g';
        }
    }

    // Fungsi untuk membersihkan dan memformat angka
    function cleanNumber(str) {
        if (str === null || typeof str === 'undefined') return 0;
        const s = String(str).trim();

        // Jika tampilan khusus (mis. "Rp –" atau kosong) -> 0
        if (s === '' || /[–\-—]/.test(s)) return 0;

        // Hapus semua karakter kecuali digit, titik, koma
        // Kemudian hapus titik sebagai pemisah ribuan, ganti koma desimal jadi titik
        let cleaned = s.replace(/[^\d.,-]/g, '');

        // Jika ada lebih dari satu tanda minus, hapus yang berlebih
        // Taruh minus di awal jika ada
        const minusMatches = cleaned.match(/-/g);
        const isNegative = minusMatches && minusMatches.length % 2 === 1 && cleaned.includes('-');
        cleaned = cleaned.replace(/-/g, '');

        // Hapus titik (pemisah ribuan)
        cleaned = cleaned.replace(/\./g, '');
        // Ganti koma desimal menjadi titik (jika ada)
        cleaned = cleaned.replace(/,/g, '.');

        const num = parseFloat(cleaned);
        if (isNaN(num)) return 0;
        return isNegative ? -num : num;
    }

    // Fungsi untuk memformat angka ke Rupiah
    function formatRupiah(angka) {
        const value = Number(angka) || 0;
        if (value === 0) return 'Rp –';
        const rounded = Math.round(value);
        // Format dengan pemisah ribuan titik
        return 'Rp ' + rounded.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Fungsi untuk mendapatkan CSRF token
    function getCsrfToken() {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        return metaToken ? metaToken.getAttribute('content') : '';
    }

    // Enhanced fetch function
    async function apiFetch(url, options = {}) {
        const csrfToken = getCsrfToken();
        
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            credentials: 'same-origin'
        };

        const mergedOptions = {
            ...defaultOptions,
            ...options,
            headers: {
                ...defaultOptions.headers,
                ...options.headers
            }
        };

        try {
            const response = await fetch(url, mergedOptions);
            
            if (response.status === 401 || response.status === 419) {
                handleSessionExpired();
                throw new Error('Session expired');
            }

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return await response.json();
            }
            return await response.text();
        } catch (error) {
            console.error('API Fetch Error:', error);
            if (error.message !== 'Session expired') {
                showAlert('Terjadi kesalahan: ' + error.message, 'error');
            }
            throw error;
        }
    }

    // Alert system
    function showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.custom-alert');
        existingAlerts.forEach(alert => alert.remove());

        const alert = document.createElement('div');
        const bgColor = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        }[type];

        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-triangle',
            warning: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        }[type];

        alert.className = `custom-alert fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 translate-x-full`;
        alert.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fas ${icons}"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;

        document.body.appendChild(alert);

        setTimeout(() => alert.classList.remove('translate-x-full'), 100);
        
        setTimeout(() => {
            alert.classList.add('translate-x-full');
            setTimeout(() => alert.remove(), 300);
        }, 4000);
    }

    // Handle session expired
    function handleSessionExpired() {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Sesi Berakhir</h3>
                    <p class="text-gray-600 mb-4">Sesi Anda telah berakhir. Silakan login kembali.</p>
                    <div class="flex space-x-3">
                        <button onclick="window.location.href='/login'" 
                                class="flex-1 bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition-colors">
                            Login Kembali
                        </button>
                        <button onclick="this.closest('.fixed').remove()" 
                                class="flex-1 bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600 transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Live Clock
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        });
        document.getElementById('live-clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Product Search
    document.getElementById('product-search').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(card => {
            const productName = card.getAttribute('data-product-name').toLowerCase();
            card.style.display = productName.includes(searchTerm) ? 'block' : 'none';
        });
    });

    // Toggle Price Override Section
    function togglePriceOverrideDetail() {
        const checkbox = document.getElementById('enable-price-override-detail');
        const section = document.getElementById('price-override-section-detail');
        section.classList.toggle('hidden', !checkbox.checked);
    }

    // Toggle Quantity Discount Section
    function toggleQuantityDiscountDetail() {
        const checkbox = document.getElementById('enable-quantity-discount-detail');
        const section = document.getElementById('quantity-discount-section-detail');
        section.classList.toggle('hidden', !checkbox.checked);
    }

    // Apply Price Override
    function applyPriceOverrideDetail() {
        if (!currentDetailProduct) return;
        
        const newPrice = parseFloat(document.getElementById('override-price-detail').value);
        if (!newPrice || newPrice <= 0) {
            showAlert('Masukkan harga yang valid!', 'error');
            return;
        }
        
        const productElement = document.querySelector(`[data-product-id="${currentDetailProduct}"]`);
        const currentPrice = parseFloat(productElement.getAttribute('data-product-price'));
        
        if (newPrice === currentPrice) {
            delete priceOverrides[currentDetailProduct];
            showAlert('Harga direset ke harga normal', 'success');
        } else {
            priceOverrides[currentDetailProduct] = newPrice;
            showAlert(`Harga diubah menjadi Rp ${newPrice.toLocaleString('id-ID')}`, 'success');
        }
        
        updateCartWithOverrides();
        document.getElementById('override-price-detail').value = '';
        document.getElementById('enable-price-override-detail').checked = false;
        document.getElementById('price-override-section-detail').classList.add('hidden');
    }

    // Apply Quantity Discount
    function applyQuantityDiscountDetail() {
        if (!currentDetailProduct) return;
        
        const minQty = parseInt(document.getElementById('discount-min-qty-detail').value);
        const percentage = parseFloat(document.getElementById('discount-percentage-detail').value);
        
        if (!minQty || minQty <= 0) {
            showAlert('Masukkan jumlah minimum yang valid!', 'error');
            return;
        }
        
        if (!percentage || percentage < 0 || percentage > 100) {
            showAlert('Masukkan persentase diskon yang valid (0-100)!', 'error');
            return;
        }
        
        if (percentage === 0) {
            delete quantityDiscounts[currentDetailProduct];
            showAlert('Diskon dihapus', 'success');
        } else {
            quantityDiscounts[currentDetailProduct] = { min_quantity: minQty, percentage: percentage };
            showAlert(`Diskon ${percentage}% untuk minimal ${minQty} pcs`, 'success');
        }
        
        updateCartWithDiscounts();
        document.getElementById('discount-min-qty-detail').value = '';
        document.getElementById('discount-percentage-detail').value = '';
        document.getElementById('enable-quantity-discount-detail').checked = false;
        document.getElementById('quantity-discount-section-detail').classList.add('hidden');
    }

    // Update cart with price overrides
    function updateCartWithOverrides() {
        cart.forEach(item => {
            if (priceOverrides[item.product_id]) {
                item.original_price = item.price;
                item.price = priceOverrides[item.product_id];
                item.total = item.price * item.quantity;
                applyQuantityDiscountToItem(item);
            } else if (item.original_price) {
                item.price = item.original_price;
                item.total = item.price * item.quantity;
                delete item.original_price;
                applyQuantityDiscountToItem(item);
            }
        });
        updateCartDisplay();
        updateSummary();
    }

    // Update cart with quantity discounts
    function updateCartWithDiscounts() {
        cart.forEach(item => {
            applyQuantityDiscountToItem(item);
        });
        updateCartDisplay();
        updateSummary();
    }

    // Helper function untuk apply discount
    function applyQuantityDiscountToItem(item) {
        const discount = quantityDiscounts[item.product_id];
        if (discount && item.quantity >= discount.min_quantity) {
            item.discount_percentage = discount.percentage;
            item.discount_amount = (item.total * discount.percentage) / 100;
            item.final_total = item.total - item.discount_amount;
        } else {
            delete item.discount_percentage;
            delete item.discount_amount;
            delete item.final_total;
        }
    }

    // Add to Cart - FIXED VERSION
    async function addToCart(productId) {
        try {
            // Dapatkan data produk dari elemen HTML langsung (fallback jika API gagal)
            const productElement = document.querySelector(`[data-product-id="${productId}"]`);
            if (!productElement) {
                showAlert('Produk tidak ditemukan!', 'error');
                return;
            }

            const productData = {
                id: productId,
                name: productElement.getAttribute('data-product-name'),
                price: parseFloat(productElement.getAttribute('data-product-price')),
                stock: parseInt(productElement.getAttribute('data-product-stock')),
                berat_isi: parseFloat(productElement.getAttribute('data-product-berat') || 0),
                satuan_berat: productElement.getAttribute('data-product-satuan') || 'kg'
            };

            const finalPrice = priceOverrides[productId] || productData.price;

            // Cek stok
            if (productData.stock <= 0) {
                showAlert('Stok produk habis!', 'warning');
                return;
            }

            const existingItem = cart.find(item => item.product_id === productId);
            
            if (existingItem) {
                const newTotalQuantity = existingItem.quantity + 1;
                if (newTotalQuantity > productData.stock) {
                    showAlert('Stok tidak mencukupi!', 'warning');
                    return;
                }
                existingItem.quantity = newTotalQuantity;
                existingItem.price = finalPrice;
                existingItem.total = finalPrice * newTotalQuantity;
                existingItem.berat_isi = productData.berat_isi;
                existingItem.satuan_berat = productData.satuan_berat;
                applyQuantityDiscountToItem(existingItem);
            } else {
                const newItem = {
                    product_id: productId,
                    name: productData.name,
                    price: finalPrice,
                    quantity: 1,
                    total: finalPrice,
                    stock: productData.stock,
                    berat_isi: productData.berat_isi,
                    satuan_berat: productData.satuan_berat
                };
                applyQuantityDiscountToItem(newItem);
                cart.push(newItem);
            }

            updateCartDisplay();
            updateSummary();
            showAlert('Produk ditambahkan ke keranjang', 'success');
            
        } catch (error) {
            console.error('Error adding to cart:', error);
            showAlert('Gagal menambahkan produk', 'error');
        }
    }

    // Show Detail Modal - MODIFIED untuk format berat
    function showDetailModal(productId) {
        const productElement = document.querySelector(`[data-product-id="${productId}"]`);
        if (!productElement) {
            showAlert('Produk tidak ditemukan!', 'error');
            return;
        }

        document.getElementById('detail-product-name').textContent = productElement.getAttribute('data-product-name');
        document.getElementById('detail-product-price').textContent = 'Rp ' + parseInt(productElement.getAttribute('data-product-price')).toLocaleString('id-ID');
        document.getElementById('detail-product-stock').textContent = productElement.getAttribute('data-product-stock');
        
        // Format berat untuk detail modal
        const berat = parseFloat(productElement.getAttribute('data-product-berat') || 0);
        const satuan = productElement.getAttribute('data-product-satuan') || 'g';
        const displayBerat = formatBerat(berat, satuan);
        document.getElementById('detail-product-berat').textContent = displayBerat;
        
        currentDetailProduct = productId;
        detailQuantity = 1;
        document.getElementById('detail-quantity').textContent = detailQuantity;
        
        // Reset form fields
        document.getElementById('enable-price-override-detail').checked = false;
        document.getElementById('price-override-section-detail').classList.add('hidden');
        document.getElementById('override-price-detail').value = '';
        
        document.getElementById('enable-quantity-discount-detail').checked = false;
        document.getElementById('quantity-discount-section-detail').classList.add('hidden');
        document.getElementById('discount-min-qty-detail').value = '';
        document.getElementById('discount-percentage-detail').value = '';
        
        document.getElementById('detail-modal').classList.remove('hidden');
    }

    // Close Detail Modal
    function closeDetailModal() {
        document.getElementById('detail-modal').classList.add('hidden');
    }

    // Increase Detail Quantity
    function increaseDetailQuantity() {
        const stock = parseInt(document.getElementById('detail-product-stock').textContent);
        if (detailQuantity < stock) {
            detailQuantity++;
            document.getElementById('detail-quantity').textContent = detailQuantity;
        } else {
            showAlert('Stok tidak mencukupi!', 'warning');
        }
    }

    // Decrease Detail Quantity
    function decreaseDetailQuantity() {
        if (detailQuantity > 1) {
            detailQuantity--;
            document.getElementById('detail-quantity').textContent = detailQuantity;
        }
    }

    // Add from Detail Modal - FIXED VERSION
    async function addFromDetailModal() {
        if (!currentDetailProduct) return;

        try {
            // Dapatkan data produk dari elemen HTML langsung
            const productElement = document.querySelector(`[data-product-id="${currentDetailProduct}"]`);
            if (!productElement) {
                showAlert('Produk tidak ditemukan!', 'error');
                return;
            }

            const productData = {
                id: currentDetailProduct,
                name: productElement.getAttribute('data-product-name'),
                price: parseFloat(productElement.getAttribute('data-product-price')),
                stock: parseInt(productElement.getAttribute('data-product-stock')),
                berat_isi: parseFloat(productElement.getAttribute('data-product-berat') || 0),
                satuan_berat: productElement.getAttribute('data-product-satuan') || 'kg'
            };

            const finalPrice = priceOverrides[currentDetailProduct] || productData.price;

            if (detailQuantity > productData.stock) {
                showAlert('Stok tidak mencukupi!', 'warning');
                return;
            }

            const existingItem = cart.find(item => item.product_id === currentDetailProduct);
            
            if (existingItem) {
                const newTotalQuantity = existingItem.quantity + detailQuantity;
                if (newTotalQuantity > productData.stock) {
                    showAlert('Stok tidak mencukupi!', 'warning');
                    return;
                }
                existingItem.quantity = newTotalQuantity;
                existingItem.price = finalPrice;
                existingItem.total = finalPrice * newTotalQuantity;
                existingItem.berat_isi = productData.berat_isi;
                existingItem.satuan_berat = productData.satuan_berat;
                applyQuantityDiscountToItem(existingItem);
            } else {
                const newItem = {
                    product_id: currentDetailProduct,
                    name: productData.name,
                    price: finalPrice,
                    quantity: detailQuantity,
                    total: finalPrice * detailQuantity,
                    stock: productData.stock,
                    berat_isi: productData.berat_isi,
                    satuan_berat: productData.satuan_berat
                };
                applyQuantityDiscountToItem(newItem);
                cart.push(newItem);
            }

            closeDetailModal();
            updateCartDisplay();
            updateSummary();
            showAlert('Produk ditambahkan ke keranjang', 'success');
            
        } catch (error) {
            console.error('Error adding from detail modal:', error);
            showAlert('Gagal menambahkan produk', 'error');
        }
    }

    // Update Cart Display - MODIFIED untuk format berat
    function updateCartDisplay() {
        const cartItems = document.getElementById('cart-items');
        const emptyCart = document.getElementById('empty-cart');
        
        if (cart.length === 0) {
            cartItems.innerHTML = '';
            emptyCart.style.display = 'block';
            return;
        }
        
        emptyCart.style.display = 'none';
        
        let cartHTML = '';
        cart.forEach((item, index) => {
            const hasOverride = priceOverrides[item.product_id];
            const hasDiscount = item.discount_percentage;
            const displayTotal = hasDiscount ? item.final_total : item.total;
            
            // Hitung berat per item dengan konversi otomatis
            const beratPerItem = item.berat_isi || 0;
            const satuan = item.satuan_berat || 'g';
            const totalBeratItem = beratPerItem * item.quantity;
            const displayBeratPerItem = formatBerat(beratPerItem, satuan);
            const displayTotalBerat = formatBerat(totalBeratItem, satuan);
            
            cartHTML += `
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-gray-800">${item.name}</h4>
                            <span class="text-sm font-bold text-green-600">
                                ${formatRupiah(displayTotal)}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-2">
                            <div>
                                <span class="font-medium">Harga:</span> ${formatRupiah(item.price)}
                                ${hasOverride ? '<span class="text-xs text-yellow-600 ml-1">(harga khusus)</span>' : ''}
                            </div>
                            <div>
                                <span class="font-medium">Qty:</span> ${item.quantity}
                            </div>
                        </div>
                        
                        ${beratPerItem > 0 ? `
                            <div class="text-xs text-blue-600 bg-blue-50 p-2 rounded border border-blue-200 mb-2">
                                <span class="font-medium">Berat:</span> ${displayBeratPerItem} × ${item.quantity} = ${displayTotalBerat}
                            </div>
                        ` : ''}
                        
                        ${hasDiscount ? `
                            <div class="text-xs text-purple-600 bg-purple-50 p-2 rounded border border-purple-200 mb-2">
                                <span class="font-medium">Diskon:</span> ${item.discount_percentage}% 
                                (${formatRupiah(-item.discount_amount)})
                            </div>
                            <div class="text-sm ${hasDiscount ? 'line-through text-gray-400' : 'font-semibold text-green-600'}">
                                Total: ${formatRupiah(item.total)}
                            </div>
                            <div class="text-sm font-semibold text-green-600">
                                Total Akhir: ${formatRupiah(displayTotal)}
                            </div>
                        ` : `
                            <div class="text-sm font-semibold text-green-600">
                                Total: ${formatRupiah(displayTotal)}
                            </div>
                        `}
                    </div>
                    
                    <div class="flex flex-col items-center space-y-2 ml-4">
                        <button onclick="showDetailModal(${item.product_id})" 
                                class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-200 transition-colors">
                            <i class="fas fa-edit text-xs"></i>
                        </button>
                        <button onclick="removeFromCart(${index})" 
                                class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center hover:bg-red-200 transition-colors">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        
        cartItems.innerHTML = cartHTML;
    }

    // Remove from Cart
    function removeFromCart(index) {
        if (confirm('Hapus produk ini dari keranjang?')) {
            cart.splice(index, 1);
            updateCartDisplay();
            updateSummary();
        }
    }

    // Update Summary Calculation - MODIFIED untuk format berat
    function updateSummary() {
        let subtotal = cart.reduce((sum, item) => sum + (item.final_total || item.total), 0);
        const totalDiscount = cart.reduce((sum, item) => sum + (item.discount_amount || 0), 0);
        const total = subtotal - totalDiscount;
        
        // Update total berat dengan format otomatis
        const totalBeratDisplay = hitungTotalBeratDisplay();

        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('discount').textContent = formatRupiah(totalDiscount);
        document.getElementById('total').textContent = formatRupiah(total);
        document.getElementById('total-berat').textContent = totalBeratDisplay;

        if (selectedPaymentMethod === 'cash') {
            calculateChange();
        }
    }

    // Set Payment Method
    function setPaymentMethod(method) {
        selectedPaymentMethod = method;
        
        // Reset semua tombol
        document.querySelectorAll('.payment-method-btn').forEach(btn => {
            btn.classList.remove('border-2', 'border-blue-500', 'bg-blue-50');
            btn.classList.add('border', 'border-gray-300');
        });
        
        // Aktifkan tombol yang dipilih
        const selectedBtn = document.querySelector(`.payment-method-btn[data-method="${method}"]`);
        if (selectedBtn) {
            selectedBtn.classList.add('border-2', 'border-blue-500', 'bg-blue-50');
            selectedBtn.classList.remove('border-gray-300');
        }
        
        // Tampilkan/sembunyikan section yang sesuai
        const cashSection = document.getElementById('cash-payment-section');
        const transferSection = document.getElementById('transfer-payment-section');
        
        if (method === 'cash') {
            cashSection.classList.remove('hidden');
            transferSection.classList.add('hidden');
            calculateChange();
        } else if (method === 'transfer') {
            cashSection.classList.add('hidden');
            transferSection.classList.remove('hidden');
        } else {
            cashSection.classList.add('hidden');
            transferSection.classList.add('hidden');
        }
    }

    // Calculate Change
    function calculateChange() {
        if (selectedPaymentMethod !== 'cash') return;

        const total = cleanNumber(document.getElementById('total').textContent);
        const cashPaid = cleanNumber(document.getElementById('cash-paid').value);
        const change = cashPaid - total;

        document.getElementById('change-amount').textContent = formatRupiah(Math.max(0, change));
    }

    // Process Transaction
    async function processTransaction() {
        if (cart.length === 0) {
            showAlert('Keranjang belanja kosong!', 'warning');
            return;
        }

        if (!selectedPaymentMethod) {
            showAlert('Pilih metode pembayaran!', 'warning');
            return;
        }

        const subtotal = cleanNumber(document.getElementById('subtotal').textContent);
        const total = cleanNumber(document.getElementById('total').textContent);
        
        let cashPaid = 0;
        let changeAmount = 0;
        
        if (selectedPaymentMethod === 'cash') {
            cashPaid = cleanNumber(document.getElementById('cash-paid').value);
            changeAmount = Math.max(0, cashPaid - total);
            
            if (cashPaid < total) {
                showAlert('Uang yang dibayarkan kurang!', 'error');
                return;
            }
            
            if (cashPaid <= 0) {
                showAlert('Masukkan jumlah uang yang dibayarkan!', 'error');
                return;
            }
        }

        const customerName = document.getElementById('customer-name').value || 'Customer';
        const notes = document.getElementById('notes').value;

        const transactionData = {
            transaction_code: '{{ $transactionCode }}',
            customer_name: customerName,
            items: cart.map(item => ({
                product_id: item.product_id,
                name: item.name,
                price: item.price,
                quantity: item.quantity,
                total: item.final_total || item.total,
                discount_percentage: item.discount_percentage || 0,
                discount_amount: item.discount_amount || 0,
                final_total: item.final_total || item.total,
                original_price: item.original_price || item.price,
                berat_isi: item.berat_isi || 0,
                satuan_berat: item.satuan_berat || 'kg'
            })),
            subtotal: subtotal,
            tax: 0,
            discount: cart.reduce((sum, item) => sum + (item.discount_amount || 0), 0),
            total: total,
            payment_method: selectedPaymentMethod,
            cash_paid: cashPaid,
            change_amount: changeAmount,
            notes: notes
        };

        try {
            showAlert('Memproses transaksi...', 'info');
            
            const result = await apiFetch('{{ route("admin.transactions.store") }}', {
                method: 'POST',
                body: JSON.stringify(transactionData)
            });

            if (result.success) {
                currentTransactionId = result.transaction_id;
                
                document.getElementById('print-receipt-btn').onclick = () => {
                    if (result.print_url) {
                        window.open(result.print_url, '_blank');
                    }
                };
                
                if (result.print_url) {
                    setTimeout(() => window.open(result.print_url, '_blank'), 500);
                }
                
                showSuccessModal();
                showAlert(result.message || 'Transaksi berhasil diproses!', 'success');
            } else {
                showAlert(result.message || 'Terjadi kesalahan', 'error');
            }
        } catch (error) {
            if (!error.message.includes('Session expired')) {
                showAlert('Gagal memproses transaksi: ' + error.message, 'error');
            }
        }
    }

    // Show Success Modal
    function showSuccessModal() {
        document.getElementById('success-modal').classList.remove('hidden');
    }

    // Close Success Modal
    function closeSuccessModal() {
        document.getElementById('success-modal').classList.add('hidden');
        window.location.href = '{{ route("admin.transactions.index") }}';
    }

    // Reset Form
    function resetForm() {
        if (confirm('Reset form transaksi? Semua data akan dihapus.')) {
            document.getElementById('cash-paid').value = '';
            document.getElementById('customer-name').value = 'Customer';
            document.getElementById('notes').value = '';
            
            cart = [];
            selectedPaymentMethod = '';
            priceOverrides = {};
            quantityDiscounts = {};
            
            // Reset tombol payment method
            document.querySelectorAll('.payment-method-btn').forEach(btn => {
                btn.classList.remove('border-2', 'border-blue-500', 'bg-blue-50');
                btn.classList.add('border', 'border-gray-300');
            });
            
            document.getElementById('cash-payment-section').classList.add('hidden');
            document.getElementById('transfer-payment-section').classList.add('hidden');
            updateCartDisplay();
            updateSummary();
            
            showAlert('Form telah direset', 'info');
        }
    }

    // Event listener untuk input cash-paid
    document.addEventListener('DOMContentLoaded', function() {
        updateCartDisplay();
        updateSummary();
        
        const cashPaidInput = document.getElementById('cash-paid');
        if (cashPaidInput) {
            cashPaidInput.addEventListener('input', function(e) {
                let v = this.value || '';
                v = v.replace(/[^\d.,-]/g, '');
                if (v.length > 1 && v.startsWith('0') && v.charAt(1) !== ',' && v.charAt(1) !== '.') {
                    v = v.replace(/^0+/, '');
                }
                this.value = v;
                calculateChange();
            });
            
            cashPaidInput.addEventListener('blur', function(e) {
                if (!this.value || cleanNumber(this.value) === 0) {
                    this.value = '';
                }
            });
        }
    });
</script>
</body>
</html>