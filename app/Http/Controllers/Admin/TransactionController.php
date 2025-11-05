<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate(10);
        
        // Get today's statistics
        $today = now()->format('Y-m-d');
        $todayStats = Transaction::whereDate('created_at', $today)
            ->select(
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total) as total_revenue'),
                DB::raw('AVG(total) as average_transaction')
            )
            ->first();

        return view('admin.transactions.index', compact('transactions', 'todayStats'));
    }

    public function create()
    {
        $transactionCode = 'TRX-' . date('Ymd') . '-' . rand(1000, 9999);
        
        // Hapus kondisi is_active jika kolom tidak ada
        $products = Product::where('stock', '>', 0) // Hanya produk dengan stok > 0
            ->orderBy('name')
            ->get();
            
        return view('admin.transactions.create', compact('transactionCode', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,debit_card,credit_card,qris,transfer',
            'cash_paid' => 'required_if:payment_method,cash|numeric|min:0',
            'change_amount' => 'required_if:payment_method,cash|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Update product stock
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi");
                }
                $product->decrement('stock', $item['quantity']);
            }

            $transaction = Transaction::create([
                'transaction_code' => $request->transaction_code,
                'customer_name' => $request->customer_name,
                'items' => $request->items,
                'subtotal' => $request->subtotal,
                'tax' => $request->tax,
                'discount' => $request->discount,
                'total' => $request->total,
                'payment_method' => $request->payment_method,
                'cash_paid' => $request->cash_paid ?? 0,
                'change_amount' => $request->change_amount ?? 0,
                'status' => 'completed',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan!',
                'transaction_id' => $transaction->id,
                'print_url' => route('admin.transactions.print', $transaction->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('admin.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        // Implement update logic if needed
        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    // Method untuk print receipt
    public function printReceipt($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('admin.transactions.print', compact('transaction'));
    }

    // Method untuk get product data
    public function getProduct($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'formatted_price' => 'Rp ' . number_format($product->price, 0, ',', '.')
        ]);
    }

    // Method untuk today sales
    public function getTodaySales()
    {
        $today = now()->format('Y-m-d');
        
        $sales = Transaction::whereDate('created_at', $today)
            ->select(
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total) as total_revenue'),
                DB::raw('AVG(total) as average_transaction')
            )
            ->first();

        return response()->json([
            'total_transactions' => $sales->total_transactions ?? 0,
            'total_revenue' => $sales->total_revenue ?? 0,
            'average_transaction' => $sales->average_transaction ?? 0
        ]);
    }
}