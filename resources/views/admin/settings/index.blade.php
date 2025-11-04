@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pengaturan Sistem</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola pengaturan aplikasi dan sistem</p>
                </div>
                <button type="submit" form="settings-form"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                </button>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-emerald-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-rose-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-rose-800">Terjadi kesalahan</h3>
                        <div class="mt-2 text-sm text-rose-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- General Settings -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 shadow-sm">
                                <i class="fas fa-cog text-white text-sm"></i>
                            </div>
                            <h2 class="ml-4 text-xl font-semibold text-gray-900">Pengaturan Umum</h2>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="app_name" class="block text-sm font-medium text-gray-700 mb-3">
                                    Nama Aplikasi
                                </label>
                                <input type="text" 
                                       name="app_name" 
                                       id="app_name"
                                       value="{{ old('app_name', $settings['app_name'] ?? config('app.name')) }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                            </div>

                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-3">
                                    Nama Perusahaan
                                </label>
                                <input type="text" 
                                       name="company_name" 
                                       id="company_name"
                                       value="{{ old('company_name', $settings['company_name'] ?? '') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                            </div>

                            <div>
                                <label for="company_address" class="block text-sm font-medium text-gray-700 mb-3">
                                    Alamat Perusahaan
                                </label>
                                <textarea name="company_address" 
                                          id="company_address"
                                          rows="3"
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">{{ old('company_address', $settings['company_address'] ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="company_phone" class="block text-sm font-medium text-gray-700 mb-3">
                                        Telepon Perusahaan
                                    </label>
                                    <input type="text" 
                                           name="company_phone" 
                                           id="company_phone"
                                           value="{{ old('company_phone', $settings['company_phone'] ?? '') }}"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                                </div>

                                <div>
                                    <label for="company_email" class="block text-sm font-medium text-gray-700 mb-3">
                                        Email Perusahaan
                                    </label>
                                    <input type="email" 
                                           name="company_email" 
                                           id="company_email"
                                           value="{{ old('company_email', $settings['company_email'] ?? '') }}"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Receipt Settings -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-600 shadow-sm">
                                <i class="fas fa-receipt text-white text-sm"></i>
                            </div>
                            <h2 class="ml-4 text-xl font-semibold text-gray-900">Pengaturan Struk</h2>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="receipt_header" class="block text-sm font-medium text-gray-700 mb-3">
                                    Header Struk
                                </label>
                                <textarea name="receipt_header" 
                                          id="receipt_header"
                                          rows="2"
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">{{ old('receipt_header', $settings['receipt_header'] ?? '') }}</textarea>
                                <p class="mt-2 text-xs text-gray-500">Teks yang akan muncul di bagian atas struk</p>
                            </div>

                            <div>
                                <label for="receipt_footer" class="block text-sm font-medium text-gray-700 mb-3">
                                    Footer Struk
                                </label>
                                <textarea name="receipt_footer" 
                                          id="receipt_footer"
                                          rows="2"
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">{{ old('receipt_footer', $settings['receipt_footer'] ?? 'Terima kasih atas kunjungan Anda!') }}</textarea>
                                <p class="mt-2 text-xs text-gray-500">Teks yang akan muncul di bagian bawah struk</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="receipt_printer_width" class="block text-sm font-medium text-gray-700 mb-3">
                                        Lebar Struk (chars)
                                    </label>
                                    <input type="number" 
                                           name="receipt_printer_width" 
                                           id="receipt_printer_width"
                                           min="32"
                                           max="80"
                                           value="{{ old('receipt_printer_width', $settings['receipt_printer_width'] ?? 42) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                                </div>

                                <div class="flex items-center pt-8">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" 
                                               name="print_automatically" 
                                               id="print_automatically"
                                               value="1"
                                               {{ (old('print_automatically', $settings['print_automatically'] ?? false)) ? 'checked' : '' }}
                                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                    </div>
                                    <label for="print_automatically" class="ml-3 text-sm text-gray-700">
                                        Cetak otomatis setelah transaksi
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Settings -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-emerald-500 to-green-600 shadow-sm">
                                <i class="fas fa-boxes text-white text-sm"></i>
                            </div>
                            <h2 class="ml-4 text-xl font-semibold text-gray-900">Pengaturan Stok</h2>
                        </div>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="low_stock_threshold" class="block text-sm font-medium text-gray-700 mb-3">
                                        Batas Stok Rendah
                                    </label>
                                    <input type="number" 
                                           name="low_stock_threshold" 
                                           id="low_stock_threshold"
                                           min="1"
                                           value="{{ old('low_stock_threshold', $settings['low_stock_threshold'] ?? 10) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                                    <p class="mt-2 text-xs text-gray-500">Notifikasi akan muncul ketika stok mencapai batas ini</p>
                                </div>

                                <div class="flex items-center pt-8">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" 
                                               name="enable_stock_notifications" 
                                               id="enable_stock_notifications"
                                               value="1"
                                               {{ (old('enable_stock_notifications', $settings['enable_stock_notifications'] ?? true)) ? 'checked' : '' }}
                                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                    </div>
                                    <label for="enable_stock_notifications" class="ml-3 text-sm text-gray-700">
                                        Aktifkan notifikasi stok rendah
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- System Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 shadow-sm">
                                <i class="fas fa-info-circle text-white text-sm"></i>
                            </div>
                            <h2 class="ml-4 text-xl font-semibold text-gray-900">Informasi Sistem</h2>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach([
                                ['label' => 'Versi Aplikasi', 'value' => '1.0.0', 'icon' => 'fas fa-code-branch'],
                                ['label' => 'Laravel Version', 'value' => app()->version(), 'icon' => 'fab fa-laravel'],
                                ['label' => 'PHP Version', 'value' => PHP_VERSION, 'icon' => 'fab fa-php'],
                                ['label' => 'Environment', 'value' => app()->environment(), 'icon' => 'fas fa-server'],
                                ['label' => 'Total Produk', 'value' => $totalProducts, 'icon' => 'fas fa-box'],
                                ['label' => 'Total Transaksi', 'value' => $totalTransactions, 'icon' => 'fas fa-shopping-cart']
                            ] as $item)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <div class="flex items-center">
                                    <i class="{{ $item['icon'] }} text-gray-400 text-sm mr-3"></i>
                                    <span class="text-sm font-medium text-gray-600">{{ $item['label'] }}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $item['value'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Backup & Maintenance -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 shadow-sm">
                                <i class="fas fa-database text-white text-sm"></i>
                            </div>
                            <h2 class="ml-4 text-xl font-semibold text-gray-900">Backup & Pemeliharaan</h2>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach([
                                ['route' => 'admin.settings.backup', 'color' => 'from-blue-500 to-cyan-600', 'icon' => 'fas fa-download', 'label' => 'Backup Database'],
                                ['route' => 'admin.settings.clear-cache', 'color' => 'from-gray-500 to-gray-600', 'icon' => 'fas fa-broom', 'label' => 'Bersihkan Cache'],
                                ['route' => 'admin.settings.optimize', 'color' => 'from-emerald-500 to-green-600', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Optimasi Aplikasi']
                            ] as $action)
                            <a href="{{ route($action['route']) }}" 
                               class="group flex items-center justify-between w-full px-4 py-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 hover:border-{{ explode(' ', $action['color'])[0] }}-200">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-r {{ $action['color'] }} shadow-sm">
                                        <i class="{{ $action['icon'] }} text-white text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ $action['label'] }}</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-gray-600 text-xs"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection