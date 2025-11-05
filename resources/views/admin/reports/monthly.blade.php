@extends('layouts.admin')

@section('title', 'Laporan Bulanan - Smart Cashier')
@section('subtitle', 'Analisis performa penjualan bulanan dan tren')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Laporan Bulanan</h1>
            <p class="mt-2 text-sm text-gray-600">Analisis performa penjualan bulanan dan tren</p>
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
        <form action="{{ route('admin.reports.monthly') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700 tracking-wide">Bulan dan Tahun</label>
                <input type="month" 
                       name="month" 
                       value="{{ $month }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm transition-all duration-200">
            </div>
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
            <div class="flex items-end">
                <a href="{{ route('admin.reports.monthly', ['month' => now()->format('Y-m')]) }}" 
                   class="w-full px-4 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 text-center">
                    <i class="fas fa-sync mr-2"></i>Bulan Ini
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
                    <p class="text-sm font-medium text-gray-600">Total Produk Terjual</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalProducts ?? 0 }}</p>
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

    <!-- Chart Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Daily Revenue Chart -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-chart-line mr-3 text-blue-500"></i>
                Tren Pendapatan Harian
            </h3>
            <div class="h-80">
                <canvas id="dailyRevenueChart"></canvas>
            </div>
        </div>

        <!-- Product Sales Chart -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-chart-bar mr-3 text-amber-500"></i>
                Penjualan per Produk
            </h3>
            <div class="h-80">
                <canvas id="productSalesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-xl font-bold text-gray-900">
                Detail Transaksi - {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">Rincian lengkap semua transaksi bulanan</p>
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
                            {{ $item->date->format('d/m/Y') }}
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
                                <p class="text-lg font-medium">Tidak ada transaksi</p>
                                <p class="text-sm mt-1">Belum ada transaksi pada bulan ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if(count($reportData) > 0)
                <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <td colspan="4" class="px-8 py-4 text-sm font-bold text-gray-900 text-right">
                            TOTAL BULANAN:
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
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function printReport() {
    const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Laporan Bulanan - {{ config('app.name') }}</title>
            <style>
                body { font-family: 'Segoe UI', Arial, sans-serif; margin: 30px; background: white; }
                .header { text-align: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 2px solid #e5e7eb; }
                .summary { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
                .summary-card { border: 1px solid #e5e7eb; padding: 20px; border-radius: 12px; text-align: center; background: #f9fafb; }
                table { width: 100%; border-collapse: collapse; margin-top: 25px; font-size: 12px; }
                th, td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; }
                th { background-color: #f3f4f6; font-weight: 600; }
                .total-row { font-weight: bold; background-color: #f9fafb; }
                .footer { margin-top: 30px; text-align: right; font-style: italic; color: #6b7280; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;">Laporan Bulanan Transaksi</h1>
                <h2 style="font-size: 18px; color: #374151; margin: 5px 0;">Periode: {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</h2>
                <p style="color: #6b7280; margin: 5px 0;">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
            </div>

            <div class="summary">
                <div class="summary-card">
                    <strong style="color: #374151;">Total Produk Terjual</strong><br>
                    <span style="font-size: 24px; font-weight: bold; color: #1f2937;">{{ $totalProducts }}</span>
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
                        <td>{{ $item->date->format('d/m/Y') }}</td>
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
            <title>Laporan Bulanan - {{ config('app.name') }}</title>
        </head>
        <body>
            <h1>Laporan Bulanan Transaksi</h1>
            <h2>Periode: {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</h2>
            <p>Tanggal Export: {{ now()->format('d/m/Y H:i') }}</p>
            ${html}
        </body>
        </html>
    `);
    
    let link = document.createElement('a');
    link.download = 'laporan-bulanan-{{ $month }}.xls';
    link.href = url;
    link.click();
}

// Chart.js Implementation
document.addEventListener('DOMContentLoaded', function() {
    // Daily Revenue Chart
    const dailyRevenueCtx = document.getElementById('dailyRevenueChart').getContext('2d');
    
    const dailyRevenueData = {
        labels: {!! json_encode($dailyRevenueChart->pluck('date')) !!},
        datasets: [{
            label: 'Pendapatan Harian',
            data: {!! json_encode($dailyRevenueChart->pluck('revenue')) !!},
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    };

    new Chart(dailyRevenueCtx, {
        type: 'line',
        data: dailyRevenueData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 12,
                            family: "'Inter', sans-serif"
                        },
                        color: '#374151'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1f2937',
                    bodyColor: '#374151',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(243, 244, 246, 0.8)'
                    },
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif"
                        },
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif"
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear'
                }
            }
        }
    });

    // Product Sales Chart
    const productSalesCtx = document.getElementById('productSalesChart').getContext('2d');
    
    const productSalesData = {
        labels: {!! json_encode($productSalesChart->pluck('product_name')) !!},
        datasets: [{
            label: 'Quantity Terjual',
            data: {!! json_encode($productSalesChart->pluck('total_quantity')) !!},
            backgroundColor: [
                'rgba(245, 158, 11, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(249, 115, 22, 0.8)',
                'rgba(139, 92, 246, 0.8)',
                'rgba(236, 72, 153, 0.8)',
                'rgba(14, 165, 233, 0.8)'
            ],
            borderColor: [
                'rgb(245, 158, 11)',
                'rgb(16, 185, 129)',
                'rgb(59, 130, 246)',
                'rgb(249, 115, 22)',
                'rgb(139, 92, 246)',
                'rgb(236, 72, 153)',
                'rgb(14, 165, 233)'
            ],
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    };

    new Chart(productSalesCtx, {
        type: 'bar',
        data: productSalesData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1f2937',
                    bodyColor: '#374151',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(243, 244, 246, 0.8)'
                    },
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif"
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif"
                        }
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
});
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

/* Custom scrollbar for better appearance */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endpush
@endsection