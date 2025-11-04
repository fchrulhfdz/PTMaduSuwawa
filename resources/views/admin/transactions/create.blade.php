<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - {{ $setting->store_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 print:bg-white">
    <div class="min-h-screen flex items-center justify-center p-4 print:p-0">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl print:shadow-none overflow-hidden border border-gray-200/60 print:border-0">
            <!-- Header dengan gradient -->
            <div class="bg-gradient-to-r from-amber-500 to-amber-400 text-white p-6 text-center">
                @if($setting->logo)
                <div class="w-20 h-20 mx-auto mb-3 bg-white rounded-2xl p-2 shadow-lg">
                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                @else
                <div class="w-16 h-16 mx-auto mb-3 bg-white/20 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-store text-2xl"></i>
                </div>
                @endif
                <h1 class="text-2xl font-bold tracking-tight">{{ $setting->store_name }}</h1>
                <p class="text-amber-100 text-sm mt-1 whitespace-pre-line">{{ $setting->address }}</p>
                <div class="flex items-center justify-center space-x-4 mt-3 text-amber-100 text-sm">
                    <span><i class="fas fa-calendar mr-1"></i>{{ $sale->created_at->format('d/m/Y') }}</span>
                    <span><i class="fas fa-clock mr-1"></i>{{ $sale->created_at->format('H:i') }}</span>
                </div>
            </div>

            <!-- Transaction Info -->
            <div class="p-6 bg-gradient-to-br from-gray-50 to-white">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                        <div class="text-xs text-gray-500 font-medium mb-1">No. Transaksi</div>
                        <div class="text-sm font-mono font-bold text-gray-800">#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                        <div class="text-xs text-gray-500 font-medium mb-1">Kasir</div>
                        <div class="text-sm font-semibold text-gray-800">{{ $sale->user->name }}</div>
                    </div>
                </div>

                <!-- Items List -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Detail Pembelian</h3>
                        <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-basket text-amber-600 text-sm"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($sale->items as $item)
                        <div class="flex items-center justify-between p-3 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                            <div class="flex-1">
                                <div class="font-medium text-gray-800">{{ $item->product->name }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <span class="font-mono">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $item->qty }} pcs</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-mono font-semibold text-gray-800">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Totals -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-5 border border-gray-200">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Subtotal</span>
                            <span class="font-mono text-gray-800">Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Bayar</span>
                            <span class="font-mono text-green-600 font-semibold">Rp {{ number_format($sale->payment, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600 font-medium">Kembali</span>
                            <span class="font-mono text-blue-600 font-bold">Rp {{ number_format($sale->change, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <!-- Grand Total -->
                    <div class="mt-4 pt-4 border-t border-gray-300 border-dashed">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-800">TOTAL</span>
                            <span class="text-xl font-mono font-bold text-amber-600">Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="mt-4 flex justify-center">
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold flex items-center space-x-2">
                        <i class="fas fa-check-circle"></i>
                        <span>Pembayaran Berhasil</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white p-6 text-center">
                <div class="space-y-3">
                    @if($setting->footer_text)
                    <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-line">{{ $setting->footer_text }}</p>
                    @endif
                    <div class="flex items-center justify-center space-x-4 text-gray-400 text-sm">
                        <span><i class="fas fa-phone mr-1"></i>{{ $setting->phone ?? '- '}}</span>
                        <span><i class="fas fa-envelope mr-1"></i>{{ $setting->email ?? '-' }}</span>
                    </div>
                    <p class="text-amber-300 font-semibold mt-3 flex items-center justify-center space-x-2">
                        <i class="fas fa-heart"></i>
                        <span>Terima kasih atas kunjungan Anda</span>
                    </p>
                </div>
                
                <!-- Barcode/QR Code Placeholder -->
                <div class="mt-4 pt-4 border-t border-gray-700">
                    <div class="bg-white/10 rounded-lg p-3 inline-block">
                        <div class="text-xs text-gray-400 mb-1">Struk Digital</div>
                        <div class="w-32 h-32 bg-white/20 rounded flex items-center justify-center mx-auto">
                            <i class="fas fa-qrcode text-3xl text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 print:hidden">
        <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-200/60 p-4 flex space-x-3">
            <button onclick="window.print()" 
                    class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2 font-semibold">
                <i class="fas fa-print"></i>
                <span>Cetak Struk</span>
            </button>
            <a href="{{ route('admin.transactions.index') }}" 
               class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-3 rounded-xl hover:from-gray-600 hover:to-gray-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2 font-semibold">
                <i class="fas fa-plus"></i>
                <span>Transaksi Baru</span>
            </a>
            <button onclick="downloadReceipt()" 
                    class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2 font-semibold">
                <i class="fas fa-download"></i>
                <span>Download</span>
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        };

        function downloadReceipt() {
            // Implement download functionality
            alert('Fitur download struk akan diimplementasikan');
        }

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const receipt = document.querySelector('.max-w-md');
            receipt.classList.add('animate-fade-in-up');
        });
    </script>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out;
        }

        @media print {
            .max-w-md {
                margin: 0;
                box-shadow: none;
                border-radius: 0;
                max-width: none;
            }
            body {
                background: white;
            }
            .fixed {
                display: none;
            }
        }
    </style>
</body>
</html>