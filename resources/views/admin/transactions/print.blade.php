<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - {{ $transaction->transaction_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans">
    <div class="max-w-xs mx-auto p-4">
        <!-- Header -->
        <div class="text-center border-b border-gray-300 pb-4 mb-4">
            @php
                // Gunakan model Setting langsung
                $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
                $receiptHeader = $settings['receipt_header'] ?? 'SMART CASHIER\nSistem Kasir Pintar';
                $headerLines = explode('\n', $receiptHeader);
                
                // PERBAIKAN: Decode items dari JSON string ke array
                $items = is_string($transaction->items) ? json_decode($transaction->items, true) : $transaction->items;
                if (!is_array($items)) {
                    $items = [];
                }
            @endphp
            @foreach($headerLines as $line)
                @if($loop->first)
                    <h1 class="text-xl font-bold">{{ $line }}</h1>
                @else
                    <p class="text-sm text-gray-600">{{ $line }}</p>
                @endif
            @endforeach
            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Transaction Info -->
        <div class="mb-4">
            <div class="flex justify-between text-sm mb-2">
                <span class="font-medium">Kode Transaksi:</span>
                <span>{{ $transaction->transaction_code }}</span>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span class="font-medium">Customer:</span>
                <span>{{ $transaction->customer_name }}</span>
            </div>
            @if($transaction->customer_phone)
            <div class="flex justify-between text-sm mb-2">
                <span class="font-medium">Telepon:</span>
                <span>{{ $transaction->customer_phone }}</span>
            </div>
            @endif
        </div>

        <!-- Items -->
        <div class="border-t border-b border-gray-300 py-4 mb-4">
            <h2 class="font-bold text-sm mb-2">DAFTAR PRODUK:</h2>
            @foreach($items as $item)
            <div class="flex justify-between text-sm mb-1">
                <div>
                    <span>{{ $item['name'] ?? 'N/A' }}</span>
                    <span class="text-gray-600"> x {{ $item['quantity'] ?? 0 }}</span>
                </div>
                <span>Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="mb-4">
            <div class="flex justify-between text-sm mb-1">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($transaction->tax > 0)
            <div class="flex justify-between text-sm mb-1">
                <span>Pajak:</span>
                <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
            </div>
            @endif
            @if($transaction->discount > 0)
            <div class="flex justify-between text-sm mb-1">
                <span>Diskon:</span>
                <span>- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between font-bold text-base mt-2 pt-2 border-t border-gray-300">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="border-t border-gray-300 pt-4 mb-4">
            <div class="flex justify-between text-sm mb-1">
                <span>Metode Bayar:</span>
                <span class="font-medium">{{ strtoupper($transaction->payment_method) }}</span>
            </div>
            @if($transaction->payment_method === 'cash')
            <div class="flex justify-between text-sm mb-1">
                <span>Uang Diberikan:</span>
                <span>Rp {{ number_format($transaction->cash_paid, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm mb-1">
                <span>Kembalian:</span>
                <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="text-center border-t border-gray-300 pt-4">
            @php
                $receiptFooter = $settings['receipt_footer'] ?? 'Terima kasih atas kunjungan Anda\n*** Struk ini sebagai bukti pembayaran ***';
                $footerLines = explode('\n', $receiptFooter);
            @endphp
            @foreach($footerLines as $line)
                <p class="text-xs text-gray-600">{{ $line }}</p>
            @endforeach
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
            
            // Redirect back after print (optional)
            window.onafterprint = function() {
                setTimeout(function() {
                    window.close();
                }, 1000);
            };
        }
    </script>
</body>
</html>