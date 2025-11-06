<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Pintar - Transaksi Baru</title>
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
                                 data-product-stock="{{ $product->stock }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : 
                                           ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>
                                <p class="text-lg font-bold text-green-600 mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="decreaseProductQuantity({{ $product->id }})" 
                                                class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors
                                                {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <span id="product-quantity-{{ $product->id }}" class="w-8 text-center font-medium">0</span>
                                        <button onclick="increaseProductQuantity({{ $product->id }})" 
                                                class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors
                                                {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    <button onclick="addToCart({{ $product->id }})" 
                                            class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600 transition-colors text-sm
                                            {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $product->stock == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus mr-1"></i>
                                        Tambah
                                    </button>
                                </div>
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

                        <!-- Calculation Summary -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span id="subtotal" class="font-medium">Rp 0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pajak (10%)</span>
                                <span id="tax" class="font-medium">Rp 0</span>
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
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                            <div class="grid grid-cols-2 gap-2">
                                <button onclick="setPaymentMethod('cash')" 
                                        class="payment-method-btn p-3 border rounded-lg text-center hover:bg-gray-50"
                                        data-method="cash">
                                    <i class="fas fa-money-bill-wave text-green-500 text-xl mb-1"></i>
                                    <div class="text-sm font-medium">Cash</div>
                                </button>
                                <button onclick="setPaymentMethod('qris')" 
                                        class="payment-method-btn p-3 border rounded-lg text-center hover:bg-gray-50"
                                        data-method="qris">
                                    <i class="fas fa-qrcode text-blue-500 text-xl mb-1"></i>
                                    <div class="text-sm font-medium">QRIS</div>
                                </button>
                                <button onclick="setPaymentMethod('debit_card')" 
                                        class="payment-method-btn p-3 border rounded-lg text-center hover:bg-gray-50"
                                        data-method="debit_card">
                                    <i class="fas fa-credit-card text-purple-500 text-xl mb-1"></i>
                                    <div class="text-sm font-medium">Debit Card</div>
                                </button>
                                <button onclick="setPaymentMethod('credit_card')" 
                                        class="payment-method-btn p-3 border rounded-lg text-center hover:bg-gray-50"
                                        data-method="credit_card">
                                    <i class="fas fa-credit-card text-orange-500 text-xl mb-1"></i>
                                    <div class="text-sm font-medium">Credit Card</div>
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

    <script>
        let cart = [];
        let selectedPaymentMethod = '';
        let currentTransactionId = null;
        let productQuantities = {};

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
                if (productName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Increase Product Quantity
        function increaseProductQuantity(productId) {
            if (!productQuantities[productId]) {
                productQuantities[productId] = 0;
            }
            
            const productElement = document.querySelector(`[data-product-id="${productId}"]`);
            const stock = parseInt(productElement.getAttribute('data-product-stock'));
            
            if (productQuantities[productId] < stock) {
                productQuantities[productId]++;
                document.getElementById(`product-quantity-${productId}`).textContent = productQuantities[productId];
            } else {
                alert('Stok tidak mencukupi!');
            }
        }

        // Decrease Product Quantity
        function decreaseProductQuantity(productId) {
            if (!productQuantities[productId]) {
                productQuantities[productId] = 0;
            }
            
            if (productQuantities[productId] > 0) {
                productQuantities[productId]--;
                document.getElementById(`product-quantity-${productId}`).textContent = productQuantities[productId];
            }
        }

        // Add to Cart
        async function addToCart(productId) {
            const quantity = productQuantities[productId] || 0;
            
            if (quantity === 0) {
                alert('Pilih jumlah produk terlebih dahulu!');
                return;
            }

            try {
                const response = await fetch(`/admin/transactions/product/${productId}`);
                const product = await response.json();

                // Check stock
                if (quantity > product.stock) {
                    alert('Stok tidak mencukupi!');
                    return;
                }

                // Check if product already in cart
                const existingItem = cart.find(item => item.product_id === productId);
                
                if (existingItem) {
                    const newTotalQuantity = existingItem.quantity + quantity;
                    if (newTotalQuantity > product.stock) {
                        alert('Stok tidak mencukupi!');
                        return;
                    }
                    existingItem.quantity = newTotalQuantity;
                    existingItem.total = existingItem.price * newTotalQuantity;
                } else {
                    cart.push({
                        product_id: productId,
                        name: product.name,
                        price: product.price,
                        quantity: quantity,
                        total: product.price * quantity,
                        stock: product.stock
                    });
                }

                // Reset quantity counter
                productQuantities[productId] = 0;
                document.getElementById(`product-quantity-${productId}`).textContent = '0';

                updateCartDisplay();
                updateSummary();
                
            } catch (error) {
                console.error('Error adding product to cart:', error);
                alert('Terjadi kesalahan saat menambahkan produk');
            }
        }

        // Update Cart Display
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
                cartHTML += `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">${item.name}</div>
                            <div class="text-sm text-gray-600">
                                ${item.quantity} x Rp ${item.price.toLocaleString('id-ID')} = 
                                <span class="font-semibold text-green-600">Rp ${item.total.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                        <div class="flex items-center">
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

        // Update Summary Calculation
        function updateSummary() {
            let subtotal = cart.reduce((sum, item) => sum + item.total, 0);
            const tax = subtotal * 0.1; // 10% tax
            const discount = 0;
            const total = subtotal + tax - discount;

            document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('tax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
            document.getElementById('discount').textContent = 'Rp ' + discount.toLocaleString('id-ID');
            document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');

            if (selectedPaymentMethod === 'cash') {
                calculateChange();
            }
        }

        // Set Payment Method
        function setPaymentMethod(method) {
            selectedPaymentMethod = method;
            
            document.querySelectorAll('.payment-method-btn').forEach(btn => {
                if (btn.dataset.method === method) {
                    btn.classList.add('border-2', 'border-blue-500', 'bg-blue-50');
                } else {
                    btn.classList.remove('border-2', 'border-blue-500', 'bg-blue-50');
                }
            });

            const cashSection = document.getElementById('cash-payment-section');
            if (method === 'cash') {
                cashSection.classList.remove('hidden');
                calculateChange();
            } else {
                cashSection.classList.add('hidden');
            }
        }

        // Calculate Change
        function calculateChange() {
            if (selectedPaymentMethod !== 'cash') return;

            const total = parseFloat(document.getElementById('total').textContent.replace(/[^\d]/g, '')) || 0;
            const cashPaid = parseFloat(document.getElementById('cash-paid').value) || 0;
            const change = cashPaid - total;

            document.getElementById('change-amount').textContent = 'Rp ' + (change > 0 ? change : 0).toLocaleString('id-ID');
        }

        // Get receipt settings
        async function getReceiptSettings() {
            try {
                const response = await fetch('/admin/settings/receipt-settings');
                const settings = await response.json();
                return settings;
            } catch (error) {
                console.error('Error getting receipt settings:', error);
                return {
                    header: 'SMART CASHIER\nSistem Kasir Pintar',
                    footer: 'Terima kasih atas kunjungan Anda\n*** Struk ini sebagai bukti pembayaran ***',
                    print_automatically: false
                };
            }
        }

        // Process Transaction
        async function processTransaction() {
            // Validasi tanpa customer name
            if (cart.length === 0) {
                alert('Keranjang belanja kosong!');
                return;
            }

            if (!selectedPaymentMethod) {
                alert('Pilih metode pembayaran!');
                return;
            }

            const subtotal = parseFloat(document.getElementById('subtotal').textContent.replace(/[^\d]/g, '')) || 0;
            const tax = parseFloat(document.getElementById('tax').textContent.replace(/[^\d]/g, '')) || 0;
            const total = parseFloat(document.getElementById('total').textContent.replace(/[^\d]/g, '')) || 0;
            const cashPaid = selectedPaymentMethod === 'cash' ? parseFloat(document.getElementById('cash-paid').value) || 0 : 0;
            const changeAmount = selectedPaymentMethod === 'cash' ? (cashPaid - total > 0 ? cashPaid - total : 0) : 0;

            if (selectedPaymentMethod === 'cash' && cashPaid < total) {
                alert('Uang yang dibayarkan kurang!');
                return;
            }

            const transactionData = {
                transaction_code: '{{ $transactionCode }}',
                customer_name: 'Customer', // Default customer name
                customer_phone: '', // Empty phone
                items: cart.map(item => ({
                    product_id: item.product_id,
                    name: item.name,
                    price: item.price,
                    quantity: item.quantity,
                    total: item.total
                })),
                subtotal: subtotal,
                tax: tax,
                discount: 0,
                total: total,
                payment_method: selectedPaymentMethod,
                cash_paid: cashPaid,
                change_amount: changeAmount
            };

            try {
                const response = await fetch('{{ route("admin.transactions.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(transactionData)
                });

                const result = await response.json();

                if (result.success) {
                    currentTransactionId = result.transaction_id;
                    
                    // Get receipt settings
                    const receiptSettings = await getReceiptSettings();
                    
                    // Set print button action
                    document.getElementById('print-receipt-btn').onclick = () => {
                        window.open(result.print_url, '_blank');
                    };
                    
                    // Auto print if enabled
                    if (receiptSettings.print_automatically) {
                        window.open(result.print_url, '_blank');
                    }
                    
                    showSuccessModal();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
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
                cart = [];
                selectedPaymentMethod = '';
                productQuantities = {};
                
                // Reset all quantity counters
                document.querySelectorAll('[id^="product-quantity-"]').forEach(element => {
                    element.textContent = '0';
                });
                
                document.querySelectorAll('.payment-method-btn').forEach(btn => {
                    btn.classList.remove('border-2', 'border-blue-500', 'bg-blue-50');
                });
                
                document.getElementById('cash-payment-section').classList.add('hidden');
                updateCartDisplay();
                updateSummary();
            }
        }
    </script>
</body>
</html>