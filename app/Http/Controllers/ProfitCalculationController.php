<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfitCalculation;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfitCalculationController extends Controller
{
    public function index()
    {
        $calculations = ProfitCalculation::latest()->paginate(10);
        return view('admin.profit.index', compact('calculations'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Hitung total revenue, cost, dan profit dari transaksi
        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->with('details.product')
            ->get();

        $totalRevenue = 0;
        $totalCost = 0;
        $totalTransactions = $transactions->count();
        $calculationDetails = [];

        foreach ($transactions as $transaction) {
            foreach ($transaction->details as $detail) {
                $revenue = $detail->quantity * $detail->unit_price;
                $cost = $detail->quantity * ($detail->product->purchase_price ?? 0);
                $profit = $revenue - $cost;

                $totalRevenue += $revenue;
                $totalCost += $cost;

                $calculationDetails[] = [
                    'transaction_id' => $transaction->id,
                    'product_id' => $detail->product_id,
                    'product_name' => $detail->product->name,
                    'quantity' => $detail->quantity,
                    'unit_price' => $detail->unit_price,
                    'purchase_price' => $detail->product->purchase_price ?? 0,
                    'revenue' => $revenue,
                    'cost' => $cost,
                    'profit' => $profit,
                    'transaction_date' => $transaction->transaction_date
                ];
            }
        }

        $totalProfit = $totalRevenue - $totalCost;

        // Simpan hasil perhitungan
        $profitCalculation = ProfitCalculation::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_revenue' => $totalRevenue,
            'total_cost' => $totalCost,
            'total_profit' => $totalProfit,
            'total_transactions' => $totalTransactions,
            'calculation_details' => $calculationDetails
        ]);

        return redirect()->route('admin.profit.index')
            ->with('success', 'Perhitungan laba berhasil disimpan!');
    }

    public function show(ProfitCalculation $profit)
    {
        return view('admin.profit.show', compact('profit'));
    }

    public function destroy(ProfitCalculation $profit)
    {
        $profit->delete();
        
        return redirect()->route('admin.profit.index')
            ->with('success', 'Data perhitungan laba berhasil dihapus!');
    }

    public function getQuickStats(Request $request)
    {
        $period = $request->get('period', 'today'); // today, week, month
        
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
            default: // today
                $startDate = $today;
                $endDate = $today;
                break;
        }

        $transactions = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->with('details.product')
            ->get();

        $totalRevenue = 0;
        $totalCost = 0;

        foreach ($transactions as $transaction) {
            foreach ($transaction->details as $detail) {
                $revenue = $detail->quantity * $detail->unit_price;
                $cost = $detail->quantity * ($detail->product->purchase_price ?? 0);
                
                $totalRevenue += $revenue;
                $totalCost += $cost;
            }
        }

        $totalProfit = $totalRevenue - $totalCost;

        return response()->json([
            'success' => true,
            'data' => [
                'period' => $period,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'total_revenue' => number_format($totalRevenue, 2),
                'total_cost' => number_format($totalCost, 2),
                'total_profit' => number_format($totalProfit, 2),
                'total_transactions' => $transactions->count(),
                'profit_margin' => $totalRevenue > 0 ? number_format(($totalProfit / $totalRevenue) * 100, 2) : 0
            ]
        ]);
    }
}