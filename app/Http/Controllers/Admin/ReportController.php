<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['product', 'user']);
        
        // Filter tanggal
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }
        
        // Filter produk
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }
        
        $transactions = $query->latest()->paginate(15);
        
        // Statistik
        $totalTransactions = $query->count();
        $totalProductsSold = $query->distinct('product_id')->count('product_id');
        $totalQuantity = $query->sum('quantity');
        $totalRevenue = $query->sum('total_price');
        
        $products = Product::all();
        
        return view('admin.reports.index', compact(
            'transactions', 
            'products', 
            'totalTransactions',
            'totalProductsSold',
            'totalQuantity',
            'totalRevenue'
        ));
    }

    public function dailyReport(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        
        $transactions = Transaction::with(['product', 'user'])
            ->whereDate('date', $date)
            ->latest()
            ->get();
            
        $totalRevenue = $transactions->sum('total_price');
        $totalQuantity = $transactions->sum('quantity');
        
        return view('admin.reports.daily', compact('transactions', 'totalRevenue', 'totalQuantity', 'date'));
    }

    public function monthlyReport(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        
        $transactions = Transaction::with(['product', 'user'])
            ->whereYear('date', substr($month, 0, 4))
            ->whereMonth('date', substr($month, 5, 2))
            ->latest()
            ->get();
            
        $totalRevenue = $transactions->sum('total_price');
        $totalQuantity = $transactions->sum('quantity');
        
        return view('admin.reports.monthly', compact('transactions', 'totalRevenue', 'totalQuantity', 'month'));
    }
}