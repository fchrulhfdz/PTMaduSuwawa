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
    // Initialize date change listeners
    document.getElementById('start_date').addEventListener('change', function() {
        // Clear revenue data when date changes
        clearRevenueDisplay();
    });
    
    document.getElementById('end_date').addEventListener('change', function() {
        // Clear revenue data when date changes
        clearRevenueDisplay();
    });
    
    // Initialize button listeners
    document.getElementById('showRevenue').addEventListener('click', showRevenueSection);
    document.getElementById('showExpenses').addEventListener('click', showExpensesSection);
    
    // Expense form listeners
    document.getElementById('addExpenseBtn').addEventListener('click', showExpenseForm);
    document.getElementById('cancelExpenseBtn').addEventListener('click', hideExpenseForm);
    document.getElementById('saveExpenseBtn').addEventListener('click', saveExpense);
});

// Function to clear revenue display
function clearRevenueDisplay() {
    document.getElementById('total_revenue_display').value = 'Rp 0';
    document.getElementById('total_revenue').value = '0';
}

// Function to update revenue data based on selected period
function updateRevenueData() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
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
    
    console.log('Fetching revenue data for:', startDate, 'to', endDate);
    
    // Show loading state
    document.getElementById('total_revenue_display').value = 'Loading...';
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
            document.getElementById('total_revenue_display').value = 'Rp ' + formatCurrency(totalRevenue);
            document.getElementById('total_revenue').value = totalRevenue;
            
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
            document.getElementById('total_revenue_display').value = 'Rp 0';
            document.getElementById('total_revenue').value = '0';
            
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
        document.getElementById('total_revenue_display').value = 'Rp 0';
        document.getElementById('total_revenue').value = '0';
        
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
    
    document.getElementById('periodRevenueTotal').textContent = 'Rp ' + formatCurrency(totalRevenue);
    document.getElementById('yesterdayRevenue').textContent = 'Rp ' + formatCurrency(yesterdayRevenue);
    document.getElementById('overallRevenue').textContent = 'Rp ' + formatCurrency(overallRevenue);
    
    console.log('Revenue summary updated:', {
        periodTotal: totalRevenue,
        yesterday: yesterdayRevenue,
        overall: overallRevenue
    });
}

// Function to show revenue section
function showRevenueSection() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
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
    document.getElementById('revenueSection').classList.remove('hidden');
    document.getElementById('expensesSection').classList.add('hidden');
    
    // Update revenue data for the current period
    updateRevenueData();
}

// Function to show expenses section
function showExpensesSection() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
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
    document.getElementById('expensesSection').classList.remove('hidden');
    document.getElementById('revenueSection').classList.add('hidden');
    
    // Fetch expenses data for the current period
    fetchExpensesData(startDate, endDate);
}

// Function to fetch expenses data
function fetchExpensesData(startDate, endDate) {
    // Show loading state
    document.getElementById('expensesTableBody').innerHTML = `
        <tr>
            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                <i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...
            </td>
        </tr>
    `;
    
    console.log('Fetching expenses data for:', startDate, 'to', endDate);
    
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
            document.getElementById('expensesTableBody').innerHTML = `
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-red-500">
                        <i class="fas fa-exclamation-circle mr-2"></i>Error: ${data.error || data.message || 'Gagal memuat data'}
                    </td>
                </tr>
            `;
        }
    })
    .catch(error => {
        console.error('Error fetching expenses data:', error);
        document.getElementById('expensesTableBody').innerHTML = `
            <tr>
                <td colspan="4" class="px-4 py-4 text-center text-red-500">
                    <i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat data. Silakan coba lagi.
                </td>
            </tr>
        `;
    });
}

// Function to populate expenses table
function populateExpensesTable(expensesData) {
    const tbody = document.getElementById('expensesTableBody');
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
    document.getElementById('periodExpensesTotal').textContent = 'Rp ' + formatCurrency(totalExpenses);
    
    // Calculate net profit
    const revenue = parseFloat(document.getElementById('total_revenue').value) || 0;
    const netProfit = revenue - totalExpenses;
    document.getElementById('netProfit').textContent = 'Rp ' + formatCurrency(netProfit);
    
    // Update color based on profit/loss
    const netProfitElement = document.getElementById('netProfit');
    if (netProfit >= 0) {
        netProfitElement.classList.remove('text-red-600');
        netProfitElement.classList.add('text-green-600');
    } else {
        netProfitElement.classList.remove('text-green-600');
        netProfitElement.classList.add('text-red-600');
    }
    
    console.log('Expenses summary updated:', {
        totalExpenses: totalExpenses,
        revenue: revenue,
        netProfit: netProfit
    });
}

// Function to show expense form
function showExpenseForm() {
    document.getElementById('addExpenseForm').classList.remove('hidden');
    document.getElementById('addExpenseBtn').classList.add('hidden');
    
    // Reset form
    document.getElementById('expense_date').value = new Date().toISOString().split('T')[0];
    document.getElementById('expense_amount').value = '';
    document.getElementById('expense_description').value = '';
    currentEditingExpenseId = null;
}

// Function to hide expense form
function hideExpenseForm() {
    document.getElementById('addExpenseForm').classList.add('hidden');
    document.getElementById('addExpenseBtn').classList.remove('hidden');
    currentEditingExpenseId = null;
}

// Function to save expense
function saveExpense() {
    const date = document.getElementById('expense_date').value;
    const amount = document.getElementById('expense_amount').value;
    const description = document.getElementById('expense_description').value;
    
    // Validation
    if (!date || !amount || !description) {
        alert('Harap isi semua field yang diperlukan.');
        return;
    }
    
    if (parseFloat(amount) <= 0) {
        alert('Jumlah pengeluaran harus lebih dari 0.');
        return;
    }
    
    const data = {
        date: date,
        amount: parseFloat(amount),
        description: description
    };
    
    console.log('Saving expense:', data);
    
    // Determine if we're creating or updating
    const url = currentEditingExpenseId 
        ? `/admin/profit/update-expense/${currentEditingExpenseId}`
        : '/admin/profit/add-expense';
    
    const method = currentEditingExpenseId ? 'PUT' : 'POST';
    
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
            document.getElementById('expense_date').value = result.expense.date;
            document.getElementById('expense_amount').value = result.expense.amount;
            document.getElementById('expense_description').value = result.expense.description;
            
            // Set current editing ID and show form
            currentEditingExpenseId = expenseId;
            document.getElementById('addExpenseForm').classList.remove('hidden');
            document.getElementById('addExpenseBtn').classList.add('hidden');
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
    // Show loading state
    document.getElementById('today-profit').textContent = 'Loading...';
    document.getElementById('week-profit').textContent = 'Loading...';
    document.getElementById('month-profit').textContent = 'Loading...';
    
    // Reload the page to get fresh data
    window.location.reload();
}
</script>
@endsection