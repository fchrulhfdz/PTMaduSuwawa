@extends('layouts.admin')

@section('title', 'Dashboard - Smart Cashier')
@section('subtitle', 'Dashboard Sistem Kasir Pintar')

@section('content')
<div class="space-y-8">
    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Revenue -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pendapatan Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">
                        Rp {{ number_format($todayStats->total_revenue ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-2xl shadow-lg">
                    <i class="fas fa-money-bill-wave text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Today's Transactions -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Transaksi Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $todayStats->total_transactions ?? 0 }}
                    </h3>
                </div>
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 rounded-2xl shadow-lg">
                    <i class="fas fa-shopping-cart text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Produk</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $productStats->total_products ?? 0 }}
                    </h3>
                </div>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 rounded-2xl shadow-lg">
                    <i class="fas fa-box text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Out of Stock -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Stok Habis</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $productStats->out_of_stock ?? 0 }}
                    </h3>
                </div>
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-4 rounded-2xl shadow-lg">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Transactions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-clock mr-3 text-blue-500"></i>
                        Transaksi Terbaru
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentTransactions as $transaction)
                        <div class="flex items-center justify-between p-4 bg-gray-50/80 rounded-xl border border-gray-200/60 hover:bg-gray-100/50 transition-colors">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-receipt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $transaction->transaction_code }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $transaction->customer_name }} • {{ $transaction->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-green-600">
                                    {{ $transaction->formatted_total }}
                                </p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                    {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-800 border border-green-200' : 
                                       ($transaction->payment_method === 'qris' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 
                                       'bg-purple-100 text-purple-800 border border-purple-200') }}">
                                    {{ strtoupper(str_replace('_', ' ', $transaction->payment_method)) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-inbox text-5xl mb-4"></i>
                                <p class="text-lg font-medium text-gray-500">Belum ada transaksi</p>
                                <p class="text-sm mt-1">Transaksi yang dilakukan akan muncul di sini</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    
                    @if($recentTransactions->count() > 0)
                    <div class="mt-6 text-center">
                        <a href="{{ route('admin.transactions.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                            <i class="fas fa-list mr-2"></i>
                            Lihat Semua Transaksi
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Low Stock Products -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3 text-amber-500"></i>
                        Produk Stok Sedikit
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @forelse($lowStockProducts as $product)
                        <div class="flex items-center justify-between p-4 bg-amber-50/80 border border-amber-200/60 rounded-xl hover:bg-amber-100/50 transition-colors">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-box text-white text-sm"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $product->name }}</p>
                                    <p class="text-sm text-amber-600 font-medium mt-1">Stok: {{ $product->stock }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200 rounded-full">
                                Stok Rendah
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-check-circle text-5xl mb-4 text-green-500"></i>
                                <p class="text-lg font-medium text-gray-500">Semua stok produk aman</p>
                                <p class="text-sm mt-1">Tidak ada produk dengan stok rendah</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    
                    @if($lowStockProducts->count() > 0)
                    <div class="mt-6 text-center">
                        <a href="{{ route('admin.products.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                            <i class="fas fa-box mr-2"></i>
                            Kelola Produk
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Monthly Summary -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-calendar-alt mr-3 text-purple-500"></i>
                    Ringkasan Bulan Ini
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl border border-purple-200/60">
                        <div class="flex items-center">
                            <i class="fas fa-shopping-cart text-purple-500 mr-3"></i>
                            <span class="text-sm font-medium text-purple-800">Total Transaksi</span>
                        </div>
                        <span class="text-xl font-bold text-purple-600">
                            {{ $monthlyStats->total_transactions ?? 0 }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200/60">
                        <div class="flex items-center">
                            <i class="fas fa-money-bill-wave text-green-500 mr-3"></i>
                            <span class="text-sm font-medium text-green-800">Pendapatan Bulanan</span>
                        </div>
                        <span class="text-xl font-bold text-green-600">
                            Rp {{ number_format($monthlyStats->total_revenue ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-bolt mr-3 text-orange-500"></i>
                    Aksi Cepat
                </h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.transactions.create') }}" 
                       class="group flex items-center justify-between w-full p-4 bg-gradient-to-r from-green-50 to-green-100 border border-green-200/60 rounded-xl hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg mr-3">
                                <i class="fas fa-plus-circle text-white text-sm"></i>
                            </div>
                            <span class="font-medium text-green-800 group-hover:text-green-900">Transaksi Baru</span>
                        </div>
                        <i class="fas fa-chevron-right text-green-400 group-hover:text-green-600 text-sm"></i>
                    </a>
                    <a href="{{ route('admin.products.index') }}" 
                       class="group flex items-center justify-between w-full p-4 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200/60 rounded-xl hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg mr-3">
                                <i class="fas fa-box text-white text-sm"></i>
                            </div>
                            <span class="font-medium text-blue-800 group-hover:text-blue-900">Kelola Produk</span>
                        </div>
                        <i class="fas fa-chevron-right text-blue-400 group-hover:text-blue-600 text-sm"></i>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" 
                       class="group flex items-center justify-between w-full p-4 bg-gradient-to-r from-teal-50 to-teal-100 border border-teal-200/60 rounded-xl hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg mr-3">
                                <i class="fas fa-chart-bar text-white text-sm"></i>
                            </div>
                            <span class="font-medium text-teal-800 group-hover:text-teal-900">Lihat Laporan</span>
                        </div>
                        <i class="fas fa-chevron-right text-teal-400 group-hover:text-teal-600 text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-info-circle mr-3 text-gray-500"></i>
                    Informasi Sistem
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Versi Aplikasi</span>
                        <span class="text-sm font-semibold text-gray-900">v1.0.0</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Total Stok</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $productStats->total_stock ?? 0 }} items</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm font-medium text-gray-600">Status</span>
                        <span class="px-3 py-1 text-xs font-semibold bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full shadow-sm">
                            Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection