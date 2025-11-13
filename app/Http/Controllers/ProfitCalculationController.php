<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProfitCalculation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitCalculationController extends Controller
{
    public function index()
    {
        $calculations = ProfitCalculation::profitCalculations()->latest()->paginate(10);
        
        // Hitung statistik dari transaksi
        $today = Carbon::today();
        
        // Laba Hari Ini - berdasarkan transaksi hari ini
        $todayTransactions = Transaction::whereDate('created_at', $today)->get();
        $todayRevenue = $todayTransactions->sum('total');
        $todayExpenses = ProfitCalculation::expenses()
                        ->whereDate('expense_date', $today)
                        ->sum('expense_amount');
        $todayProfit = $todayRevenue - $todayExpenses;
        $todayMargin = $todayRevenue > 0 ? ($todayProfit / $todayRevenue) * 100 : 0;
        
        // Laba Minggu Ini
        $weekStart = $today->copy()->startOfWeek();
        $weekEnd = $today->copy()->endOfWeek();
        $weekTransactions = Transaction::whereBetween('created_at', [$weekStart, $weekEnd])->get();
        $weekRevenue = $weekTransactions->sum('total');
        $weekExpenses = ProfitCalculation::expenses()
                        ->whereBetween('expense_date', [$weekStart, $weekEnd])
                        ->sum('expense_amount');
        $weekProfit = $weekRevenue - $weekExpenses;
        $weekMargin = $weekRevenue > 0 ? ($weekProfit / $weekRevenue) * 100 : 0;
        
        // Laba Bulan Ini
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();
        $monthTransactions = Transaction::whereBetween('created_at', [$monthStart, $monthEnd])->get();
        $monthRevenue = $monthTransactions->sum('total');
        $monthExpenses = ProfitCalculation::expenses()
                        ->whereBetween('expense_date', [$monthStart, $monthEnd])
                        ->sum('expense_amount');
        $monthProfit = $monthRevenue - $monthExpenses;
        $monthMargin = $monthRevenue > 0 ? ($monthProfit / $monthRevenue) * 100 : 0;
        
        // Total Perhitungan (hanya yang profit calculation)
        $totalCalculations = ProfitCalculation::profitCalculations()->count();

        return view('admin.profit.index', compact(
            'calculations',
            'todayProfit',
            'todayMargin',
            'weekProfit',
            'weekMargin',
            'monthProfit',
            'monthMargin',
            'totalCalculations'
        ));
    }

    // Method untuk mendapatkan data pendapatan berdasarkan periode (AJAX)
    public function getRevenueData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        // Validasi
        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Start date and end date are required'], 400);
        }

        try {
            // Convert dates to Carbon instances
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();

            // Debug: log the dates
            \Log::info("Fetching revenue data from {$start} to {$end}");

            // Ambil data transaksi dalam periode
            $transactions = Transaction::whereBetween('created_at', [$start, $end])->get();

            // Debug: log transaction count
            \Log::info("Found {$transactions->count()} transactions in period");

            // Format data untuk ditampilkan di tabel
            $revenueData = [];
            $totalRevenue = 0;

            foreach ($transactions as $transaction) {
                // Debug: log each transaction
                \Log::info("Processing transaction: {$transaction->id}, Total: {$transaction->total}");
                
                // Karena satu transaksi bisa memiliki multiple items, kita akan loop items
                $items = $transaction->items_array;
                
                if (empty($items)) {
                    // Jika items kosong, tambahkan transaksi sebagai satu item
                    $revenueData[] = [
                        'date' => $transaction->created_at->format('d M Y'),
                        'product_name' => 'Transaksi #' . $transaction->transaction_code,
                        'quantity' => 1,
                        'total' => $transaction->total,
                        'description' => $transaction->notes ?? 'Transaksi penjualan'
                    ];
                } else {
                    foreach ($items as $item) {
                        $itemTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
                        $revenueData[] = [
                            'date' => $transaction->created_at->format('d M Y'),
                            'product_name' => $item['name'] ?? 'Produk',
                            'quantity' => $item['quantity'] ?? 0,
                            'total' => $itemTotal,
                            'description' => $item['description'] ?? $transaction->notes ?? '-'
                        ];
                    }
                }
                $totalRevenue += $transaction->total;
            }

            // Hitung pendapatan kemarin
            $yesterday = Carbon::parse($startDate)->subDay();
            $yesterdayRevenue = Transaction::whereDate('created_at', $yesterday)->sum('total');

            // Debug: log final results
            \Log::info("Total Revenue: {$totalRevenue}, Yesterday Revenue: {$yesterdayRevenue}");

            return response()->json([
                'success' => true,
                'revenueData' => $revenueData,
                'totalRevenue' => $totalRevenue,
                'yesterdayRevenue' => $yesterdayRevenue,
                'overallRevenue' => $totalRevenue
            ]);

        } catch (\Exception $e) {
            \Log::error("Error in getRevenueData: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk mendapatkan data pengeluaran berdasarkan periode (AJAX)
    public function getExpensesData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Validasi
        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Start date and end date are required'], 400);
        }

        try {
            // Ambil data pengeluaran dalam periode
            $expenses = ProfitCalculation::expenses()
                        ->whereBetween('expense_date', [$startDate, $endDate])
                        ->get();

            $expensesData = [];
            $totalExpenses = 0;

            foreach ($expenses as $expense) {
                $expensesData[] = [
                    'id' => $expense->id,
                    'date' => $expense->expense_date->format('d M Y'),
                    'amount' => $expense->expense_amount,
                    'description' => $expense->expense_description
                ];
                $totalExpenses += $expense->expense_amount;
            }

            return response()->json([
                'success' => true,
                'expensesData' => $expensesData,
                'totalExpenses' => $totalExpenses
            ]);

        } catch (\Exception $e) {
            \Log::error("Error in getExpensesData: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk menambah pengeluaran (AJAX)
    public function addExpense(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:500'
        ]);

        try {
            $expense = ProfitCalculation::create([
                'type' => 'expense',
                'expense_date' => $request->date,
                'expense_amount' => $request->amount,
                'expense_description' => $request->description,
                'start_date' => $request->date,
                'end_date' => $request->date,
                'total_revenue' => 0,
                'total_cost' => $request->amount,
                'total_profit' => -$request->amount,
                'total_transactions' => 0
            ]);

            return response()->json(['success' => true, 'expense' => $expense]);
        } catch (\Exception $e) {
            \Log::error("Error in addExpense: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Method untuk mendapatkan single expense (AJAX)
    public function getExpense($id)
    {
        try {
            $expense = ProfitCalculation::expenses()->find($id);

            if (!$expense) {
                return response()->json(['success' => false, 'message' => 'Expense not found'], 404);
            }

            return response()->json([
                'success' => true,
                'expense' => [
                    'id' => $expense->id,
                    'date' => $expense->expense_date->format('Y-m-d'),
                    'amount' => $expense->expense_amount,
                    'description' => $expense->expense_description
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in getExpense: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Method untuk update expense (AJAX)
    public function updateExpense(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:500'
        ]);

        try {
            $expense = ProfitCalculation::expenses()->find($id);

            if (!$expense) {
                return response()->json(['success' => false, 'message' => 'Expense not found'], 404);
            }

            $expense->update([
                'expense_date' => $request->date,
                'expense_amount' => $request->amount,
                'expense_description' => $request->description,
                'total_cost' => $request->amount,
                'total_profit' => -$request->amount
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error("Error in updateExpense: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Method untuk delete expense (AJAX)
    public function deleteExpense($id)
    {
        try {
            $expense = ProfitCalculation::expenses()->find($id);

            if (!$expense) {
                return response()->json(['success' => false, 'message' => 'Expense not found'], 404);
            }

            $expense->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error("Error in deleteExpense: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Method untuk menyimpan perhitungan laba
    public function calculate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_revenue' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $totalRevenue = $request->total_revenue;

            // Hitung total pengeluaran dalam periode
            $totalExpenses = ProfitCalculation::expenses()
                            ->whereBetween('expense_date', [$startDate, $endDate])
                            ->sum('expense_amount');

            // Hitung laba bersih
            $totalProfit = $totalRevenue - $totalExpenses;

            // Hitung margin laba
            $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;

            // Hitung jumlah transaksi
            $totalTransactions = Transaction::whereBetween('created_at', [
                $startDate . ' 00:00:00', 
                $endDate . ' 23:59:59'
            ])->count();

            // Simpan detail perhitungan
            $calculationDetails = [
                'revenue_breakdown' => [
                    'total_revenue' => $totalRevenue,
                ],
                'expense_breakdown' => [
                    'total_expenses' => $totalExpenses
                ],
                'profit_analysis' => [
                    'gross_profit' => $totalProfit,
                    'profit_margin' => $profitMargin
                ],
                'description' => $request->description
            ];

            // Simpan hasil perhitungan
            $profitCalculation = ProfitCalculation::create([
                'type' => 'profit_calculation',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_revenue' => $totalRevenue,
                'total_cost' => $totalExpenses,
                'total_profit' => $totalProfit,
                'total_transactions' => $totalTransactions,
                'calculation_details' => $calculationDetails,
                'description' => $request->description
            ]);

            return redirect()->route('admin.profit.index')
                ->with('success', 'Perhitungan laba berhasil disimpan!');
                
        } catch (\Exception $e) {
            \Log::error("Error in calculate: " . $e->getMessage());
            return redirect()->route('admin.profit.index')
                ->with('error', 'Gagal menyimpan perhitungan laba: ' . $e->getMessage());
        }
    }

    public function show(ProfitCalculation $profit)
    {
        // Pastikan hanya menampilkan profit calculation
        if ($profit->type !== 'profit_calculation') {
            abort(404);
        }

        $marginPercentage = $profit->total_revenue > 0 ? ($profit->total_profit / $profit->total_revenue) * 100 : 0;
        $width = min(max($marginPercentage, 0), 100);

        return view('admin.profit.show', compact('profit', 'marginPercentage', 'width'));
    }

    public function destroy(ProfitCalculation $profit)
    {
        try {
            $profit->delete();
            
            return redirect()->route('admin.profit.index')
                ->with('success', 'Data perhitungan laba berhasil dihapus!');
                
        } catch (\Exception $e) {
            \Log::error("Error in destroy: " . $e->getMessage());
            return redirect()->route('admin.profit.index')
                ->with('error', 'Gagal menghapus data perhitungan laba: ' . $e->getMessage());
        }
    }

    // Method untuk quick stats (jika masih diperlukan)
    public function getQuickStats(Request $request)
    {
        try {
            $period = $request->get('period', 'today');
            
            $today = Carbon::today();
            
            switch ($period) {
                case 'week':
                    $startDate = $today->copy()->startOfWeek();
                    $endDate = $today->copy()->endOfWeek();
                    break;
                case 'month':
                    $startDate = $today->copy()->startOfMonth();
                    $endDate = $today->copy()->endOfMonth();
                    break;
                default:
                    $startDate = $today;
                    $endDate = $today;
                    break;
            }

            // Hitung statistik dari data transaksi dan pengeluaran
            $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $revenue = $transactions->sum('total');
            $expenses = ProfitCalculation::expenses()
                        ->whereBetween('expense_date', [$startDate, $endDate])
                        ->sum('expense_amount');
            $profit = $revenue - $expenses;
            $margin = $revenue > 0 ? ($profit / $revenue) * 100 : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'period' => $period,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'total_revenue' => number_format($revenue, 2),
                    'total_expenses' => number_format($expenses, 2),
                    'total_profit' => number_format($profit, 2),
                    'profit_margin' => number_format($margin, 2)
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in getQuickStats: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}