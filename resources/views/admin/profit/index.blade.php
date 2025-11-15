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
        
        <div class="space-y-6">
            <!-- Periode Section -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-700">Periode</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

            <!-- Pendapatan Section -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-700">Pendapatan</h4>
                <div>
                    <label for="total_revenue_display" class="block text-sm font-medium text-gray-700 mb-2">
                        Total Pendapatan (Rp)
                    </label>
                    <input type="text" 
                           id="total_revenue_display"
                           value="Rp 0"
                           readonly
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">
                    <input type="hidden" id="total_revenue" name="total_revenue" value="0">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4">
                <button type="button" id="showRevenue" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg transition-colors font-medium">
                    <i class="fas fa-money-bill-wave mr-2"></i>Pendapatan
                </button>
                <button type="button" id="showExpenses" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg transition-colors font-medium">
                    <i class="fas fa-wallet mr-2"></i>Pengeluaran
                </button>
            </div>
        </div>
    </div>

    <!-- Revenue Table Section (Initially Hidden) -->
    <div id="revenueSection" class="bg-white rounded-xl shadow-lg p-6 hidden">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-money-bill-wave text-green-500 mr-2"></i>
            Data Pendapatan
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Produk
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keterangan
                        </th>
                    </tr>
                </thead>
                <tbody id="revenueTableBody" class="divide-y divide-gray-200">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- Revenue Summary -->
        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-gray-600">Total Pendapatan Periode Ini:</p>
                    <p id="periodRevenueTotal" class="text-lg font-bold text-green-600">Rp 0</p>
                </div>
                <div>
                    <p class="text-gray-600">Sisa Pendapatan Kemarin:</p>
                    <p id="yesterdayRevenue" class="text-lg font-bold text-blue-600">Rp 0</p>
                </div>
                <div>
                    <p class="text-gray-600">Total Pendapatan Keseluruhan:</p>
                    <p id="overallRevenue" class="text-lg font-bold text-purple-600">Rp 0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Expenses Table Section (Initially Hidden) -->
    <div id="expensesSection" class="bg-white rounded-xl shadow-lg p-6 hidden">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-wallet text-red-500 mr-2"></i>
                Data Pengeluaran
            </h3>
            <button type="button" id="addExpenseBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah Pengeluaran
            </button>
        </div>
        
        <!-- Add Expense Form (Initially Hidden) -->
        <div id="addExpenseForm" class="mb-6 p-4 border border-gray-200 rounded-lg hidden">
            <h4 class="font-medium text-gray-700 mb-3">Tambah Pengeluaran Baru</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="expense_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal
                    </label>
                    <input type="date" 
                           id="expense_date"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="expense_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah Pengeluaran (Rp)
                    </label>
                    <input type="number" 
                           id="expense_amount"
                           step="0.01"
                           min="0"
                           placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="expense_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan
                    </label>
                    <input type="text" 
                           id="expense_description"
                           placeholder="Deskripsi pengeluaran"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            <div class="mt-4 flex justify-end space-x-3">
                <button type="button" id="cancelExpenseBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="button" id="saveExpenseBtn" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Simpan
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keterangan
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody id="expensesTableBody" class="divide-y divide-gray-200">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- Expenses Summary -->
        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Total Pengeluaran Periode Ini:</p>
                    <p id="periodExpensesTotal" class="text-lg font-bold text-red-600">Rp 0</p>
                </div>
                <div>
                    <p class="text-gray-600">Laba Bersih:</p>
                    <p id="netProfit" class="text-lg font-bold text-green-600">Rp 0</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables
