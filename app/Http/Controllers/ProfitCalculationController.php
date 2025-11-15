<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProfitCalculation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfitCalculationController extends Controller
{
    public function index()
    {
        try {
            $calculations = ProfitCalculation::profitCalculations()->latest()->paginate(10);
            
            $today = Carbon::today();
            
            // Hitung statistik dengan method reusable
            $todayStats = $this->calculatePeriodStats($today, $today);
            $weekStats = $this->calculatePeriodStats($today->copy()->startOfWeek(), $today->copy()->endOfWeek());
            $monthStats = $this->calculatePeriodStats($today->copy()->startOfMonth(), $today->copy()->endOfMonth());
            
            // Map stats ke variabel individual untuk kompatibilitas dengan view
            $todayProfit = $todayStats['profit'] ?? 0;
            $todayMargin = $todayStats['margin'] ?? 0;
            $weekProfit = $weekStats['profit'] ?? 0;
            $weekMargin = $weekStats['margin'] ?? 0;
            $monthProfit = $monthStats['profit'] ?? 0;
            $monthMargin = $monthStats['margin'] ?? 0;
            
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

        } catch (\Exception $e) {
            Log::error('Error in ProfitCalculationController@index: ' . $e->getMessage());
            
            // Return default values in case of error
            return view('admin.profit.index', [
                'calculations' => [],
                'todayProfit' => 0,
                'todayMargin' => 0,
                'weekProfit' => 0,
                'weekMargin' => 0,
                'monthProfit' => 0,
                'monthMargin' => 0,
                'totalCalculations' => 0
            ]);
        }
    }

    // Method reusable untuk menghitung statistik periode
    private function calculatePeriodStats($startDate, $endDate)
    {
        try {
            $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $revenue = $transactions->sum('total');
            
            $expenses = ProfitCalculation::expenses()
                        ->whereBetween('expense_date', [$startDate, $endDate])
                        ->sum('expense_amount');
                        
            $profit = $revenue - $expenses;
            $margin = $revenue > 0 ? ($profit / $revenue) * 100 : 0;

            return [
                'revenue' => $revenue,
                'expenses' => $expenses,
                'profit' => $profit,
                'margin' => $margin,
                'transaction_count' => $transactions->count()
            ];
        } catch (\Exception $e) {
            Log::error('Error in calculatePeriodStats: ' . $e->getMessage());
            return [
                'revenue' => 0,
                'expenses' => 0,
                'profit' => 0,
                'margin' => 0,
                'transaction_count' => 0
            ];
        }
    }

    // Method untuk mendapatkan data pendapatan berdasarkan periode (AJAX)
    public function getRevenueData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        try {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();

            Log::info("Fetching revenue data from {$start} to {$end}");

            $transactions = Transaction::whereBetween('created_at', [$start, $end])->get();
            Log::info("Found {$transactions->count()} transactions in period");

            $revenueData = [];
            $totalRevenue = 0;

            foreach ($transactions as $transaction) {
                Log::info("Processing transaction: {$transaction->id}, Total: {$transaction->total}");
                
                $items = $transaction->items_array;
                
                if (empty($items)) {
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
            $yesterday = Carbon::parse($request->start_date)->subDay();
            $yesterdayRevenue = Transaction::whereDate('created_at', $yesterday)->sum('total');

            Log::info("Total Revenue: {$totalRevenue}, Yesterday Revenue: {$yesterdayRevenue}");

            return response()->json([
                'success' => true,
                'revenueData' => $revenueData,
                'totalRevenue' => $totalRevenue,
                'yesterdayRevenue' => $yesterdayRevenue,
                'overallRevenue' => $totalRevenue
            ]);

        } catch (\Exception $e) {
            Log::error("Error in getRevenueData: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk mendapatkan data pengeluaran berdasarkan periode (AJAX)
    public function getExpensesData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        try {
            $expenses = ProfitCalculation::expenses()
                        ->whereBetween('expense_date', [$request->start_date, $request->end_date])
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
            Log::error("Error in getExpensesData: " . $e->getMessage());
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
            Log::error("Error in addExpense: " . $e->getMessage());
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
            Log::error("Error in getExpense: " . $e->getMessage());
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
            Log::error("Error in updateExpense: " . $e->getMessage());
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
            Log::error("Error in deleteExpense: " . $e->getMessage());
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
            Log::error("Error in calculate: " . $e->getMessage());
            return redirect()->route('admin.profit.index')
                ->with('error', 'Gagal menyimpan perhitungan laba: ' . $e->getMessage());
        }
    }

    public function show(ProfitCalculation $profit)
    {
        try {
            // Pastikan hanya menampilkan profit calculation
            if ($profit->type !== 'profit_calculation') {
                abort(404);
            }

            $marginPercentage = $profit->total_revenue > 0 ? ($profit->total_profit / $profit->total_revenue) * 100 : 0;
            $width = min(max($marginPercentage, 0), 100);

            return view('admin.profit.show', compact('profit', 'marginPercentage', 'width'));
        } catch (\Exception $e) {
            Log::error("Error in show: " . $e->getMessage());
            return redirect()->route('admin.profit.index')
                ->with('error', 'Gagal menampilkan detail perhitungan laba: ' . $e->getMessage());
        }
    }

    public function destroy(ProfitCalculation $profit)
    {
        try {
            $profit->delete();
            
            return redirect()->route('admin.profit.index')
                ->with('success', 'Data perhitungan laba berhasil dihapus!');
                
        } catch (\Exception $e) {
            Log::error("Error in destroy: " . $e->getMessage());
            return redirect()->route('admin.profit.index')
                ->with('error', 'Gagal menghapus data perhitungan laba: ' . $e->getMessage());
        }
    }

    // Method untuk quick stats
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

            $stats = $this->calculatePeriodStats($startDate, $endDate);

            return response()->json([
                'success' => true,
                'data' => [
                    'period' => $period,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'total_revenue' => number_format($stats['revenue'], 2),
                    'total_expenses' => number_format($stats['expenses'], 2),
                    'total_profit' => number_format($stats['profit'], 2),
                    'profit_margin' => number_format($stats['margin'], 2)
                ]
            ]);
        } catch (\Exception $e) {
            Log::error("Error in getQuickStats: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}