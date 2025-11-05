<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Today's date
        $today = now()->format('Y-m-d');
        
        // Today's statistics
        $todayStats = Transaction::whereDate('created_at', $today)
            ->select(
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total) as total_revenue'),
                DB::raw('AVG(total) as average_transaction')
            )
            ->first();

        // Monthly statistics
        $monthlyStats = Transaction::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->select(
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->first();

        // Product statistics
        $productStats = Product::select(
                DB::raw('COUNT(*) as total_products'),
                DB::raw('SUM(stock) as total_stock'),
                DB::raw('SUM(CASE WHEN stock = 0 THEN 1 ELSE 0 END) as out_of_stock')
            )
            ->first();

        // Recent transactions
        $recentTransactions = Transaction::latest()
            ->take(5)
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '>', 0)
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->take(5)
            ->get();

        // Recent testimonials (tanpa filter status)
        $recentTestimonials = Testimonial::latest()
            ->take(3)
            ->get();

        return view('admin.dashboard', compact(
            'todayStats',
            'monthlyStats',
            'productStats',
            'recentTransactions',
            'lowStockProducts',
            'recentTestimonials'
        ));
    }
}