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
        $transactionsQuery = Transaction::where('status', 'completed')
            ->latest();

        // Filter by date range
        if ($startDate && $endDate) {
            $transactionsQuery->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $transactionsQuery->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $transactionsQuery->whereDate('created_at', '<=', $endDate);
        }

        // Get transactions untuk table
        $transactions = $transactionsQuery->paginate(50);

        // Hitung statistics dari semua transaksi yang difilter
        $totalTransactions = $transactions->total();
        $totalRevenue = $transactions->sum('total');
        
        // Hitung total quantity dan total produk terjual
        $totalQuantity = 0;
        $totalProductsSold = 0;
        
        foreach ($transactions as $transaction) {
            // Gunakan items_array accessor dari model
            $items = $transaction->items_array;
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    // Filter by product
                    if ($productId && ($item['product_id'] ?? null) != $productId) {
                        continue;
                    }
                    
                    // Get product untuk filter category
                    $product = Product::find($item['product_id'] ?? null);
                    if ($category && $product && $product->category != $category) {
                        continue;
                    }
                    
                    $totalQuantity += $item['quantity'] ?? 0;
                    $totalProductsSold++;
                }
            }
        }

        // Get unique categories from products
        $categories = Product::distinct()->pluck('category')->filter();

        // Get category summary
        $categorySummary = [];
        foreach ($transactions as $transaction) {
            // Gunakan items_array accessor dari model
            $items = $transaction->items_array;
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    $product = Product::find($item['product_id'] ?? null);
                    if (!$product) continue;
                    
                    // Filter by product
                    if ($productId && $product->id != $productId) {
                        continue;
                    }
                    
                    // Filter by category
                    if ($category && $product->category != $category) {
                        continue;
                    }
                    
                    $categoryName = $product->category;
                    $quantity = $item['quantity'] ?? 0;
                    // Gunakan final_total jika ada, jika tidak gunakan total biasa
                    $totalPrice = $item['final_total'] ?? $item['total'] ?? ($quantity * ($item['price'] ?? $product->price));
                    
                    if (!isset($categorySummary[$categoryName])) {
                        $categorySummary[$categoryName] = [
                            'category' => $categoryName,
                            'total_quantity' => 0,
                            'total_revenue' => 0
                        ];
                    }
                    
                    $categorySummary[$categoryName]['total_quantity'] += $quantity;
                    $categorySummary[$categoryName]['total_revenue'] += $totalPrice;
                }
            }
        }
        
        $categorySummary = collect($categorySummary)->values();

        $products = Product::orderBy('name')->get();

        return view('admin.reports.index', compact(
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
        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->latest()
            ->get();

        // Process data untuk chart dan table
        $dailyRevenue = [];
        $productSales = [];
        $totalQuantity = 0;
        $totalProducts = 0;

        foreach ($transactions as $transaction) {
            // Daily revenue data
            $day = $transaction->created_at->format('Y-m-d');
            if (!isset($dailyRevenue[$day])) {
                $dailyRevenue[$day] = 0;
            }
            $dailyRevenue[$day] += $transaction->total;

            // Gunakan items_array accessor dari model
            $items = $transaction->items_array;
            
            if (is_array($items)) {
                foreach($items as $item) {
                    // Get product data
                    $product = Product::find($item['product_id'] ?? null);
                    
                    if (!$product) {
                        continue;
                    }
                    
                    // Filter by category
                    if ($category && $product->category != $category) {
                        continue;
                    }
                    
                    $quantity = $item['quantity'] ?? 0;
                    // Gunakan final_total jika ada, jika tidak gunakan total biasa
                    $totalPrice = $item['final_total'] ?? $item['total'] ?? ($quantity * ($item['price'] ?? $product->price));
                    
                    $totalQuantity += $quantity;
                    $totalProducts++;

                    // Product sales data untuk chart
                    if (!isset($productSales[$product->id])) {
                        $productSales[$product->id] = [
                            'product_name' => $product->name,
                            'product_category' => $product->category,
                            'total_quantity' => 0,
                            'total_revenue' => 0
                        ];
                    }
                    $productSales[$product->id]['total_quantity'] += $quantity;
                    $productSales[$product->id]['total_revenue'] += $totalPrice;
                }
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
        $categorySummary = [];
        foreach ($transactions as $transaction) {
            // Gunakan items_array accessor dari model
            $items = $transaction->items_array;
            
            if (is_array($items)) {
                foreach($items as $item) {
                    $product = Product::find($item['product_id'] ?? null);
                    if (!$product) continue;
                    
                    // Filter by category
                    if ($category && $product->category != $category) {
                        continue;
                    }
                    
                    $categoryName = $product->category;
                    $quantity = $item['quantity'] ?? 0;
                    // Gunakan final_total jika ada, jika tidak gunakan total biasa
                    $totalPrice = $item['final_total'] ?? $item['total'] ?? ($quantity * ($item['price'] ?? $product->price));
                    
                    if (!isset($categorySummary[$categoryName])) {
                        $categorySummary[$categoryName] = [
                            'category' => $categoryName,
                            'total_quantity' => 0,
                            'total_revenue' => 0
                        ];
                    }
                    
                    $categorySummary[$categoryName]['total_quantity'] += $quantity;
                    $categorySummary[$categoryName]['total_revenue'] += $totalPrice;
                }
            }
        }
        
        $categorySummary = collect($categorySummary)->values();

        // Get unique categories from products
        $categories = Product::distinct()->pluck('category')->filter();

        // Statistics
        $totalRevenue = $transactions->sum('total');

        return view('admin.reports.monthly', compact(
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
        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->latest()
            ->get();

        // Process data
        $topProducts = [];
        $salesByHour = [];
        $totalQuantity = 0;
        $totalProducts = 0;

        foreach ($transactions as $transaction) {
            // Sales by hour data
            $hour = $transaction->created_at->format('H');
            if (!isset($salesByHour[$hour])) {
                $salesByHour[$hour] = 0;
            }
            $salesByHour[$hour]++;

            // Gunakan items_array accessor dari model
            $items = $transaction->items_array;
            
            if (is_array($items)) {
                foreach($items as $item) {
                    // Get product data
                    $product = Product::find($item['product_id'] ?? null);
                    
                    if (!$product) {
                        continue;
                    }
                    
                    // Filter by category
                    if ($category && $product->category != $category) {
                        continue;
                    }
                    
                    $quantity = $item['quantity'] ?? 0;
                    // Gunakan final_total jika ada, jika tidak gunakan total biasa
                    $totalPrice = $item['final_total'] ?? $item['total'] ?? ($quantity * ($item['price'] ?? $product->price));
                    
                    $totalQuantity += $quantity;
                    $totalProducts++;

                    // Top products data
                    if (!isset($topProducts[$product->id])) {
                        $topProducts[$product->id] = (object) [
                            'product' => $product,
                            'total_quantity' => 0,
                            'total_revenue' => 0
                        ];
                    }
                    $topProducts[$product->id]->total_quantity += $quantity;
                    $topProducts[$product->id]->total_revenue += $totalPrice;
                }
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
        $categorySummary = [];
        foreach ($transactions as $transaction) {
            // Gunakan items_array accessor dari model
            $items = $transaction->items_array;
            
            if (is_array($items)) {
                foreach($items as $item) {
                    $product = Product::find($item['product_id'] ?? null);
                    if (!$product) continue;
                    
                    // Filter by category
                    if ($category && $product->category != $category) {
                        continue;
                    }
                    
                    $categoryName = $product->category;
                    $quantity = $item['quantity'] ?? 0;
                    // Gunakan final_total jika ada, jika tidak gunakan total biasa
                    $totalPrice = $item['final_total'] ?? $item['total'] ?? ($quantity * ($item['price'] ?? $product->price));
                    
                    if (!isset($categorySummary[$categoryName])) {
                        $categorySummary[$categoryName] = [
                            'category' => $categoryName,
                            'total_quantity' => 0,
                            'total_revenue' => 0
                        ];
                    }
                    
                    $categorySummary[$categoryName]['total_quantity'] += $quantity;
                    $categorySummary[$categoryName]['total_revenue'] += $totalPrice;
                }
            }
        }
        
        $categorySummary = collect($categorySummary)->values();

        // Get unique categories from products
        $categories = Product::distinct()->pluck('category')->filter();

        // Statistics
        $totalRevenue = $transactions->sum('total');

        // Previous day comparison
        $previousDate = Carbon::parse($date)->subDay();
        $previousDayTransactions = Transaction::whereDate('created_at', $previousDate)
            ->where('status', 'completed')
            ->get();

        $previousDayData = [
            'transaction_count' => $previousDayTransactions->count(),
            'revenue' => $previousDayTransactions->sum('total'),
            'quantity' => $previousDayTransactions->sum(function($transaction) {
                // Gunakan items_array accessor dari model
                $items = $transaction->items_array;
                return is_array($items) ? array_sum(array_column($items, 'quantity')) : 0;
            })
        ];

        return view('admin.reports.daily', compact(
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