<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $productId = $request->get('product_id');
        $category = $request->get('category');

        // Query transactions dengan filter
        $transactionsQuery = Transaction::with([])
            ->filterByDate($startDate, $endDate)
            ->filterByProduct($productId)
            ->where('status', 'completed')
            ->latest();

        // Get transactions untuk table
        $transactions = $transactionsQuery->paginate(50);

        // Process transactions untuk display di table
        $reportData = [];
        $totalProductsSold = 0;
        $totalQuantity = 0;

        foreach ($transactions as $transaction) {
            $items = $transaction->getTransactionItems();
            foreach ($items as $item) {
                // Filter by category
                if ($category && $item->product_category != $category) {
                    continue;
                }
                
                // Filter by product
                if ($productId && $item->product_id != $productId) {
                    continue;
                }
                
                $reportData[] = (object) [
                    'date' => $transaction->created_at,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'product_category' => $item->product_category,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product_price,
                    'total_price' => $item->total_price,
                    'customer_name' => $transaction->customer_name,
                    'transaction_code' => $transaction->transaction_code,
                    'product' => (object) [
                        'name' => $item->product_name,
                        'category' => $item->product_category,
                        'price' => $item->product_price,
                        'image' => $item->product->image ?? null
                    ]
                ];
                $totalProductsSold++;
                $totalQuantity += $item->quantity;
            }
        }

        // Hitung statistics
        $totalTransactions = $transactions->count();
        $totalRevenue = $transactions->sum('total');

        // Get unique categories from products
        $categories = Product::distinct()->pluck('category')->filter();

        // Get category summary
        $categorySummary = collect($reportData)->groupBy('product_category')->map(function ($items, $category) {
            return (object) [
                'category' => $category,
                'total_quantity' => $items->sum('quantity'),
                'total_revenue' => $items->sum('total_price')
            ];
        })->values();

        $products = Product::orderBy('name')->get();

        return view('admin.reports.index', compact(
            'reportData',
            'transactions',
            'totalProductsSold',
            'totalTransactions',
            'totalRevenue',
            'totalQuantity',
            'products',
            'categories',
            'categorySummary',
            'startDate',
            'endDate',
            'productId',
            'category'
        ));
    }

    public function monthly(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $category = $request->get('category');
        
        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate = Carbon::parse($month)->endOfMonth();

        // Get transactions for the month
        $transactions = Transaction::with([])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->latest()
            ->get();

        // Process data untuk chart dan table
        $reportData = [];
        $dailyRevenue = [];
        $productSales = [];
        $totalQuantity = 0;

        foreach ($transactions as $transaction) {
            $items = $transaction->getTransactionItems();
            
            // Daily revenue data
            $day = $transaction->created_at->format('Y-m-d');
            if (!isset($dailyRevenue[$day])) {
                $dailyRevenue[$day] = 0;
            }
            $dailyRevenue[$day] += $transaction->total;

            foreach ($items as $item) {
                // Filter by category
                if ($category && $item->product_category != $category) {
                    continue;
                }
                
                // Report data untuk table
                $reportData[] = (object) [
                    'date' => $transaction->created_at,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'product_category' => $item->product_category,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product_price,
                    'total_price' => $item->total_price,
                    'customer_name' => $transaction->customer_name,
                    'transaction_code' => $transaction->transaction_code,
                    'product' => (object) [
                        'name' => $item->product_name,
                        'category' => $item->product_category,
                        'price' => $item->product_price,
                        'image' => $item->product->image ?? null
                    ],
                    'user' => (object) [
                        'name' => 'System'
                    ]
                ];

                $totalQuantity += $item->quantity;

                // Product sales data untuk chart
                if (!isset($productSales[$item->product_id])) {
                    $productSales[$item->product_id] = [
                        'product_name' => $item->product_name,
                        'product_category' => $item->product_category,
                        'total_quantity' => 0,
                        'total_revenue' => 0
                    ];
                }
                $productSales[$item->product_id]['total_quantity'] += $item->quantity;
                $productSales[$item->product_id]['total_revenue'] += $item->total_price;
            }
        }

        // Format data untuk chart
        $dailyRevenueChart = collect($dailyRevenue)->map(function ($revenue, $date) {
            return [
                'date' => Carbon::parse($date)->format('d M'),
                'revenue' => $revenue
            ];
        })->values();

        $productSalesChart = collect($productSales)->sortByDesc('total_quantity')->take(10)->values();

        // Get category summary
        $categorySummary = collect($reportData)->groupBy('product_category')->map(function ($items, $category) {
            return (object) [
                'category' => $category,
                'total_quantity' => $items->sum('quantity'),
                'total_revenue' => $items->sum('total_price')
            ];
        })->values();

        // Get unique categories from products
        $categories = Product::distinct()->pluck('category')->filter();

        // Statistics
        $totalRevenue = $transactions->sum('total');
        $totalProducts = count(array_unique(array_column($reportData, 'product_id')));

        return view('admin.reports.monthly', compact(
            'reportData',
            'transactions',
            'dailyRevenueChart',
            'productSalesChart',
            'categorySummary',
            'categories',
            'totalRevenue',
            'totalQuantity',
            'totalProducts',
            'month',
            'category'
        ));
    }

    public function daily(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $category = $request->get('category');
        
        $startDate = Carbon::parse($date)->startOfDay();
        $endDate = Carbon::parse($date)->endOfDay();

        // Get transactions for the day
        $transactions = Transaction::with([])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->latest()
            ->get();

        // Process data
        $reportData = [];
        $topProducts = [];
        $salesByHour = [];
        $totalQuantity = 0;

        foreach ($transactions as $transaction) {
            $items = $transaction->getTransactionItems();
            
            // Sales by hour data
            $hour = $transaction->created_at->format('H');
            if (!isset($salesByHour[$hour])) {
                $salesByHour[$hour] = 0;
            }
            $salesByHour[$hour]++;

            foreach ($items as $item) {
                // Filter by category
                if ($category && $item->product_category != $category) {
                    continue;
                }
                
                // Report data untuk table
                $reportData[] = (object) [
                    'created_at' => $transaction->created_at,
                    'date' => $transaction->created_at,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'product_category' => $item->product_category,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product_price,
                    'total_price' => $item->total_price,
                    'customer_name' => $transaction->customer_name,
                    'transaction_code' => $transaction->transaction_code,
                    'product' => (object) [
                        'name' => $item->product_name,
                        'category' => $item->product_category,
                        'price' => $item->product_price,
                        'image' => $item->product->image ?? null
                    ],
                    'user' => (object) [
                        'name' => 'System'
                    ]
                ];

                $totalQuantity += $item->quantity;

                // Top products data
                if (!isset($topProducts[$item->product_id])) {
                    $topProducts[$item->product_id] = (object) [
                        'product' => (object) [
                            'name' => $item->product_name,
                            'category' => $item->product_category,
                            'image' => $item->product->image ?? null
                        ],
                        'total_quantity' => 0,
                        'total_revenue' => 0
                    ];
                }
                $topProducts[$item->product_id]->total_quantity += $item->quantity;
                $topProducts[$item->product_id]->total_revenue += $item->total_price;
            }
        }

        // Format data
        $topProducts = collect($topProducts)->sortByDesc('total_quantity')->take(5)->values();
        $salesByHour = collect($salesByHour)->map(function ($count, $hour) {
            return (object) [
                'hour' => $hour,
                'transaction_count' => $count
            ];
        })->sortBy('hour')->values();

        // Get category summary
        $categorySummary = collect($reportData)->groupBy('product_category')->map(function ($items, $category) {
            return (object) [
                'category' => $category,
                'total_quantity' => $items->sum('quantity'),
                'total_revenue' => $items->sum('total_price')
            ];
        })->values();

        // Get unique categories from products
        $categories = Product::distinct()->pluck('category')->filter();

        // Statistics
        $totalRevenue = $transactions->sum('total');
        $totalProducts = count(array_unique(array_column($reportData, 'product_id')));

        // Previous day comparison
        $previousDate = Carbon::parse($date)->subDay();
        $previousDayTransactions = Transaction::whereDate('created_at', $previousDate)
            ->where('status', 'completed')
            ->get();

        $previousDayData = [
            'transaction_count' => $previousDayTransactions->count(),
            'revenue' => $previousDayTransactions->sum('total'),
            'quantity' => $previousDayTransactions->sum('total_quantity')
        ];

        return view('admin.reports.daily', compact(
            'reportData',
            'transactions',
            'topProducts',
            'salesByHour',
            'categorySummary',
            'categories',
            'totalRevenue',
            'totalQuantity',
            'totalProducts',
            'date',
            'category',
            'previousDayData'
        ));
    }
}