let currentEditingExpenseId = null;

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Initializing profit calculation...');
    
    // Initialize date change listeners
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    if (startDateInput) {
        startDateInput.addEventListener('change', function() {
            console.log('Start date changed:', this.value);
            clearRevenueDisplay();
        });
    }
    
    if (endDateInput) {
        endDateInput.addEventListener('change', function() {
            console.log('End date changed:', this.value);
            clearRevenueDisplay();
        });
    }
    
    // Initialize button listeners
    const showRevenueBtn = document.getElementById('showRevenue');
    const showExpensesBtn = document.getElementById('showExpenses');
    
    if (showRevenueBtn) {
        showRevenueBtn.addEventListener('click', showRevenueSection);
    }
    
    if (showExpensesBtn) {
        showExpensesBtn.addEventListener('click', showExpensesSection);
    }
    
    // Expense form listeners
    const addExpenseBtn = document.getElementById('addExpenseBtn');
    const cancelExpenseBtn = document.getElementById('cancelExpenseBtn');
    const saveExpenseBtn = document.getElementById('saveExpenseBtn');
    
    if (addExpenseBtn) {
        addExpenseBtn.addEventListener('click', showExpenseForm);
    }
    
    if (cancelExpenseBtn) {
        cancelExpenseBtn.addEventListener('click', hideExpenseForm);
    }
    
    if (saveExpenseBtn) {
        saveExpenseBtn.addEventListener('click', saveExpense);
    }
    
    console.log('Profit calculation initialized successfully');
});

// Function to clear revenue display
function clearRevenueDisplay() {
    const revenueDisplay = document.getElementById('total_revenue_display');
    const revenueInput = document.getElementById('total_revenue');
    
    if (revenueDisplay) revenueDisplay.value = 'Rp 0';
    if (revenueInput) revenueInput.value = '0';
    
    console.log('Revenue display cleared');
}

// Function to show revenue section
function showRevenueSection() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    console.log('Show Revenue Section called with dates:', startDate, endDate);
    
    // Validate dates before showing section
    if (!startDate || !endDate) {
        alert('Harap pilih tanggal mulai dan tanggal akhir terlebih dahulu.');
        return;
    }
    
    if (new Date(startDate) > new Date(endDate)) {
        alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
        return;
    }
    
    // Show revenue section and hide expenses section
    const revenueSection = document.getElementById('revenueSection');
    const expensesSection = document.getElementById('expensesSection');
    
    if (revenueSection) revenueSection.classList.remove('hidden');
    if (expensesSection) expensesSection.classList.add('hidden');
    
    // Update revenue data for the current period
    updateRevenueData();
}

