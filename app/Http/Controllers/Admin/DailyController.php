<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function dailyReport(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        
        $transactions = Transaction::with(['product', 'user'])
            ->whereDate('date', $date)
            ->latest()
            ->get();
            
        $totalRevenue = $transactions->sum('total_price');
        $totalQuantity = $transactions->sum('quantity');
        
        // Produk terlaris
        $topProducts = Transaction::whereDate('date', $date)
            ->with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(total_price) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();
        
        // Transaksi per jam
        $salesByHour = Transaction::whereDate('date', $date)
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as transaction_count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
        
        // Data hari sebelumnya
        $previousDate = Carbon::parse($date)->subDay()->format('Y-m-d');
        $previousDayData = Transaction::whereDate('date', $previousDate)
            ->selectRaw('COUNT(*) as transaction_count, SUM(total_price) as revenue, SUM(quantity) as quantity')
            ->first();
        
        return view('admin.reports.daily', compact(
            'transactions', 
            'totalRevenue', 
            'totalQuantity', 
            'date',
            'topProducts',
            'salesByHour',
            'previousDayData'
        ));
    }
}
