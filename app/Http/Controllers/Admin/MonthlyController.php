<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function monthlyReport(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $year = substr($month, 0, 4);
        $monthNum = substr($month, 5, 2);
        
        $transactions = Transaction::with(['product', 'user'])
            ->whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->latest()
            ->get();
            
        $totalRevenue = $transactions->sum('total_price');
        $totalQuantity = $transactions->sum('quantity');
        
        $dailyRevenue = Transaction::whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->selectRaw('DATE(date) as date, SUM(total_price) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('d M'),
                    'revenue' => $item->revenue
                ];
            });
        
        $productSales = Transaction::whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->get()
            ->map(function($item) {
                return [
                    'product_name' => $item->product->name ?? 'Produk tidak ditemukan',
                    'total_quantity' => $item->total_quantity
                ];
            });
        
        return view('admin.reports.monthly', compact(
            'transactions', 
            'totalRevenue', 
            'totalQuantity', 
            'month',
            'dailyRevenue',
            'productSales'
        ));
    }
}
