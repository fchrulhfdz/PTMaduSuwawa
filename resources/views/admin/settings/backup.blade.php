@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Backup Database</h1>
                    <p class="mt-2 text-sm text-gray-600">Buat dan kelola backup data sistem</p>
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
            <!-- Backup Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                <div class="flex items-center mb-6">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-600 shadow-sm">
                        <i class="fas fa-database text-white text-sm"></i>
                    </div>
                    <h2 class="ml-4 text-xl font-semibold text-gray-900">Buat Backup</h2>
                </div>
                
                <form action="{{ route('admin.settings.process-backup') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Tipe Backup</label>
                            <div class="grid grid-cols-1 gap-4">
                                <label class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm focus:outline-none hover:border-blue-300 transition-colors duration-200">
                                    <input type="radio" 
                                           name="backup_type" 
                                           value="database" 
                                           checked
                                           class="sr-only">
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">Hanya Database</span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">
                                                Backup semua data transaksi dan produk
                                            </span>
                                        </span>
                                    </span>
                                    <i class="fas fa-check-circle text-blue-600 text-lg ml-4"></i>
                                    <span class="pointer-events-none absolute -inset-px rounded-xl border-2 border-transparent"></span>
                                </label>

                                <label class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-white p-4 shadow-sm focus:outline-none hover:border-blue-300 transition-colors duration-200">
                                    <input type="radio" 
                                           name="backup_type" 
                                           value="full"
                                           class="sr-only">
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">Full Backup</span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">
                                                Database + file upload dan konfigurasi
                                            </span>
                                        </span>
                                    </span>
                                    <i class="fas fa-check-circle text-gray-300 text-lg ml-4"></i>
                                    <span class="pointer-events-none absolute -inset-px rounded-xl border-2 border-transparent"></span>
                                </label>
                            </div>
                        </div>

                        <div class="rounded-xl bg-blue-50/50 border border-blue-200 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Informasi Backup</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Backup disimpan di <code class="text-blue-600">storage/app/laravel-backup</code></li>
                                            <li>Database backup berisi semua data transaksi dan produk</li>
                                            <li>Full backup termasuk file upload dan konfigurasi sistem</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <i class="fas fa-download mr-3"></i>Buat Backup Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <!-- Backup Information -->
            <div class="space-y-6">
                <!-- System Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 shadow-sm">
                            <i class="fas fa-chart-bar text-white text-sm"></i>
                        </div>
                        <h2 class="ml-4 text-xl font-semibold text-gray-900">Informasi Sistem</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @php
                            $dbSize = DB::select('SELECT SUM(data_length + index_length) as size FROM information_schema.tables WHERE table_schema = ?', [DB::getDatabaseName()])[0]->size ?? 0;
                            $tableCount = count(DB::select('SHOW TABLES'));
                        @endphp
                        
                        @foreach([
                            ['label' => 'Ukuran Database', 'value' => number_format($dbSize / 1024 / 1024, 2) . ' MB', 'icon' => 'fas fa-database', 'color' => 'text-blue-500'],
                            ['label' => 'Total Tabel', 'value' => $tableCount, 'icon' => 'fas fa-table', 'color' => 'text-emerald-500'],
                            ['label' => 'Backup Terakhir', 'value' => $lastBackup ?? 'Belum ada', 'icon' => 'fas fa-history', 'color' => 'text-purple-500']
                        ] as $item)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                            <div class="flex items-center">
                                <i class="{{ $item['icon'] }} {{ $item['color'] }} text-sm mr-3"></i>
                                <span class="text-sm font-medium text-gray-600">{{ $item['label'] }}</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ $item['value'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Backup Guide -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 shadow-sm">
                            <i class="fas fa-lightbulb text-white text-sm"></i>
                        </div>
                        <h2 class="ml-4 text-xl font-semibold text-gray-900">Panduan Backup</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach([
                            ['icon' => 'fas fa-calendar-check', 'text' => 'Lakukan backup secara berkala (minimal seminggu sekali)'],
                            ['icon' => 'fas fa-shield-alt', 'text' => 'Simpan backup di lokasi yang aman dan terpisah dari server'],
                            ['icon' => 'fas fa-vial', 'text' => 'Test restore backup secara periodik untuk memastikan integritas data']
                        ] as $tip)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="{{ $tip['icon'] }} text-emerald-500 mt-0.5 mr-3"></i>
                            </div>
                            <p class="text-sm text-gray-600">{{ $tip['text'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Status Backup</h3>
                        <i class="fas fa-cloud-download-alt text-xl opacity-80"></i>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-blue-100">Ketersediaan Storage</span>
                            <span class="font-semibold">Aman</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-100">Auto Backup</span>
                            <span class="font-semibold">Aktif</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-100">Enkripsi</span>
                            <span class="font-semibold">Aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioLabels = document.querySelectorAll('label[class*="cursor-pointer"]');
    
    radioLabels.forEach(label => {
        const input = label.querySelector('input[type="radio"]');
        const checkIcon = label.querySelector('.fa-check-circle');
        
        label.addEventListener('click', function() {
            // Remove all selections
            radioLabels.forEach(l => {
                l.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
                l.querySelector('.fa-check-circle').classList.remove('text-blue-600');
                l.querySelector('.fa-check-circle').classList.add('text-gray-300');
            });
            
            // Add selection to clicked label
            this.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
            checkIcon.classList.remove('text-gray-300');
            checkIcon.classList.add('text-blue-600');
        });
        
        // Initialize first radio as selected
        if (input.checked) {
            label.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
            checkIcon.classList.remove('text-gray-300');
            checkIcon.classList.add('text-blue-600');
        }
    });
});
</script>
@endsection