// Function to update revenue data based on selected period
function updateRevenueData() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    console.log('Update Revenue Data called:', startDate, endDate);
    
    // Validate dates
    if (!startDate || !endDate) {
        alert('Harap pilih tanggal mulai dan tanggal akhir terlebih dahulu.');
        return;
    }
    
    // Validate date range
    if (new Date(startDate) > new Date(endDate)) {
        alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
        return;
    }
    
    // Show loading state
    const revenueDisplay = document.getElementById('total_revenue_display');
    const revenueInput = document.getElementById('total_revenue');
    
    if (revenueDisplay) revenueDisplay.value = 'Loading...';
    if (revenueInput) revenueInput.value = '0';
    
    const revenueTableBody = document.getElementById('revenueTableBody');
    if (revenueTableBody) {
        revenueTableBody.innerHTML = `
            <tr>
                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...
                </td>
            </tr>
        `;
    }
    
    // AJAX request to fetch revenue data
    fetch(`/admin/profit/get-revenue-data?start_date=${startDate}&end_date=${endDate}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Revenue data response:', data);
        
        if (data.success) {
            // Ensure totalRevenue is a valid number
            const totalRevenue = parseFloat(data.totalRevenue) || 0;
            
            // Update total revenue display
            if (revenueDisplay) {
                revenueDisplay.value = 'Rp ' + formatCurrency(totalRevenue);
            }
            if (revenueInput) {
                revenueInput.value = totalRevenue;
            }
            
            // Update revenue table
            populateRevenueTable(data.revenueData || []);
            
            // Update revenue summary with correct values
            updateRevenueSummary({
                totalRevenue: totalRevenue,
                yesterdayRevenue: parseFloat(data.yesterdayRevenue) || 0,
                overallRevenue: parseFloat(data.overallRevenue) || totalRevenue
            });
            
            console.log('Total revenue updated to:', totalRevenue);
        } else {
            console.error('Error in response:', data.error || data.message);
            alert('Error: ' + (data.error || data.message || 'Gagal memuat data'));
            
            if (revenueDisplay) revenueDisplay.value = 'Rp 0';
            if (revenueInput) revenueInput.value = '0';
            
            if (revenueTableBody) {
                revenueTableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-red-500">
                            Error: ${data.error || data.message || 'Gagal memuat data'}
                        </td>
                    </tr>
                `;
            }
        }
    })
    .catch(error => {
        console.error('Error fetching revenue data:', error);
        alert('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
        
        if (revenueDisplay) revenueDisplay.value = 'Rp 0';
        if (revenueInput) revenueInput.value = '0';
        
        if (revenueTableBody) {
            revenueTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-red-500">
                        <i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat data. Silakan coba lagi.
                    </td>
                </tr>
            `;
        }
    });
}

// Function to populate revenue table
function populateRevenueTable(revenueData) {
    const tbody = document.getElementById('revenueTableBody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (!revenueData || revenueData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                    <i class="fas fa-info-circle mr-2"></i>Tidak ada data pendapatan untuk periode yang dipilih.
                </td>
            </tr>
        `;
        return;
    }
    
    revenueData.forEach(item => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 transition-colors';
        row.innerHTML = `
            <td class="px-4 py-3 whitespace-nowrap">
                <div class="text-sm text-gray-900">${item.date || '-'}</div>
            </td>
            <td class="px-4 py-3">
                <div class="text-sm text-gray-900">${item.product_name || '-'}</div>
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <div class="text-sm text-gray-900">${item.quantity || 0}</div>
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <div class="text-sm font-medium text-green-600">Rp ${formatCurrency(item.total || 0)}</div>
            </td>
            <td class="px-4 py-3">
                <div class="text-sm text-gray-500">${item.description || '-'}</div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Function to update revenue summary
function updateRevenueSummary(data) {
    if (!data) {
        console.error('No data provided for revenue summary');
        return;
    }
    
    const totalRevenue = parseFloat(data.totalRevenue) || 0;
    const yesterdayRevenue = parseFloat(data.yesterdayRevenue) || 0;
    const overallRevenue = parseFloat(data.overallRevenue) || totalRevenue;
    
    const periodRevenueElement = document.getElementById('periodRevenueTotal');
    const yesterdayRevenueElement = document.getElementById('yesterdayRevenue');
    const overallRevenueElement = document.getElementById('overallRevenue');
    
    if (periodRevenueElement) periodRevenueElement.textContent = 'Rp ' + formatCurrency(totalRevenue);
    if (yesterdayRevenueElement) yesterdayRevenueElement.textContent = 'Rp ' + formatCurrency(yesterdayRevenue);
    if (overallRevenueElement) overallRevenueElement.textContent = 'Rp ' + formatCurrency(overallRevenue);
    
    console.log('Revenue summary updated:', {
        periodTotal: totalRevenue,
        yesterday: yesterdayRevenue,
        overall: overallRevenue
    });
}

// Function to show expenses section
function showExpensesSection() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    console.log('Show Expenses Section called with dates:', startDate, endDate);
    
    // Validate dates before showing section
    if (!startDate || !endDate) {
        alert('Harap pilih tanggal mulai dan tanggal akhir terlebih dahulu.');
        return;
    }
    
    if (new Date(startDate) > new Date(endDate)) {
        alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
        return;
    }
    
    // Show expenses section and hide revenue section
    const expensesSection = document.getElementById('expensesSection');
    const revenueSection = document.getElementById('revenueSection');
    
    if (expensesSection) expensesSection.classList.remove('hidden');
    if (revenueSection) revenueSection.classList.add('hidden');
    
    // Fetch expenses data for the current period
    fetchExpensesData(startDate, endDate);
}

// Function to fetch expenses data
function fetchExpensesData(startDate, endDate) {
    console.log('Fetching expenses data for:', startDate, 'to', endDate);
    
    // Show loading state
    const expensesTableBody = document.getElementById('expensesTableBody');
    if (expensesTableBody) {
        expensesTableBody.innerHTML = `
            <tr>
                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...
                </td>
            </tr>
        `;
    }
    
    // AJAX request to fetch expenses data
    fetch(`/admin/profit/get-expenses-data?start_date=${startDate}&end_date=${endDate}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Expenses response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Expenses data response:', data);
        
        if (data.success) {
            populateExpensesTable(data.expensesData || []);
            updateExpensesSummary({
                totalExpenses: parseFloat(data.totalExpenses) || 0
            });
        } else {
            console.error('Error in expenses response:', data.error || data.message);
            alert('Error: ' + (data.error || data.message || 'Gagal memuat data pengeluaran'));
            
            if (expensesTableBody) {
                expensesTableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-red-500">
                            <i class="fas fa-exclamation-circle mr-2"></i>Error: ${data.error || data.message || 'Gagal memuat data'}
                        </td>
                    </tr>
                `;
            }
        }
    })
    .catch(error => {
        console.error('Error fetching expenses data:', error);
        alert('Terjadi kesalahan saat mengambil data pengeluaran. Silakan coba lagi.');
        
        if (expensesTableBody) {
            expensesTableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-red-500">
                        <i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat data. Silakan coba lagi.
                    </td>
                </tr>
            `;
        }
    });
}

// Function to populate expenses table
function populateExpensesTable(expensesData) {
    const tbody = document.getElementById('expensesTableBody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (!expensesData || expensesData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                    <i class="fas fa-info-circle mr-2"></i>Tidak ada data pengeluaran untuk periode yang dipilih.
                </td>
            </tr>
        `;
        return;
    }
    
    expensesData.forEach(expense => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 transition-colors';
        row.innerHTML = `
            <td class="px-4 py-3 whitespace-nowrap">
                <div class="text-sm text-gray-900">${expense.date || '-'}</div>
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <div class="text-sm font-medium text-red-600">Rp ${formatCurrency(expense.amount || 0)}</div>
            </td>
            <td class="px-4 py-3">
                <div class="text-sm text-gray-900">${expense.description || '-'}</div>
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <div class="flex space-x-2">
                    <button onclick="editExpense(${expense.id})" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition-colors">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </button>
                    <button onclick="deleteExpense(${expense.id})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition-colors">
                        <i class="fas fa-trash mr-1"></i>Hapus
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Function to update expenses summary
function updateExpensesSummary(data) {
    if (!data) {
        console.error('No data provided for expenses summary');
        return;
    }
    
    const totalExpenses = parseFloat(data.totalExpenses) || 0;
    const periodExpensesElement = document.getElementById('periodExpensesTotal');
    const netProfitElement = document.getElementById('netProfit');
    
    if (periodExpensesElement) {
        periodExpensesElement.textContent = 'Rp ' + formatCurrency(totalExpenses);
    }
    
    // Calculate net profit
    const revenue = parseFloat(document.getElementById('total_revenue').value) || 0;
    const netProfit = revenue - totalExpenses;
    
    if (netProfitElement) {
        netProfitElement.textContent = 'Rp ' + formatCurrency(netProfit);
        
        // Update color based on profit/loss
        if (netProfit >= 0) {
            netProfitElement.classList.remove('text-red-600');
            netProfitElement.classList.add('text-green-600');
        } else {
            netProfitElement.classList.remove('text-green-600');
            netProfitElement.classList.add('text-red-600');
        }
    }
    
    console.log('Expenses summary updated:', {
        totalExpenses: totalExpenses,
        revenue: revenue,
        netProfit: netProfit
    });
}

// Function to show expense form
function showExpenseForm() {
    const expenseForm = document.getElementById('addExpenseForm');
    const addExpenseBtn = document.getElementById('addExpenseBtn');
    
    if (expenseForm) expenseForm.classList.remove('hidden');
    if (addExpenseBtn) addExpenseBtn.classList.add('hidden');
    
    // Reset form
    const expenseDate = document.getElementById('expense_date');
    const expenseAmount = document.getElementById('expense_amount');
    const expenseDescription = document.getElementById('expense_description');
    
    if (expenseDate) expenseDate.value = new Date().toISOString().split('T')[0];
    if (expenseAmount) expenseAmount.value = '';
    if (expenseDescription) expenseDescription.value = '';
    
    currentEditingExpenseId = null;
    
    console.log('Expense form shown');
}

// Function to hide expense form
function hideExpenseForm() {
    const expenseForm = document.getElementById('addExpenseForm');
    const addExpenseBtn = document.getElementById('addExpenseBtn');
    
    if (expenseForm) expenseForm.classList.add('hidden');
    if (addExpenseBtn) addExpenseBtn.classList.remove('hidden');
    
    currentEditingExpenseId = null;
    
    console.log('Expense form hidden');
}

// Function to save expense
function saveExpense() {
    const date = document.getElementById('expense_date').value;
    const amount = document.getElementById('expense_amount').value;
    const description = document.getElementById('expense_description').value;
    
    console.log('Saving expense:', { date, amount, description });
    
    // Validation
    if (!date || !amount || !description) {
        alert('Harap isi semua field yang diperlukan.');
        return;
    }
    
    const amountValue = parseFloat(amount);
    if (isNaN(amountValue) || amountValue <= 0) {
        alert('Jumlah pengeluaran harus lebih dari 0.');
        return;
    }
    
    const data = {
        date: date,
        amount: amountValue,
        description: description
    };
    
    // Determine if we're creating or updating
    const url = currentEditingExpenseId 
        ? `/admin/profit/update-expense/${currentEditingExpenseId}`
        : '/admin/profit/add-expense';
    
    const method = currentEditingExpenseId ? 'PUT' : 'POST';
    
    console.log(`Making ${method} request to: ${url}`);
    
    // AJAX request to save expense
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('Save expense response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        console.log('Save expense result:', result);
        if (result.success) {
            // Hide form and refresh expenses data
            hideExpenseForm();
            
            // Refresh expenses data
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            fetchExpensesData(startDate, endDate);
            
            // Show success message
            alert(currentEditingExpenseId ? 'Pengeluaran berhasil diperbarui.' : 'Pengeluaran berhasil ditambahkan.');
        } else {
            alert('Terjadi kesalahan: ' + (result.message || 'Tidak diketahui'));
        }
    })
    .catch(error => {
        console.error('Error saving expense:', error);
        alert('Terjadi kesalahan saat menyimpan data.');
    });
}

// Function to edit expense
function editExpense(expenseId) {
    console.log('Editing expense:', expenseId);
    
    // Fetch expense details
    fetch(`/admin/profit/get-expense/${expenseId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Get expense response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        console.log('Get expense result:', result);
        if (result.success && result.expense) {
            // Populate form with expense data
            const expenseDate = document.getElementById('expense_date');
            const expenseAmount = document.getElementById('expense_amount');
            const expenseDescription = document.getElementById('expense_description');
            
            if (expenseDate) expenseDate.value = result.expense.date;
            if (expenseAmount) expenseAmount.value = result.expense.amount;
            if (expenseDescription) expenseDescription.value = result.expense.description;
            
            // Set current editing ID and show form
            currentEditingExpenseId = expenseId;
            
            const expenseForm = document.getElementById('addExpenseForm');
            const addExpenseBtn = document.getElementById('addExpenseBtn');
            
            if (expenseForm) expenseForm.classList.remove('hidden');
            if (addExpenseBtn) addExpenseBtn.classList.add('hidden');
        } else {
            alert('Terjadi kesalahan: ' + (result.message || 'Data tidak ditemukan'));
        }
    })
    .catch(error => {
        console.error('Error fetching expense details:', error);
        alert('Terjadi kesalahan saat mengambil data pengeluaran.');
    });
}

// Function to delete expense
function deleteExpense(expenseId) {
    if (!confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?')) {
        return;
    }
    
    console.log('Deleting expense:', expenseId);
    
    // AJAX request to delete expense
    fetch(`/admin/profit/delete-expense/${expenseId}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Delete expense response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        console.log('Delete expense result:', result);
        if (result.success) {
            // Refresh expenses data
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            fetchExpensesData(startDate, endDate);
            
            alert('Pengeluaran berhasil dihapus.');
        } else {
            alert('Terjadi kesalahan: ' + (result.message || 'Tidak diketahui'));
        }
    })
    .catch(error => {
        console.error('Error deleting expense:', error);
        alert('Terjadi kesalahan saat menghapus data.');
    });
}

// Utility function to format currency
function formatCurrency(amount) {
    // Handle null, undefined, or invalid amounts
    if (amount === null || amount === undefined || isNaN(amount)) {
        amount = 0;
    }
    return parseFloat(amount).toLocaleString('id-ID', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

// Function to load quick stats
function loadQuickStats() {
    console.log('Loading quick stats...');
    
    // Show loading state
    const todayProfit = document.getElementById('today-profit');
    const weekProfit = document.getElementById('week-profit');
    const monthProfit = document.getElementById('month-profit');
    
    if (todayProfit) todayProfit.textContent = 'Loading...';
    if (weekProfit) weekProfit.textContent = 'Loading...';
    if (monthProfit) monthProfit.textContent = 'Loading...';
    
    // Reload the page to get fresh data
    window.location.reload();
}
</script>
@endsection