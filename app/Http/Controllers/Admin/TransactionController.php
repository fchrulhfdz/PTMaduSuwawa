<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
{
    $transactions = \App\Models\Transaction::with('product', 'user')->latest()->paginate(10);
    $products = \App\Models\Product::all(); // ✅ Tambahkan baris ini

    return view('admin.transactions.index', compact('transactions', 'products'));
}


    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('admin.transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date'
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::findOrFail($validated['product_id']);
            
            if ($product->stock < $validated['quantity']) {
                throw new \Exception('Stok produk tidak mencukupi');
            }

            $totalPrice = $product->price * $validated['quantity'];

            Transaction::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'total_price' => $totalPrice,
                'date' => $validated['date']
            ]);

            // Update stock
            $product->decrement('stock', $validated['quantity']);
        });

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function destroy(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            // Restore stock
            $transaction->product->increment('stock', $transaction->quantity);
            
            $transaction->delete();
        });

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}