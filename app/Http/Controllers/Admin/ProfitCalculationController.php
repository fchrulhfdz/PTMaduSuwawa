<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfitCalculation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitCalculationController extends Controller
{
    public function index()
    {
        $calculations = ProfitCalculation::latest()->paginate(10);
        
        // Hitung statistik dari database
        $today = Carbon::today();
        
        // Laba Hari Ini - berdasarkan created_at
        $todayCalculations = ProfitCalculation::whereDate('created_at', $today)->get();
        $todayProfit = $todayCalculations->sum('total_profit');
        $todayRevenue = $todayCalculations->sum('total_revenue');
        $todayMargin = $todayRevenue > 0 ? ($todayProfit / $todayRevenue) * 100 : 0;
        
        // Laba Minggu Ini
        $weekStart = $today->copy()->startOfWeek();
        $weekEnd = $today->copy()->endOfWeek();
        $weekCalculations = ProfitCalculation::whereBetween('created_at', [$weekStart, $weekEnd])->get();
        $weekProfit = $weekCalculations->sum('total_profit');
        $weekRevenue = $weekCalculations->sum('total_revenue');
        $weekMargin = $weekRevenue > 0 ? ($weekProfit / $weekRevenue) * 100 : 0;
        
        // Laba Bulan Ini
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();
        $monthCalculations = ProfitCalculation::whereBetween('created_at', [$monthStart, $monthEnd])->get();
        $monthProfit = $monthCalculations->sum('total_profit');
        $monthRevenue = $monthCalculations->sum('total_revenue');
        $monthMargin = $monthRevenue > 0 ? ($monthProfit / $monthRevenue) * 100 : 0;
        
        // Total Perhitungan
        $totalCalculations = ProfitCalculation::count();

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

    public function calculate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_revenue' => 'required|numeric|min:0',
            'operational_costs' => 'required|numeric|min:0',
            'product_costs' => 'required|numeric|min:0',
            'other_costs' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:500'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $totalRevenue = $request->total_revenue;
        $operationalCosts = $request->operational_costs;
        $productCosts = $request->product_costs;
        $otherCosts = $request->other_costs ?? 0;

        // Hitung total biaya
        $totalCost = $operationalCosts + $productCosts + $otherCosts;
        
        // Hitung laba bersih
        $totalProfit = $totalRevenue - $totalCost;

        // Hitung margin laba
        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;

        // Simpan detail perhitungan
        $calculationDetails = [
            'revenue_breakdown' => [
                'total_revenue' => $totalRevenue,
            ],
            'cost_breakdown' => [
                'operational_costs' => $operationalCosts,
                'product_costs' => $productCosts,
                'other_costs' => $otherCosts,
                'total_costs' => $totalCost
            ],
            'profit_analysis' => [
                'gross_profit' => $totalProfit,
                'profit_margin' => $profitMargin
            ],
            'description' => $request->description
        ];

        // Simpan hasil perhitungan
        $profitCalculation = ProfitCalculation::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_revenue' => $totalRevenue,
            'total_cost' => $totalCost,
            'total_profit' => $totalProfit,
            'total_transactions' => 0,
            'calculation_details' => $calculationDetails,
            'description' => $request->description
        ]);

        return redirect()->route('admin.profit.index')
            ->with('success', 'Perhitungan laba berhasil disimpan!');
    }

    public function show(ProfitCalculation $profit)
    {
        // Hitung margin laba untuk ditampilkan
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
            return redirect()->route('admin.profit.index')
                ->with('error', 'Gagal menghapus data perhitungan laba: ' . $e->getMessage());
        }
    }

    // Method untuk AJAX quick stats (jika masih diperlukan)
    public function getQuickStats(Request $request)
    {
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

        // Hitung statistik dari data perhitungan yang sudah disimpan
        $calculations = ProfitCalculation::whereBetween('created_at', [$startDate, $endDate])->get();

        $totalRevenue = $calculations->sum('total_revenue');
        $totalCost = $calculations->sum('total_cost');
        $totalProfit = $calculations->sum('total_profit');
        $totalCalculations = $calculations->count();

        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'period' => $period,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'total_revenue' => number_format($totalRevenue, 2),
                'total_cost' => number_format($totalCost, 2),
                'total_profit' => number_format($totalProfit, 2),
                'total_transactions' => $totalCalculations,
                'profit_margin' => number_format($profitMargin, 2)
            ]
        ]);
    }
}   