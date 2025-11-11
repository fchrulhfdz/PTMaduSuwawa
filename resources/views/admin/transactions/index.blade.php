<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi - Smart Cashier</title>
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
                        <p class="text-blue-100">Sistem Kasir Pintar</p>
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
                    <a href="javascript:history.back()" 
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
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Transaksi Hari Ini</p>
                            <h3 class="text-2xl font-bold text-gray-800">
                                {{ $todayStats->total_transactions ?? 0 }}
                            </h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-shopping-cart text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Pendapatan Hari Ini</p>
                            <h3 class="text-2xl font-bold text-gray-800">
                                Rp {{ number_format($todayStats->total_revenue ?? 0, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-money-bill-wave text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Rata-rata Transaksi</p>
                            <h3 class="text-2xl font-bold text-gray-800">
                                Rp {{ number_format($todayStats->average_transaction ?? 0, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="fas fa-chart-line text-purple-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Berat Hari Ini</p>
                            <h3 class="text-2xl font-bold text-gray-800">
                                @php
                                    $totalBerat = $todayStats->total_berat ?? 0;
                                    if ($totalBerat >= 1000) {
                                        echo number_format($totalBerat / 1000, 2) . ' kg';
                                    } else {
                                        echo number_format($totalBerat, 0) . ' g';
                                    }
                                @endphp
                            </h3>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-full">
                            <i class="fas fa-weight text-orange-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Daftar Transaksi Terbaru</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items & Berat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaction->transaction_code }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaction->customer_name }}</div>
                                    @if($transaction->customer_phone)
                                    <div class="text-sm text-gray-500">{{ $transaction->customer_phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @php
                                            $items = $transaction->items_array;
                                            $itemCount = 0;
                                            $itemNames = [];
                                            
                                            if (is_array($items) && count($items) > 0) {
                                                foreach($items as $item) {
                                                    $quantity = $item['quantity'] ?? 0;
                                                    $name = $item['name'] ?? 'Produk';
                                                    $itemCount += $quantity;
                                                    $itemNames[] = $name;
                                                }
                                                
                                                echo count($items) . ' item (' . $itemCount . ' pcs)';
                                                echo '<div class="text-xs text-gray-500 mt-1">';
                                                echo implode(', ', array_slice($itemNames, 0, 2));
                                                if (count($itemNames) > 2) {
                                                    echo ' ... dan ' . (count($itemNames) - 2) . ' lainnya';
                                                }
                                                echo '</div>';
                                                
                                                // Tampilkan total berat dengan konversi otomatis
                                                if ($transaction->total_berat > 0) {
                                                    echo '<div class="text-xs text-blue-600 mt-1">';
                                                    echo '<i class="fas fa-weight mr-1"></i>';
                                                    // Konversi otomatis gram ke kg jika >= 1000
                                                    if ($transaction->total_berat >= 1000) {
                                                        echo number_format($transaction->total_berat / 1000, 2) . ' kg';
                                                    } else {
                                                        echo number_format($transaction->total_berat, 0) . ' g';
                                                    }
                                                    echo '</div>';
                                                }
                                            } else {
                                                echo '<span class="text-gray-400">Tidak ada item</span>';
                                            }
                                        @endphp
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">
                                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        {{ strtoupper($transaction->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-800' : 
                                           'bg-blue-100 text-blue-800' }}">
                                        {{ strtoupper($transaction->payment_method) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.transactions.edit', $transaction->id) }}" 
                                           class="text-blue-600 hover:text-blue-900"
                                           title="Edit Transaksi">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.transactions.print', $transaction->id) }}" 
                                           target="_blank"
                                           class="text-green-600 hover:text-green-900"
                                           title="Print Struk">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        
                                        <!-- Untuk Confirm Payment -->
@if($transaction->payment_method == 'transfer' && $transaction->status == 'pending')
<a href="{{ route('admin.transactions.confirm-payment', $transaction->id) }}" 
   class="text-purple-600 hover:text-purple-900"
   title="Konfirmasi Pembayaran"
   onclick="return confirm('Konfirmasi pembayaran transfer?')">
    <i class="fas fa-check-circle"></i>
</a>
@endif

<!-- Untuk Cancel Transaction -->
@if($transaction->status != 'cancelled')
<a href="{{ route('admin.transactions.cancel', $transaction->id) }}" 
   class="text-orange-600 hover:text-orange-900"
   title="Batalkan Transaksi"
   onclick="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
    <i class="fas fa-times-circle"></i>
</a>
@endif
                                        
                                        <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Hapus transaksi ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus Permanen">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                    Belum ada transaksi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($transactions->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $transactions->links() }}
                </div>
                @endif
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

        // Alert untuk success/error messages
        @if(session('success'))
            alert('{{ session('success') }}');
        @endif

        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
    </script>
</body>
</html>