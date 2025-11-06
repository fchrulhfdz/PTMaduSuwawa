@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Smart Cashier')
@section('subtitle', 'Analisis lengkap data transaksi dan penjualan')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Laporan Transaksi</h1>
            <p class="mt-2 text-sm text-gray-600">Analisis lengkap data transaksi dan penjualan</p>
        </div>
        <!-- Tombol cetak di header dihapus -->
    </div>

    <!-- Filter Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 p-8">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm transition-all duration-200">
            </div>
            <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm transition-all duration-200">
            </div>
            <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">Kategori</label>
                <select name="category" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm transition-all duration-200">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-lg text-emerald-500"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-r from-amber-500 to-yellow-500 text-white shadow-lg">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Produk Terjual</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalProductsSold ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg">
                    <i class="fas fa-cubes text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Quantity</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalQuantity ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-green-500 text-white shadow-lg">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTransactions ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Detail Laporan Transaksi</h2>
                    <p class="text-sm text-gray-600 mt-1">Rincian lengkap semua transaksi dalam periode yang dipilih</p>
                </div>
                <!-- Tombol cetak di bagian detail laporan -->
                <div class="flex flex-wrap gap-3">
                    <button onclick="exportToWord()" 
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                        <i class="fas fa-file-word mr-2"></i>
                        <span class="font-semibold">Cetak Word</span>
                    </button>
                    <button onclick="exportToExcel()" 
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                        <i class="fas fa-file-excel mr-2"></i>
                        <span class="font-semibold">Cetak Excel</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kode Transaksi</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Produk</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Harga Satuan</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total Harga</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Customer</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($reportData as $item)
                    <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->date->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                            {{ $item->transaction_code }}
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($item->product->image)
                                        <img class="h-10 w-10 rounded-xl object-cover shadow-sm" 
                                             src="{{ asset('storage/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-sm">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $item->product_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-800 border border-amber-200">
                                {{ $item->product_category }}
                            </span>
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            Rp {{ number_format($item->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                            {{ $item->customer_name ?? 'Walk-in Customer' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p class="text-lg font-medium">Tidak ada data laporan</p>
                                <p class="text-sm mt-1">Coba ubah filter pencarian Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="px-8 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function exportToWord() {
    // Membuat konten untuk Word
    const content = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word">
        <head>
            <meta charset="UTF-8">
            <title>Laporan Transaksi - {{ config('app.name') }}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 2px solid #333; }
                .summary { display: table; width: 100%; margin-bottom: 20px; border-collapse: collapse; }
                .summary-card { display: table-cell; border: 1px solid #ddd; padding: 15px; text-align: center; vertical-align: middle; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 11px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; font-weight: bold; }
                .total-row { font-weight: bold; background-color: #f9f9f9; }
                .category-summary { margin: 15px 0; padding: 10px; background: #f8f9fa; border: 1px solid #ddd; }
                .category-item { display: inline-block; margin: 3px 8px 3px 0; padding: 3px 8px; background: #e9ecef; border-radius: 3px; font-size: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1 style="font-size: 24px; font-weight: bold; color: #1f2937; margin-bottom: 8px;">Laporan Transaksi</h1>
                <p style="color: #6b7280; margin: 3px 0;">Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Semua' }} - 
                          {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Semua' }}</p>
                <p style="color: #6b7280; margin: 3px 0;">Kategori: {{ request('category') ?: 'Semua Kategori' }}</p>
                <p style="color: #6b7280; margin: 3px 0;">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
            </div>

            <div class="summary">
                <div class="summary-card">
                    <strong style="color: #374151;">Total Produk Terjual</strong><br>
                    <span style="font-size: 20px; font-weight: bold; color: #1f2937;">{{ $totalProductsSold }}</span>
                </div>
                <div class="summary-card">
                    <strong style="color: #374151;">Total Transaksi</strong><br>
                    <span style="font-size: 20px; font-weight: bold; color: #1f2937;">{{ $totalTransactions }}</span>
                </div>
                <div class="summary-card">
                    <strong style="color: #374151;">Total Pendapatan</strong><br>
                    <span style="font-size: 20px; font-weight: bold; color: #1f2937;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
                <div class="summary-card">
                    <strong style="color: #374151;">Total Quantity</strong><br>
                    <span style="font-size: 20px; font-weight: bold; color: #1f2937;">{{ $totalQuantity }}</span>
                </div>
            </div>

            @if($categorySummary->count() > 0)
            <div class="category-summary">
                <h3 style="font-size: 14px; font-weight: bold; margin-bottom: 8px;">Ringkasan per Kategori:</h3>
                @foreach($categorySummary as $category)
                <div class="category-item">
                    {{ $category->category }}: {{ $category->total_quantity }} pcs (Rp {{ number_format($category->total_revenue, 0, ',', '.') }})
                </div>
                @endforeach
            </div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Quantity</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Customer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData as $item)
                    <tr>
                        <td>{{ $item->date->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->transaction_code }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->product_category }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        <td>{{ $item->customer_name ?? 'Walk-in Customer' }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="4"><strong>TOTAL</strong></td>
                        <td><strong>{{ $totalQuantity }}</strong></td>
                        <td></td>
                        <td><strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </body>
        </html>
    `;

    // Membuat blob untuk Word
    const blob = new Blob([content], { type: 'application/msword' });
    const url = URL.createObjectURL(blob);
    
    const link = document.createElement('a');
    link.download = 'laporan-transaksi-{{ now()->format("Y-m-d") }}.doc';
    link.href = url;
    link.click();
    
    // Membersihkan URL
    URL.revokeObjectURL(url);
}

function exportToExcel() {
    let table = document.querySelector('table');
    let html = table.outerHTML;
    let url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(`
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">
        <head>
            <meta charset="UTF-8">
            <title>Laporan Transaksi - {{ config('app.name') }}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 2px solid #333; }
                .summary { display: table; width: 100%; margin-bottom: 20px; border-collapse: collapse; }
                .summary-card { display: table-cell; border: 1px solid #ddd; padding: 15px; text-align: center; vertical-align: middle; }
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; font-weight: bold; }
                .total-row { font-weight: bold; background-color: #f9f9f9; }
                .category-summary { margin: 15px 0; padding: 10px; background: #f8f9fa; border: 1px solid #ddd; }
                .category-item { display: inline-block; margin: 3px 8px 3px 0; padding: 3px 8px; background: #e9ecef; border-radius: 3px; font-size: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Laporan Transaksi - {{ config('app.name') }}</h1>
                <p>Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Semua' }} - 
                      {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Semua' }}</p>
                <p>Kategori: {{ request('category') ?: 'Semua Kategori' }}</p>
                <p>Tanggal Export: {{ now()->format('d/m/Y H:i') }}</p>
            </div>

            <div class="summary">
                <div class="summary-card">
                    <strong>Total Produk Terjual</strong><br>
                    <span style="font-size: 18px; font-weight: bold;">{{ $totalProductsSold }}</span>
                </div>
                <div class="summary-card">
                    <strong>Total Transaksi</strong><br>
                    <span style="font-size: 18px; font-weight: bold;">{{ $totalTransactions }}</span>
                </div>
                <div class="summary-card">
                    <strong>Total Pendapatan</strong><br>
                    <span style="font-size: 18px; font-weight: bold;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
                <div class="summary-card">
                    <strong>Total Quantity</strong><br>
                    <span style="font-size: 18px; font-weight: bold;">{{ $totalQuantity }}</span>
                </div>
            </div>

            @if($categorySummary->count() > 0)
            <div class="category-summary">
                <h3 style="font-size: 14px; font-weight: bold;">Ringkasan per Kategori:</h3>
                @foreach($categorySummary as $category)
                <div class="category-item">
                    {{ $category->category }}: {{ $category->total_quantity }} pcs (Rp {{ number_format($category->total_revenue, 0, ',', '.') }})
                </div>
                @endforeach
            </div>
            @endif

            ${html}
        </body>
        </html>
    `);
    
    let link = document.createElement('a');
    link.download = 'laporan-transaksi-{{ now()->format("Y-m-d") }}.xls';
    link.href = url;
    link.click();
}
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-white {
        background: white !important;
        box-shadow: none !important;
    }
}
</style>
@endpush
@endsection