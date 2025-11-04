@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Bersihkan Cache</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola cache sistem untuk performa optimal</p>
                </div>
                <a href="{{ route('admin.settings.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-xl shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
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

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-rose-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Cache Clear Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                <div class="flex items-center mb-6">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-gray-500 to-gray-600 shadow-sm">
                        <i class="fas fa-broom text-white text-sm"></i>
                    </div>
                    <h2 class="ml-4 text-xl font-semibold text-gray-900">Pembersihan Cache</h2>
                </div>
                
                <form action="{{ route('admin.settings.process-clear-cache') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Pilih Jenis Cache</label>
                            <div class="grid grid-cols-1 gap-3">
                                @foreach([
                                    'application' => ['label' => 'Cache Aplikasi', 'icon' => 'fas fa-rocket', 'color' => 'text-blue-500'],
                                    'config' => ['label' => 'Cache Konfigurasi', 'icon' => 'fas fa-cog', 'color' => 'text-emerald-500'],
                                    'route' => ['label' => 'Cache Route', 'icon' => 'fas fa-route', 'color' => 'text-purple-500'],
                                    'view' => ['label' => 'Cache View', 'icon' => 'fas fa-eye', 'color' => 'text-amber-500'],
                                    'compiled' => ['label' => 'File Compiled', 'icon' => 'fas fa-file-code', 'color' => 'text-rose-500']
                                ] as $key => $cache)
                                <label class="relative flex items-start p-4 rounded-xl border border-gray-200 bg-white hover:border-gray-300 transition-colors duration-200 cursor-pointer">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" 
                                               name="cache_types[]" 
                                               value="{{ $key }}"
                                               checked
                                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                    </div>
                                    <div class="ml-3 flex items-center">
                                        <i class="{{ $cache['icon'] }} {{ $cache['color'] }} text-sm mr-3"></i>
                                        <span class="text-sm font-medium text-gray-700">{{ $cache['label'] }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="rounded-xl bg-amber-50/50 border border-amber-200 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-amber-400 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-amber-800">Peringatan</h3>
                                    <div class="mt-2 text-sm text-amber-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Membersihkan cache mungkin menyebabkan aplikasi berjalan sedikit lebih lambat untuk request pertama</li>
                                            <li>Pastikan tidak ada proses penting yang sedang berjalan</li>
                                            <li>Cache akan secara otomatis dibangun kembali ketika diperlukan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i class="fas fa-broom mr-3"></i>Bersihkan Cache Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <!-- Cache Information -->
            <div class="space-y-6">
                <!-- Cache Status -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-600 shadow-sm">
                            <i class="fas fa-chart-bar text-white text-sm"></i>
                        </div>
                        <h2 class="ml-4 text-xl font-semibold text-gray-900">Status Cache</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach([
                            ['label' => 'Driver Cache', 'value' => config('cache.default'), 'icon' => 'fas fa-microchip', 'status' => 'active'],
                            ['label' => 'Status', 'value' => 'Aktif', 'icon' => 'fas fa-check-circle', 'status' => 'success'],
                            ['label' => 'Terakhir Dibersihkan', 'value' => now()->format('d/m/Y H:i'), 'icon' => 'fas fa-clock', 'status' => 'info']
                        ] as $item)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                            <div class="flex items-center">
                                <i class="{{ $item['icon'] }} text-gray-400 text-sm mr-3"></i>
                                <span class="text-sm font-medium text-gray-600">{{ $item['label'] }}</span>
                            </div>
                            <span class="text-sm font-semibold {{ $item['status'] === 'success' ? 'text-emerald-600' : 'text-gray-900' }}">{{ $item['value'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Cache Benefits -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-emerald-500 to-green-600 shadow-sm">
                            <i class="fas fa-lightbulb text-white text-sm"></i>
                        </div>
                        <h2 class="ml-4 text-xl font-semibold text-gray-900">Manfaat Cache</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach([
                            ['icon' => 'fas fa-rocket text-emerald-500', 'text' => 'Meningkatkan performa aplikasi secara signifikan'],
                            ['icon' => 'fas fa-database text-blue-500', 'text' => 'Mengurangi beban pada database server'],
                            ['icon' => 'fas fa-bolt text-amber-500', 'text' => 'Mempercepat loading time halaman'],
                            ['icon' => 'fas fa-users text-purple-500', 'text' => 'Meningkatkan pengalaman pengguna']
                        ] as $benefit)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="{{ $benefit['icon'] }} mt-0.5 mr-3"></i>
                            </div>
                            <p class="text-sm text-gray-600">{{ $benefit['text'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- When to Clear Cache -->
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Kapan Membersihkan Cache?</h3>
                        <i class="fas fa-clock text-xl opacity-80"></i>
                    </div>
                    <div class="space-y-3">
                        @foreach([
                            'Setelah update aplikasi atau framework',
                            'Setelah perubahan konfigurasi sistem',
                            'Ketika terjadi error yang tidak jelas',
                            'Secara rutin (misal: seminggu sekali)',
                            'Setelah perubahan template atau view'
                        ] as $tip)
                        <div class="flex items-start">
                            <i class="fas fa-check-circle mt-0.5 mr-3 text-purple-200"></i>
                            <span class="text-sm text-purple-100">{{ $tip }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection