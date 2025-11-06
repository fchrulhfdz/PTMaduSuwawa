@extends('layouts.admin')

@section('title', 'Detail Perhitungan Laba - Smart Cashier')
@section('subtitle', 'Detail Perhitungan Laba')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-file-invoice-dollar text-indigo-500 mr-3"></i>
                    Detail Perhitungan Laba
                </h2>
                <p class="text-gray-600 mt-2">
                    Periode: {{ \Carbon\Carbon::parse($profit->start_date)->format('d M Y') }} - 
                    {{ \Carbon\Carbon::parse($profit->end_date)->format('d M Y') }}
                </p>
                @if($profit->description)
                <p class="text-gray-500 text-sm mt-1">
                    <i class="fas fa-sticky-note mr-1"></i>
                    {{ $profit->description }}
                </p>
                @endif
            </div>
            <a href="{{ route('admin.profit.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-green-50 rounded-xl shadow-lg p-6 border border-green-200">
            <div class="text-center">
                <i class="fas fa-money-bill-wave text-green-500 text-2xl mb-3"></i>
                <p class="text-green-600 text-sm font-medium">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-green-700 mt-2">
                    Rp {{ number_format($profit->total_revenue, 2) }}
                </h3>
            </div>
        </div>

        <div class="bg-red-50 rounded-xl shadow-lg p-6 border border-red-200">
            <div class="text-center">
                <i class="fas fa-money-bill text-red-500 text-2xl mb-3"></i>
                <p class="text-red-600 text-sm font-medium">Total Biaya</p>
                <h3 class="text-2xl font-bold text-red-700 mt-2">
                    Rp {{ number_format($profit->total_cost, 2) }}
                </h3>
            </div>
        </div>

        <div class="bg-blue-50 rounded-xl shadow-lg p-6 border border-blue-200">
            <div class="text-center">
                <i class="fas fa-chart-line text-blue-500 text-2xl mb-3"></i>
                <p class="text-blue-600 text-sm font-medium">Laba Bersih</p>
                <h3 class="text-2xl font-bold {{ $profit->total_profit >= 0 ? 'text-blue-700' : 'text-red-700' }} mt-2">
                    Rp {{ number_format($profit->total_profit, 2) }}
                </h3>
            </div>
        </div>

        <div class="bg-purple-50 rounded-xl shadow-lg p-6 border border-purple-200">
            <div class="text-center">
                <i class="fas fa-percentage text-purple-500 text-2xl mb-3"></i>
                <p class="text-purple-600 text-sm font-medium">Margin Laba</p>
                <h3 class="text-2xl font-bold {{ $marginPercentage >= 0 ? 'text-purple-700' : 'text-red-700' }} mt-2">
                    {{ number_format($marginPercentage, 2) }}%
                </h3>
            </div>
        </div>
    </div>

    <!-- Profit Margin -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Visualisasi Margin Laba</h3>
        <div class="flex items-center space-x-4">
            <div class="flex-1 bg-gray-200 rounded-full h-4">
                <div class="bg-gradient-to-r from-green-400 to-blue-500 h-4 rounded-full transition-all duration-500" 
                     style="width: {{ $width }}%"></div>
            </div>
            <div class="text-lg font-bold {{ $marginPercentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($marginPercentage, 2) }}%
            </div>
        </div>
        <p class="text-gray-600 text-sm mt-2">
            Rasio laba bersih terhadap pendapatan total
        </p>
    </div>

    <!-- Breakdown Details -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-list-alt text-indigo-500 mr-2"></i>
            Rincian Perhitungan
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pendapatan -->
            <div class="space-y-4">
                <h4 class="font-medium text-green-600">Pendapatan</h4>
                <div class="space-y-2">
                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                        <span class="text-green-700">Total Pendapatan</span>
                        <span class="font-bold text-green-700">Rp {{ number_format($profit->total_revenue, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Biaya -->
            <div class="space-y-4">
                <h4 class="font-medium text-red-600">Biaya</h4>
                <div class="space-y-2">
                    @php
                        $details = $profit->calculation_details;
                        $costBreakdown = $details['cost_breakdown'] ?? [];
                    @endphp
                    <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                        <span class="text-red-700">Biaya Operasional</span>
                        <span class="font-bold text-red-700">Rp {{ number_format($costBreakdown['operational_costs'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                        <span class="text-red-700">Biaya Produk</span>
                        <span class="font-bold text-red-700">Rp {{ number_format($costBreakdown['product_costs'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                        <span class="text-red-700">Biaya Lainnya</span>
                        <span class="font-bold text-red-700">Rp {{ number_format($costBreakdown['other_costs'] ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-red-100 rounded-lg border border-red-200">
                        <span class="text-red-800 font-medium">Total Biaya</span>
                        <span class="font-bold text-red-800">Rp {{ number_format($profit->total_cost, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex justify-between items-center">
                <span class="text-blue-800 font-medium text-lg">Laba Bersih</span>
                <span class="font-bold text-lg {{ $profit->total_profit >= 0 ? 'text-blue-800' : 'text-red-800' }}">
                    Rp {{ number_format($profit->total_profit, 2) }}
                </span>
            </div>
        </div>
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
});
</script>
@endsection