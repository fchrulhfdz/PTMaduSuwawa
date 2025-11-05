@extends('layouts.admin')

@section('title', 'Dashboard - Smart Cashier')
@section('subtitle', 'Dashboard Sistem Kasir Pintar')

@section('content')
    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Today's Revenue -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pendapatan Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($todayStats->total_revenue ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-money-bill-wave text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Today's Transactions -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Transaksi Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $todayStats->total_transactions ?? 0 }}
                    </h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-green-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Produk</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $productStats->total_products ?? 0 }}
                    </h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-box text-purple-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Out of Stock -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Stok Habis</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $productStats->out_of_stock ?? 0 }}
                    </h3>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Transactions -->
            <div class="bg-white rounded-xl shadow-lg">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-clock mr-2 text-blue-500"></i>
                        Transaksi Terbaru
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentTransactions as $transaction)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-receipt text-blue-500"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $transaction->transaction_code }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $transaction->customer_name }} • {{ $transaction->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-green-600">
                                    {{ $transaction->formatted_total }}
                                </p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-800' : 
                                       ($transaction->payment_method === 'qris' ? 'bg-blue-100 text-blue-800' : 
                                       'bg-purple-100 text-purple-800') }}">
                                    {{ strtoupper(str_replace('_', ' ', $transaction->payment_method)) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>Belum ada transaksi</p>
                        </div>
                        @endforelse
                    </div>
                    
                    @if($recentTransactions->count() > 0)
                    <div class="mt-6 text-center">
                        <a href="{{ route('admin.transactions.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-list mr-2"></i>
                            Lihat Semua Transaksi
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Low Stock Products -->
            <div class="bg-white rounded-xl shadow-lg">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i>
                        Produk Stok Sedikit
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @forelse($lowStockProducts as $product)
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-box text-yellow-600 text-sm"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                Stok Rendah
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-check-circle text-4xl mb-3 text-green-500"></i>
                            <p>Semua stok produk aman</p>
                        </div>
                        @endforelse
                    </div>
                    
                    @if($lowStockProducts->count() > 0)
                    <div class="mt-6 text-center">
                        <a href="{{ route('admin.products.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                            <i class="fas fa-box mr-2"></i>
                            Kelola Produk
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Monthly Summary -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>
                    Ringkasan Bulan Ini
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-purple-800">Total Transaksi</p>
                        </div>
                        <span class="text-lg font-bold text-purple-600">
                            {{ $monthlyStats->total_transactions ?? 0 }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-green-800">Pendapatan Bulanan</p>
                        </div>
                        <span class="text-lg font-bold text-green-600">
                            Rp {{ number_format($monthlyStats->total_revenue ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bolt mr-2 text-orange-500"></i>
                    Aksi Cepat
                </h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.transactions.create') }}" 
                       class="w-full flex items-center justify-between p-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-plus-circle mr-3"></i>
                            <span>Transaksi Baru</span>
                        </div>
                        <i class="fas fa-chevron-right text-sm"></i>
                    </a>
                    <a href="{{ route('admin.products.index') }}" 
                       class="w-full flex items-center justify-between p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-box mr-3"></i>
                            <span>Kelola Produk</span>
                        </div>
                        <i class="fas fa-chevron-right text-sm"></i>
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}" 
                       class="w-full flex items-center justify-between p-3 bg-pink-50 text-pink-700 rounded-lg hover:bg-pink-100 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-comment-alt mr-3"></i>
                            <span>Kelola Testimonials</span>
                        </div>
                        <i class="fas fa-chevron-right text-sm"></i>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" 
                       class="w-full flex items-center justify-between p-3 bg-teal-50 text-teal-700 rounded-lg hover:bg-teal-100 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-chart-bar mr-3"></i>
                            <span>Lihat Laporan</span>
                        </div>
                        <i class="fas fa-chevron-right text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    Informasi Sistem
                </h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Versi Aplikasi</span>
                        <span class="font-medium">v1.0.0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Stok</span>
                        <span class="font-medium">{{ $productStats->total_stock ?? 0 }} items</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status</span>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection