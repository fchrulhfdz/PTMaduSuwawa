@extends('layouts.admin')

@section('title', 'Hitung Laba - Smart Cashier')
@section('subtitle', 'Perhitungan Laba & Profit')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-calculator text-indigo-500 mr-3"></i>
                    Hitung Laba
                </h2>
                <p class="text-gray-600 mt-2">Perhitungan laba bersih berdasarkan periode transaksi</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="loadQuickStats()" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Today's Profit -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Laba Hari Ini</p>
                    <h3 id="today-profit" class="text-2xl font-bold text-gray-800 mt-2">
                        Rp {{ number_format($todayProfit, 2) }}
                    </h3>
                    <p class="text-green-600 text-sm mt-1">
                        <span id="today-margin">{{ number_format($todayMargin, 2) }}%</span> margin
                    </p>
                </div>
                <i class="fas fa-coins text-green-500 text-xl"></i>
            </div>
        </div>

        <!-- This Week's Profit -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Laba Minggu Ini</p>
                    <h3 id="week-profit" class="text-2xl font-bold text-gray-800 mt-2">
                        Rp {{ number_format($weekProfit, 2) }}
                    </h3>
                    <p class="text-blue-600 text-sm mt-1">
                        <span id="week-margin">{{ number_format($weekMargin, 2) }}%</span> margin
                    </p>
                </div>
                <i class="fas fa-chart-line text-blue-500 text-xl"></i>
            </div>
        </div>

        <!-- This Month's Profit -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Laba Bulan Ini</p>
                    <h3 id="month-profit" class="text-2xl font-bold text-gray-800 mt-2">
                        Rp {{ number_format($monthProfit, 2) }}
                    </h3>
                    <p class="text-purple-600 text-sm mt-1">
                        <span id="month-margin">{{ number_format($monthMargin, 2) }}%</span> margin
                    </p>
                </div>
                <i class="fas fa-chart-bar text-purple-500 text-xl"></i>
            </div>
        </div>

        <!-- Total Calculations -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Perhitungan</p>
                    <h3 id="total-calculations" class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $totalCalculations }}
                    </h3>
                    <p class="text-orange-600 text-sm mt-1">seluruh periode</p>
                </div>
                <i class="fas fa-calculator text-orange-500 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Calculation Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-calculator text-indigo-500 mr-2"></i>
            Hitung Laba Manual
        </h3>
        
        <form action="{{ route('admin.profit.calculate') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Periode -->
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-700">Periode</h4>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai
                            </label>
                            <input type="date" 
                                   name="start_date" 
                                   id="start_date"
                                   value="{{ date('Y-m-d', strtotime('-1 month')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   required>
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Akhir
                            </label>
                            <input type="date" 
                                   name="end_date" 
                                   id="end_date"
                                   value="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan -->
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-700">Pendapatan</h4>
                    <div>
                        <label for="total_revenue" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Pendapatan (Rp)
                        </label>
                        <input type="number" 
                               name="total_revenue" 
                               id="total_revenue"
                               step="0.01"
                               min="0"
                               placeholder="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               required>
                    </div>
                </div>
            </div>

            <!-- Biaya -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-700">Biaya</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="operational_costs" class="block text-sm font-medium text-gray-700 mb-2">
                            Biaya Operasional (Rp)
                        </label>
                        <input type="number" 
                               name="operational_costs" 
                               id="operational_costs"
                               step="0.01"
                               min="0"
                               placeholder="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               required>
                    </div>
                    
                    <div>
                        <label for="product_costs" class="block text-sm font-medium text-gray-700 mb-2">
                            Biaya Produk (Rp)
                        </label>
                        <input type="number" 
                               name="product_costs" 
                               id="product_costs"
                               step="0.01"
                               min="0"
                               placeholder="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               required>
                    </div>
                    
                    <div>
                        <label for="other_costs" class="block text-sm font-medium text-gray-700 mb-2">
                            Biaya Lainnya (Rp)
                        </label>
                        <input type="number" 
                               name="other_costs" 
                               id="other_costs"
                               step="0.01"
                               min="0"
                               placeholder="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan (Opsional)
                </label>
                <textarea name="description" 
                          id="description"
                          rows="3"
                          placeholder="Tambahkan catatan atau keterangan tentang perhitungan ini..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <!-- Preview Hasil -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-700 mb-3">Preview Hasil</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Laba Kotor:</span>
                        <span id="preview-profit" class="font-medium ml-2">Rp 0</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Total Biaya:</span>
                        <span id="preview-cost" class="font-medium ml-2">Rp 0</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Margin Laba:</span>
                        <span id="preview-margin" class="font-medium ml-2">0%</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-8 py-3 rounded-lg transition-colors font-medium">
                    <i class="fas fa-calculator mr-2"></i>
                    Hitung & Simpan Laba
                </button>
            </div>
        </form>
    </div>

    <!-- Previous Calculations -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-history text-indigo-500 mr-2"></i>
            Riwayat Perhitungan
        </h3>
        
        @if($calculations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Periode
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pendapatan
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Biaya
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Laba
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Margin
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($calculations as $calculation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($calculation->start_date)->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">s/d</div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($calculation->end_date)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-green-600">
                                        Rp {{ number_format($calculation->total_revenue, 2) }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-red-600">
                                        Rp {{ number_format($calculation->total_cost, 2) }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-bold {{ $calculation->total_profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($calculation->total_profit, 2) }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $calculation->total_revenue > 0 ? number_format(($calculation->total_profit / $calculation->total_revenue) * 100, 2) : 0 }}%
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.profit.show', $calculation->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition-colors">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>
                                        <form action="{{ route('admin.profit.destroy', $calculation->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus perhitungan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition-colors">
                                                <i class="fas fa-trash mr-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $calculations->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calculator text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">Belum ada data perhitungan laba.</p>
                <p class="text-gray-400 text-sm mt-2">Gunakan form di atas untuk melakukan perhitungan pertama.</p>
            </div>
        @endif
    </div>
</div>

<script>
// Real-time calculation preview
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['total_revenue', 'operational_costs', 'product_costs', 'other_costs'];
    
    inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', updatePreview);
        }
    });
    
    function updatePreview() {
        const revenue = parseFloat(document.getElementById('total_revenue').value) || 0;
        const operational = parseFloat(document.getElementById('operational_costs').value) || 0;
        const product = parseFloat(document.getElementById('product_costs').value) || 0;
        const other = parseFloat(document.getElementById('other_costs').value) || 0;
        
        const totalCost = operational + product + other;
        const profit = revenue - totalCost;
        const margin = revenue > 0 ? (profit / revenue) * 100 : 0;
        
        document.getElementById('preview-profit').textContent = 'Rp ' + profit.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        
        document.getElementById('preview-cost').textContent = 'Rp ' + totalCost.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        
        document.getElementById('preview-margin').textContent = margin.toFixed(2) + '%';
    }
    
    // Initialize preview
    updatePreview();
});

// Function to load quick stats
function loadQuickStats() {
    // Show loading state
    document.getElementById('today-profit').textContent = 'Loading...';
    document.getElementById('week-profit').textContent = 'Loading...';
    document.getElementById('month-profit').textContent = 'Loading...';
    
    // Reload the page to get fresh data
    window.location.reload();
}
</script>
@endsection