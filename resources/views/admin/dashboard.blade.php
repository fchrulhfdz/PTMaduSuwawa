@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-br from-honey-50 to-honey-100 text-honey-600 shadow-inner">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div class="ml-5">
                    <h3 class="text-sm font-semibold text-gray-600 tracking-wide">Total Produk</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalProducts }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-database mr-2"></i>
                    <span>Semua produk aktif</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-br from-green-50 to-green-100 text-green-600 shadow-inner">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="ml-5">
                    <h3 class="text-sm font-semibold text-gray-600 tracking-wide">Penjualan Hari Ini</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalSalesToday }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-calendar-day mr-2"></i>
                    <span>Update real-time</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 shadow-inner">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
                <div class="ml-5">
                    <h3 class="text-sm font-semibold text-gray-600 tracking-wide">Pendapatan Hari Ini</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-chart-line mr-2"></i>
                    <span>Pendapatan kotor</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Transaksi Terbaru</h2>
                    <p class="text-sm text-gray-600 mt-1">Riwayat transaksi terkini</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-honey-100 text-honey-800">
                        <i class="fas fa-clock mr-1"></i>
                        Hari Ini
                    </span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/80 backdrop-blur-sm">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-cube text-gray-400"></i>
                                <span>Produk</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-layer-group text-gray-400"></i>
                                <span>Quantity</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-money-bill text-gray-400"></i>
                                <span>Total Harga</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-calendar text-gray-400"></i>
                                <span>Tanggal</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentTransactions as $transaction)
                    <tr class="hover:bg-gray-50/80 transition-colors duration-200 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-honey-100 to-honey-200 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-honey-pot text-honey-600 text-sm"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900 group-hover:text-honey-700 transition-colors">
                                        {{ $transaction->product->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $transaction->product->category }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 bg-gray-100 px-3 py-1 rounded-full inline-flex items-center">
                                <i class="fas fa-hashtag text-gray-400 text-xs mr-1"></i>
                                {{ $transaction->quantity }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600 bg-blue-50 px-3 py-1 rounded-full inline-flex items-center">
                                <i class="fas fa-calendar-day text-blue-400 text-xs mr-2"></i>
                                {{ $transaction->date->format('d/m/Y') }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-shopping-cart text-4xl mb-3"></i>
                                <p class="text-lg font-medium text-gray-500">Tidak ada transaksi hari ini.</p>
                                <p class="text-sm text-gray-400 mt-1">Transaksi yang dilakukan akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentTransactions->count() > 0)
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-info-circle text-blue-400"></i>
                    <span>Menampilkan {{ $recentTransactions->count() }} transaksi terbaru</span>
                </div>
                <a href="{{ route('admin.transactions.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-honey-50 text-honey-700 rounded-lg hover:bg-honey-100 transition-colors duration-200 font-medium">
                    <i class="fas fa-list mr-2"></i>
                    Lihat Semua Transaksi
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.transactions.create') }}" 
           class="bg-white rounded-xl shadow-lg p-5 border border-gray-100 hover:shadow-xl transition-all duration-300 group cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="p-3 rounded-xl bg-gradient-to-br from-green-50 to-green-100 text-green-600 group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-plus text-lg"></i>
                </div>
                <i class="fas fa-chevron-right text-gray-300 group-hover:text-green-500 transition-colors"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mt-3 group-hover:text-green-600 transition-colors">Transaksi Baru</h3>
            <p class="text-sm text-gray-500 mt-1">Buat transaksi penjualan baru</p>
        </a>

        <a href="{{ route('admin.products.index') }}" 
           class="bg-white rounded-xl shadow-lg p-5 border border-gray-100 hover:shadow-xl transition-all duration-300 group cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="p-3 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-boxes text-lg"></i>
                </div>
                <i class="fas fa-chevron-right text-gray-300 group-hover:text-blue-500 transition-colors"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mt-3 group-hover:text-blue-600 transition-colors">Kelola Produk</h3>
            <p class="text-sm text-gray-500 mt-1">Lihat dan kelola produk</p>
        </a>

        <a href="{{ route('admin.reports.index') }}" 
           class="bg-white rounded-xl shadow-lg p-5 border border-gray-100 hover:shadow-xl transition-all duration-300 group cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="p-3 rounded-xl bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600 group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-chart-bar text-lg"></i>
                </div>
                <i class="fas fa-chevron-right text-gray-300 group-hover:text-purple-500 transition-colors"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mt-3 group-hover:text-purple-600 transition-colors">Laporan</h3>
            <p class="text-sm text-gray-500 mt-1">Analisis penjualan</p>
        </a>

        <a href="{{ route('admin.settings.index') }}" 
           class="bg-white rounded-xl shadow-lg p-5 border border-gray-100 hover:shadow-xl transition-all duration-300 group cursor-pointer">
            <div class="flex items-center justify-between">
                <div class="p-3 rounded-xl bg-gradient-to-br from-orange-50 to-orange-100 text-orange-600 group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-cog text-lg"></i>
                </div>
                <i class="fas fa-chevron-right text-gray-300 group-hover:text-orange-500 transition-colors"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mt-3 group-hover:text-orange-600 transition-colors">Pengaturan</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola sistem</p>
        </a>
    </div>
</div>
@endsection