<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'customer_name',
        'items',
        'subtotal',
        'tax',
        'discount',
        'total',
        'payment_method',
        'cash_paid',
        'change_amount',
        'status'
    ];

    protected $casts = [
        'items' => 'array',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'cash_paid' => 'decimal:2',
        'change_amount' => 'decimal:2',
    ];

    // Method untuk mendapatkan data produk dari items JSON
    public function getTransactionItems()
    {
        $items = $this->items ?? [];
        $transactionItems = [];

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $transactionItems[] = (object) [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'product_category' => $product->category,
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total'] ?? ($product->price * $item['quantity']),
                    'product' => $product
                ];
            }
        }

        return collect($transactionItems);
    }

    // Method untuk mendapatkan total quantity
    public function getTotalQuantityAttribute()
    {
        $items = $this->items ?? [];
        return collect($items)->sum('quantity');
    }

    // Scope untuk filter laporan
    public function scopeFilterByDate($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        return $query;
    }

    public function scopeFilterByProduct($query, $productId = null)
    {
        if ($productId) {
            $query->whereJsonContains('items', [['product_id' => (int)$productId]]);
        }
        return $query;
    }

    // Scope untuk monthly report
    public function scopeForMonth($query, $month)
    {
        return $query->whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2));
    }

    // Scope untuk daily report
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }
}