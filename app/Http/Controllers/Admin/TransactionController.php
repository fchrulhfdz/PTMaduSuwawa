<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::latest();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan payment method
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }
        
        $transactions = $query->paginate(10);
        
        // Get today's statistics
        $today = now()->format('Y-m-d');
        $todayStats = Transaction::whereDate('created_at', $today)
            ->select(
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('COALESCE(SUM(total), 0) as total_revenue'),
                DB::raw('COALESCE(AVG(total), 0) as average_transaction'),
                DB::raw('COALESCE(SUM(total_berat), 0) as total_berat')
            )
            ->first();

        return view('admin.transactions.index', compact('transactions', 'todayStats'));
    }

    public function create()
    {
        $transactionCode = 'TRX-' . date('YmdHis') . '-' . rand(100, 999);
        
        $products = Product::where('stock', '>', 0)
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
            'payment_method' => 'required|string|in:cash,transfer',
            'cash_paid' => 'required_if:payment_method,cash|numeric|min:0',
            'change_amount' => 'required_if:payment_method,cash|numeric|min:0',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Update product stock dan proses items
            $itemsWithNames = [];
            $totalBerat = 0;
            $totalQuantity = 0;

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan");
                }
                
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}");
                }
                
                // Update stock
                $product->decrement('stock', $item['quantity']);
                
                // Hitung total quantity
                $totalQuantity += $item['quantity'];
                
                // Hitung berat
                $beratItem = $item['berat_isi'] ?? $product->berat_isi ?? 0;
                $satuanBerat = $item['satuan_berat'] ?? $product->satuan_berat ?? 'g';
                $totalBeratItem = $beratItem * $item['quantity'];
                $totalBerat += $totalBeratItem;
                
                // Siapkan data item
                $itemsWithNames[] = [
                    'product_id' => $item['product_id'],
                    'name' => $product->name,
                    'price' => $item['price'] ?? $product->price,
                    'quantity' => $item['quantity'],
                    'total' => ($item['price'] ?? $product->price) * $item['quantity'],
                    'discount_percentage' => $item['discount_percentage'] ?? 0,
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'final_total' => $item['final_total'] ?? (($item['price'] ?? $product->price) * $item['quantity']),
                    'original_price' => $product->price,
                    'berat_isi' => $beratItem,
                    'satuan_berat' => $satuanBerat,
                    'total_berat_item' => $totalBeratItem
                ];
            }

            // Tentukan status
            $status = $request->payment_method === 'cash' ? 'completed' : 'pending';

            $transaction = Transaction::create([
                'transaction_code' => $request->transaction_code,
                'customer_name' => $request->customer_name,
                'quantity' => $totalQuantity,
                'items' => $itemsWithNames, // Langsung array, karena sudah di-cast
                'subtotal' => $request->subtotal,
                'tax' => $request->tax,
                'discount' => $request->discount,
                'total' => $request->total,
                'payment_method' => $request->payment_method,
                'cash_paid' => $request->cash_paid ?? 0,
                'change_amount' => $request->change_amount ?? 0,
                'status' => $status,
                'total_berat' => $totalBerat,
                'notes' => $request->notes
            ]);

            DB::commit();

            $message = $request->payment_method === 'cash' 
                ? 'Transaksi berhasil disimpan!' 
                : 'Transaksi berhasil! Silakan lakukan transfer pembayaran.';

            return response()->json([
                'success' => true,
                'message' => $message,
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

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('admin.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'payment_method' => 'required|string|in:cash,transfer',
            'status' => 'required|string|in:pending,completed,cancelled',
            'notes' => 'nullable|string|max:500'
        ]);

        $transaction = Transaction::findOrFail($id);
        
        $transaction->update([
            'customer_name' => $request->customer_name,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Kembalikan stok produk
            $items = $transaction->items_array;
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->increment('stock', $item['quantity']);
                    }
                }
            }
            
            $transaction->delete();
            
            DB::commit();
            
            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaksi berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.transactions.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function printReceipt($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('admin.transactions.print', compact('transaction'));
    }

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
            'berat_isi' => $product->berat_isi ?? 0,
            'satuan_berat' => $product->satuan_berat ?? 'g',
            'category' => $product->category,
            'formatted_price' => 'Rp ' . number_format($product->price, 0, ',', '.')
        ]);
    }

    public function getTodaySales()
    {
        $today = now()->format('Y-m-d');
        
        $sales = Transaction::whereDate('created_at', $today)
            ->select(
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('COALESCE(SUM(total), 0) as total_revenue'),
                DB::raw('COALESCE(AVG(total), 0) as average_transaction'),
                DB::raw('COALESCE(SUM(total_berat), 0) as total_berat')
            )
            ->first();

        return response()->json([
            'total_transactions' => $sales->total_transactions ?? 0,
            'total_revenue' => $sales->total_revenue ?? 0,
            'average_transaction' => $sales->average_transaction ?? 0,
            'total_berat' => $sales->total_berat ?? 0
        ]);
    }

    public function confirmPayment($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            
            if ($transaction->payment_method !== 'transfer') {
                return redirect()->back()
                    ->with('error', 'Hanya transaksi transfer yang dapat dikonfirmasi');
            }
            
            if ($transaction->status === 'completed') {
                return redirect()->back()
                    ->with('error', 'Transaksi sudah dikonfirmasi sebelumnya');
            }
            
            $transaction->update([
                'status' => 'completed'
            ]);
            
            return redirect()->route('admin.transactions.index')
                ->with('success', 'Pembayaran transfer berhasil dikonfirmasi!');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.transactions.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancelTransaction($id)
    {
        try {
            DB::beginTransaction();
            
            $transaction = Transaction::findOrFail($id);
            
            if ($transaction->status === 'cancelled') {
                return redirect()->back()
                    ->with('error', 'Transaksi sudah dibatalkan sebelumnya');
            }
            
            // Kembalikan stok produk
            $items = $transaction->items_array;
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->increment('stock', $item['quantity']);
                    }
                }
            }
            
            $transaction->update([
                'status' => 'cancelled'
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaksi berhasil dibatalkan! Stok produk telah dikembalikan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.transactions.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}