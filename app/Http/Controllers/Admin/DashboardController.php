<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalProducts = Product::count();
        $totalSalesToday = Transaction::whereDate('date', today())->sum('quantity');
        $totalRevenue = Transaction::whereDate('date', today())->sum('total_price');
        
        // Transaksi terbaru
        $recentTransactions = Transaction::with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // 🔹 Tambahkan actions (menu cepat)
        $actions = [
            [
                'label' => 'Kelola Produk',
                'icon' => 'fas fa-box',
                'route' => 'admin.products.index',
                'color' => 'from-yellow-400 to-yellow-600',
            ],
            [
                'label' => 'Transaksi',
                'icon' => 'fas fa-receipt',
                'route' => 'admin.transactions.index',
                'color' => 'from-green-400 to-green-600',
            ],
            [
                'label' => 'Laporan Penjualan',
                'icon' => 'fas fa-chart-line',
                'route' => 'admin.reports.index',
                'color' => 'from-blue-400 to-blue-600',
            ],
            [
                'label' => 'Pengaturan',
                'icon' => 'fas fa-cogs',
                'route' => 'admin.settings.index',
                'color' => 'from-gray-400 to-gray-600',
            ],
        ];

        // Kirim ke view
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalSalesToday',
            'totalRevenue',
            'recentTransactions',
            'actions'
        ));
    }
}
