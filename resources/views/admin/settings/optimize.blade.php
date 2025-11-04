@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Optimasi Aplikasi</h1>
                    <p class="mt-2 text-sm text-gray-600">Tingkatkan performa sistem dengan optimasi</p>
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
            <!-- Optimization Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                <div class="flex items-center mb-6">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-emerald-500 to-green-600 shadow-sm">
                        <i class="fas fa-tachometer-alt text-white text-sm"></i>
                    </div>
                    <h2 class="ml-4 text-xl font-semibold text-gray-900">Optimasi Sistem</h2>
                </div>
                
                <form action="{{ route('admin.settings.process-optimize') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Pilih Aksi Optimasi</label>
                            <div class="grid grid-cols-1 gap-4">
                                @foreach([
                                    ['value' => 'optimize', 'label' => 'Optimasi Aplikasi', 'description' => 'Menggabungkan file konfigurasi untuk performa lebih baik', 'icon' => 'fas fa-rocket', 'color' => 'text-emerald-500'],
                                    ['value' => 'migrate', 'label' => 'Jalankan Migration', 'description' => 'Update struktur database ke versi terbaru', 'icon' => 'fas fa-database', 'color' => 'text-blue-500'],
                                    ['value' => 'seed', 'label' => 'Jalankan Database Seeder', 'description' => 'Mengisi database dengan data sample', 'icon' => 'fas fa-seedling', 'color' => 'text-amber-500']
                                ] as $action)
                                <label class="relative flex items-start p-4 rounded-xl border border-gray-200 bg-white hover:border-gray-300 transition-colors duration-200 cursor-pointer">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" 
                                               name="optimize_actions[]" 
                                               value="{{ $action['value'] }}"
                                               {{ $action['value'] === 'optimize' ? 'checked' : '' }}
                                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center">
                                            <i class="{{ $action['icon'] }} {{ $action['color'] }} text-sm mr-3"></i>
                                            <span class="text-sm font-medium text-gray-700">{{ $action['label'] }}</span>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">{{ $action['description'] }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="seedSection" class="hidden transition-all duration-300">
                            <label for="seed_class" class="block text-sm font-medium text-gray-700 mb-3">
                                Pilih Seeder Class
                            </label>
                            <select name="seed_class" 
                                    id="seed_class"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200">
                                <option value="DatabaseSeeder">Database Seeder (All)</option>
                                <option value="ProductSeeder">Product Seeder</option>
                                <option value="UserSeeder">User Seeder</option>
                            </select>
                        </div>

                        <div class="rounded-xl bg-blue-50/50 border border-blue-200 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Informasi Optimasi</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>Optimasi akan meningkatkan performa aplikasi dengan:</p>
                                        <ul class="list-disc list-inside space-y-1 mt-2">
                                            <li>Menggabungkan file konfigurasi</li>
                                            <li>Membersihkan cache route dan view</li>
                                            <li>Mengoptimasi autoloader</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                            <i class="fas fa-play mr-3"></i>Jalankan Optimasi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Optimization Information -->
            <div class="space-y-6">
                <!-- System Status -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 shadow-sm">
                            <i class="fas fa-heartbeat text-white text-sm"></i>
                        </div>
                        <h2 class="ml-4 text-xl font-semibold text-gray-900">Status Sistem</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach([
                            ['label' => 'PHP Version', 'value' => PHP_VERSION, 'icon' => 'fab fa-php', 'status' => 'info'],
                            ['label' => 'Laravel Version', 'value' => app()->version(), 'icon' => 'fab fa-laravel', 'status' => 'info'],
                            ['label' => 'Environment', 'value' => app()->environment(), 'icon' => 'fas fa-server', 'status' => app()->environment() === 'production' ? 'success' : 'warning'],
                            ['label' => 'Debug Mode', 'value' => config('app.debug') ? 'Aktif' : 'Nonaktif', 'icon' => 'fas fa-bug', 'status' => config('app.debug') ? 'danger' : 'success']
                        ] as $item)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                            <div class="flex items-center">
                                <i class="{{ $item['icon'] }} text-gray-400 text-sm mr-3"></i>
                                <span class="text-sm font-medium text-gray-600">{{ $item['label'] }}</span>
                            </div>
                            <span class="text-sm font-semibold 
                                {{ $item['status'] === 'success' ? 'text-emerald-600' : '' }}
                                {{ $item['status'] === 'warning' ? 'text-amber-600' : '' }}
                                {{ $item['status'] === 'danger' ? 'text-rose-600' : '' }}
                                {{ $item['status'] === 'info' ? 'text-gray-900' : '' }}
                            ">{{ $item['value'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Optimization Tips -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 shadow-sm">
                            <i class="fas fa-tips text-white text-sm"></i>
                        </div>
                        <h2 class="ml-4 text-xl font-semibold text-gray-900">Tips Optimasi</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach([
                            ['icon' => 'fas fa-sync text-emerald-500', 'text' => 'Jalankan optimasi setelah update aplikasi'],
                            ['icon' => 'fas fa-bolt text-blue-500', 'text' => 'Gunakan environment production untuk performa terbaik'],
                            ['icon' => 'fas fa-shield-alt text-rose-500', 'text' => 'Nonaktifkan debug mode di production'],
                            ['icon' => 'fas fa-chart-line text-purple-500', 'text' => 'Lakukan optimasi database secara berkala']
                        ] as $tip)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="{{ $tip['icon'] }} mt-0.5 mr-3"></i>
                            </div>
                            <p class="text-sm text-gray-600">{{ $tip['text'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Performance Metrics -->
                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Metrik Performa</h3>
                        <i class="fas fa-chart-line text-xl opacity-80"></i>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-blue-100">Response Time</span>
                            <span class="font-semibold">~150ms</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-100">Memory Usage</span>
                            <span class="font-semibold">45MB</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-100">Cache Hit Rate</span>
                            <span class="font-semibold">92%</span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-blue-400/30">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-blue-200">Status Sistem</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    Optimal
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const seedCheckbox = document.querySelector('input[value="seed"]');
    const seedSection = document.getElementById('seedSection');

    function toggleSeedSection() {
        if (seedCheckbox.checked) {
            seedSection.classList.remove('hidden');
            seedSection.classList.add('animate-fade-in');
        } else {
            seedSection.classList.add('hidden');
            seedSection.classList.remove('animate-fade-in');
        }
    }

    seedCheckbox.addEventListener('change', toggleSeedSection);
    toggleSeedSection(); // Initialize on load
});
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection