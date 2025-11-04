@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Laporan Harian</h1>
            <p class="mt-2 text-sm text-gray-600">Analisis performa penjualan harian</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="printReport()" 
                    class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                <i class="fas fa-print mr-3 text-lg"></i>
                <span class="font-semibold">Cetak Laporan</span>
            </button>
            <button onclick="exportToExcel()" 
                    class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                <i class="fas fa-file-excel mr-3 text-lg"></i>
                <span class="font-semibold">Export Excel</span>
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 p-8">
        <form action="{{ route('admin.reports.daily') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">Tanggal</label>
                <input type="date" 
                       name="date" 
                       value="{{ $date }}"
                       max="{{ now()->format('Y-m-d') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-honey-500 focus:border-transparent shadow-sm transition-all duration-200">
            </div>
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full px-4 py-3 bg-gradient-to-r from-honey-500 to-honey-600 hover:from-honey-600 hover:to-honey-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
            <div class="flex items-end">
                <a href="{{ route('admin.reports.daily', ['date' => now()->format('Y-m-d')]) }}" 
                   class="w-full px-4 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 text-center">
                    <i class="fas fa-calendar-day mr-2"></i>Hari Ini
                </a>
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
                    <p class="text-sm font-medium text-gray-600">Produk Terjual</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $transactions->unique('product_id')->count() }}</p>
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
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $transactions->count() }}</p>
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
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
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
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalQuantity }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Products -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-trophy mr-3 text-amber-500"></i>
                Produk Terlaris Hari Ini
            </h3>
            <div class="space-y-4">
                @forelse($topProducts as $product)
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12">
                            @if($product->product->image)
                                <img class="h-12 w-12 rounded-xl object-cover shadow-sm" 
                                     src="{{ asset('storage/' . $product->product->image) }}" 
                                     alt="{{ $product->product->name }}">
                            @else
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-sm">
                                    <i class="fas fa-honey-pot text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $product->product->name }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $product->product->category }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-bold text-amber-600">{{ $product->total_quantity }} terjual</div>
                        <div class="text-xs font-medium text-gray-500 mt-1">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-chart-bar text-3xl mb-3"></i>
                    <p class="font-medium">Tidak ada data penjualan</p>
                    <p class="text-sm mt-1">Belum ada transaksi hari ini</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Sales by Hour -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-clock mr-3 text-blue-500"></i>
                Transaksi per Jam
            </h3>
            <div class="space-y-4">
                @forelse($salesByHour as $hour)
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700 w-16">{{ $hour->hour }}:00</span>
                    <div class="flex items-center space-x-3 flex-1 max-w-md">
                        <div class="flex-1 bg-gray-200 rounded-full h-3 shadow-inner">
                            <div class="bg-gradient-to-r from-honey-500 to-amber-500 h-3 rounded-full shadow-sm" 
                                 style="width: {{ ($hour->transaction_count / max($salesByHour->max('transaction_count'), 1)) * 100 }}%">
                            </div>
                        </div>
                        <span class="text-sm font-bold text-gray-900 w-8 text-right">{{ $hour->transaction_count }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-chart-line text-3xl mb-3"></i>
                    <p class="font-medium">Tidak ada data transaksi</p>
                    <p class="text-sm mt-1">Belum ada transaksi per jam</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-xl font-bold text-gray-900">
                Detail Transaksi - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">Rincian lengkap semua transaksi harian</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Waktu</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Produk</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Quantity</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Harga Satuan</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total Harga</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kasir</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $transaction->created_at->format('H:i') }}
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($transaction->product->image)
                                        <img class="h-10 w-10 rounded-xl object-cover shadow-sm" 
                                             src="{{ asset('storage/' . $transaction->product->image) }}" 
                                             alt="{{ $transaction->product->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-sm">
                                            <i class="fas fa-honey-pot text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $transaction->product->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-800 border border-amber-200">
                                {{ $transaction->product->category }}
                            </span>
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            {{ $transaction->quantity }}
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rp {{ number_format($transaction->product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                            {{ $transaction->user->name }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p class="text-lg font-medium">Tidak ada transaksi</p>
                                <p class="text-sm mt-1">Belum ada transaksi pada tanggal ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($transactions->count() > 0)
                <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <td colspan="3" class="px-8 py-4 text-sm font-bold text-gray-900 text-right">
                            TOTAL HARIAN:
                        </td>
                        <td class="px-8 py-4 text-sm font-bold text-gray-900">
                            {{ $totalQuantity }}
                        </td>
                        <td class="px-8 py-4 text-sm font-bold text-gray-900">-</td>
                        <td class="px-8 py-4 text-sm font-bold text-gray-900">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-4"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Daily Comparison -->
    @if($previousDayData)
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-chart-line mr-3 text-purple-500"></i>
            Perbandingan dengan Hari Sebelumnya
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-gradient-to-br from-white to-gray-50 rounded-2xl border border-gray-100">
                <div class="text-3xl font-bold text-gray-900">{{ $transactions->count() }}</div>
                <div class="text-sm font-medium text-gray-600 mt-2">Transaksi Hari Ini</div>
                <div class="text-sm font-semibold mt-2 {{ $transactions->count() > $previousDayData['transaction_count'] ? 'text-emerald-600' : ($transactions->count() < $previousDayData['transaction_count'] ? 'text-red-600' : 'text-gray-600') }}">
                    @if($previousDayData['transaction_count'] > 0)
                        {{ $transactions->count() > $previousDayData['transaction_count'] ? '↑' : '↓' }}
                        {{ abs(round((($transactions->count() - $previousDayData['transaction_count']) / $previousDayData['transaction_count']) * 100, 1)) }}%
                    @else
                        <span class="text-blue-600">Baru</span>
                    @endif
                </div>
            </div>
            <div class="text-center p-6 bg-gradient-to-br from-white to-gray-50 rounded-2xl border border-gray-100">
                <div class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="text-sm font-medium text-gray-600 mt-2">Pendapatan Hari Ini</div>
                <div class="text-sm font-semibold mt-2 {{ $totalRevenue > $previousDayData['revenue'] ? 'text-emerald-600' : ($totalRevenue < $previousDayData['revenue'] ? 'text-red-600' : 'text-gray-600') }}">
                    @if($previousDayData['revenue'] > 0)
                        {{ $totalRevenue > $previousDayData['revenue'] ? '↑' : '↓' }}
                        {{ abs(round((($totalRevenue - $previousDayData['revenue']) / $previousDayData['revenue']) * 100, 1)) }}%
                    @else
                        <span class="text-blue-600">Baru</span>
                    @endif
                </div>
            </div>
            <div class="text-center p-6 bg-gradient-to-br from-white to-gray-50 rounded-2xl border border-gray-100">
                <div class="text-3xl font-bold text-gray-900">{{ $totalQuantity }}</div>
                <div class="text-sm font-medium text-gray-600 mt-2">Quantity Hari Ini</div>
                <div class="text-sm font-semibold mt-2 {{ $totalQuantity > $previousDayData['quantity'] ? 'text-emerald-600' : ($totalQuantity < $previousDayData['quantity'] ? 'text-red-600' : 'text-gray-600') }}">
                    @if($previousDayData['quantity'] > 0)
                        {{ $totalQuantity > $previousDayData['quantity'] ? '↑' : '↓' }}
                        {{ abs(round((($totalQuantity - $previousDayData['quantity']) / $previousDayData['quantity']) * 100, 1)) }}%
                    @else
                        <span class="text-blue-600">Baru</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function printReport() {
    const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Laporan Harian - {{ config('app.name') }}</title>
            <style>
                body { font-family: 'Segoe UI', Arial, sans-serif; margin: 30px; background: white; }
                .header { text-align: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 2px solid #e5e7eb; }
                .summary { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
                .summary-card { border: 1px solid #e5e7eb; padding: 20px; border-radius: 12px; text-align: center; background: #f9fafb; }
                table { width: 100%; border-collapse: collapse; margin-top: 25px; font-size: 14px; }
                th, td { border: 1px solid #e5e7eb; padding: 12px; text-align: left; }
                th { background-color: #f3f4f6; font-weight: 600; }
                .total-row { font-weight: bold; background-color: #f9fafb; }
                .footer { margin-top: 30px; text-align: right; font-style: italic; color: #6b7280; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;">Laporan Harian Transaksi</h1>
                <h2 style="font-size: 18px; color: #374151; margin: 5px 0;">Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</h2>
                <p style="color: #6b7280; margin: 5px 0;">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
            </div>

            <div class="summary">
                <div class="summary-card">
                    <strong style="color: #374151;">Produk Terjual</strong><br>
                    <span style="font-size: 24px; font-weight: bold; color: #1f2937;">{{ $transactions->unique('product_id')->count() }}</span>
                </div>
                <div class="summary-card">
                    <strong style="color: #374151;">Total Transaksi</strong><br>
                    <span style="font-size: 24px; font-weight: bold; color: #1f2937;">{{ $transactions->count() }}</span>
                </div>
                <div class="summary-card">
                    <strong style="color: #374151;">Total Pendapatan</strong><br>
                    <span style="font-size: 24px; font-weight: bold; color: #1f2937;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
                <div class="summary-card">
                    <strong style="color: #374151;">Total Quantity</strong><br>
                    <span style="font-size: 24px; font-weight: bold; color: #1f2937;">{{ $totalQuantity }}</span>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Quantity</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Kasir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('H:i') }}</td>
                        <td>{{ $transaction->product->name }}</td>
                        <td>{{ $transaction->product->category }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>Rp {{ number_format($transaction->product->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td>{{ $transaction->user->name }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3"><strong>TOTAL HARIAN</strong></td>
                        <td><strong>{{ $totalQuantity }}</strong></td>
                        <td></td>
                        <td><strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <div class="footer">
                <p>Laporan dihasilkan oleh Sistem {{ config('app.name') }}</p>
            </div>
        </body>
        </html>
    `;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
}

function exportToExcel() {
    let table = document.querySelector('table');
    let html = table.outerHTML;
    let url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(`
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">
        <head>
            <meta charset="UTF-8">
            <title>Laporan Harian - {{ config('app.name') }}</title>
        </head>
        <body>
            <h1>Laporan Harian Transaksi</h1>
            <h2>Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</h2>
            <p>Tanggal Export: {{ now()->format('d/m/Y H:i') }}</p>
            ${html}
        </body>
        </html>
    `);
    
    let link = document.createElement('a');
    link.download = 'laporan-harian-{{ $date }}.xls';
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
@endsection