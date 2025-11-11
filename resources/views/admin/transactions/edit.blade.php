<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi - Smart Cashier</title>
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
                        <p class="text-blue-100">Sistem Kasir Pintar - Edit Transaksi</p>
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
                    <a href="{{ route('admin.transactions.index') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    
                    <a href="{{ route('admin.transactions.create') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Transaksi Baru</span>
                    </a>
                    
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
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Transaksi #{{ $transaction->transaction_code }}</h2>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Transaction Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Transaksi</label>
                                <div class="p-3 bg-gray-100 rounded-lg font-mono text-gray-800">
                                    {{ $transaction->transaction_code }}
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Transaksi</label>
                                <div class="p-3 bg-gray-100 rounded-lg text-gray-800">
                                    {{ $transaction->created_at->format('d F Y H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Customer</h3>
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Customer <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="customer_name" name="customer_name" 
                                       value="{{ old('customer_name', $transaction->customer_name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('customer_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Items Summary -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Items</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-3">
                                    @php
                                        $items = $transaction->items_array;
                                    @endphp
                                    
                                    @foreach($items as $index => $item)
                                    <div class="flex justify-between items-center p-3 bg-white rounded border">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-800">{{ $item['name'] }}</div>
                                            <div class="text-sm text-gray-600">
                                                {{ $item['quantity'] }} pcs × Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                @if(isset($item['berat_isi']) && $item['berat_isi'] > 0)
                                                <span class="ml-2 text-blue-600">
                                                    ({{ $item['berat_isi'] }}{{ $item['satuan_berat'] ?? 'kg' }} × {{ $item['quantity'] }} = {{ ($item['berat_isi'] * $item['quantity']) }}{{ $item['satuan_berat'] ?? 'kg' }})
                                                </span>
                                                @endif
                                            </div>
                                            @if(isset($item['discount_amount']) && $item['discount_amount'] > 0)
                                            <div class="text-sm text-purple-600">
                                                Diskon: {{ $item['discount_percentage'] ?? 0 }}% (Rp {{ number_format($item['discount_amount'], 0, ',', '.') }})
                                            </div>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <div class="font-semibold text-green-600">
                                                Rp {{ number_format($item['final_total'] ?? $item['total'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <!-- Total Berat -->
                                @if($transaction->total_berat > 0)
                                <div class="mt-4 p-3 bg-blue-50 rounded border border-blue-200">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-blue-800">Total Berat Transaksi:</span>
                                        <span class="font-bold text-blue-800">{{ number_format($transaction->total_berat, 2) }} kg</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pembayaran</h3>
                                
                                <div class="space-y-4">
                                    <!-- Payment Method -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Metode Pembayaran <span class="text-red-500">*</span>
                                        </label>
                                        <select name="payment_method" 
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                            <option value="cash" {{ old('payment_method', $transaction->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="transfer" {{ old('payment_method', $transaction->payment_method) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        </select>
                                        @error('payment_method')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Status Transaksi <span class="text-red-500">*</span>
                                        </label>
                                        <select name="status" 
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                            <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="completed" {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        @error('status')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction Summary -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Transaksi</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="font-medium">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    @if($transaction->tax > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Pajak</span>
                                        <span class="font-medium">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($transaction->discount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Diskon</span>
                                        <span class="font-medium text-red-600">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                    
                                    <hr>
                                    <div class="flex justify-between text-lg font-bold">
                                        <span class="text-gray-800">Total</span>
                                        <span class="text-green-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                                    </div>

                                    @if($transaction->payment_method == 'cash')
                                    <div class="pt-3 border-t">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Cash Dibayar</span>
                                            <span>Rp {{ number_format($transaction->cash_paid, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Kembalian</span>
                                            <span class="text-green-600">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Tambahkan catatan transaksi...">{{ old('notes', $transaction->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-4 pt-6 border-t">
                            <button type="submit" 
                                    class="flex-1 bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition-colors font-semibold">
                                <i class="fas fa-save mr-2"></i>Update Transaksi
                            </button>
                            
                            @if($transaction->payment_method == 'transfer' && $transaction->status == 'pending')
                            <a href="{{ route('admin.transactions.confirm-payment', $transaction->id) }}" 
                               class="flex-1 bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition-colors font-semibold text-center"
                               onclick="return confirm('Konfirmasi pembayaran transfer?')">
                                <i class="fas fa-check mr-2"></i>Konfirmasi Pembayaran
                            </a>
                            @endif
                            
                            @if($transaction->status != 'cancelled')
                            <a href="{{ route('admin.transactions.cancel', $transaction->id) }}" 
                               class="flex-1 bg-red-500 text-white py-3 rounded-lg hover:bg-red-600 transition-colors font-semibold text-center"
                               onclick="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
                                <i class="fas fa-times mr-2"></i>Batalkan Transaksi
                            </a>
                            @endif
                        </div>
                    </form>

                    <!-- Additional Actions -->
                    <div class="mt-6 pt-6 border-t">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.transactions.print', $transaction->id) }}" 
                               target="_blank"
                               class="flex items-center space-x-2 px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                                <i class="fas fa-print"></i>
                                <span>Print Struk</span>
                            </a>
                            
                            <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Hapus transaksi ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="flex items-center space-x-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus Permanen</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
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
    </script>
</body>
</html>