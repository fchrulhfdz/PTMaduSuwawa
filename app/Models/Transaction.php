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
        'customer_phone',
        'quantity', // Tambahkan ini
        'items',
        'subtotal',
        'tax',
        'discount',
        'total',
        'payment_method',
        'cash_paid',
        'change_amount',
        'status',
        'total_berat',
        'notes'
    ];

    protected $casts = [
        'items' => 'array',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'cash_paid' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'total_berat' => 'decimal:2',
        'quantity' => 'integer' // Tambahkan ini
    ];

    // Accessor untuk items yang aman
    public function getItemsArrayAttribute()
    {
        if (is_array($this->items)) {
            return $this->items;
        }
        
        if (is_string($this->items)) {
            return json_decode($this->items, true) ?? [];
        }
        
        return [];
    }

    // Accessor untuk menghitung total quantity dari items
    public function getCalculatedQuantityAttribute()
    {
        $items = $this->items_array;
        $totalQuantity = 0;
        
        foreach ($items as $item) {
            $quantity = $item['quantity'] ?? 0;
            $totalQuantity += $quantity;
        }
        
        return $totalQuantity;
    }

    // Scope untuk transaksi dengan quantity tertentu
    public function scopeWithMinQuantity($query, $minQuantity)
    {
        return $query->where('quantity', '>=', $minQuantity);
    }

    public function scopeWithMaxQuantity($query, $maxQuantity)
    {
        return $query->where('quantity', '<=', $maxQuantity);
    }
}