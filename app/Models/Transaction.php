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
        'items',
        'subtotal',
        'tax',
        'discount',
        'total',
        'payment_method',
        'cash_paid',
        'change_amount',
        'status',
        'total_berat', // Tambahkan kolom total berat
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
        'total_berat' => 'decimal:2' // Cast untuk total berat
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

    // Accessor untuk menghitung total berat dari items
    public function getCalculatedTotalBeratAttribute()
    {
        $items = $this->items_array;
        $totalBerat = 0;
        
        foreach ($items as $item) {
            $beratItem = $item['berat_isi'] ?? 0;
            $quantity = $item['quantity'] ?? 0;
            $totalBerat += $beratItem * $quantity;
        }
        
        return $totalBerat;
    }

    // Scope untuk transaksi dengan berat tertentu
    public function scopeWithMinBerat($query, $minBerat)
    {
        return $query->where('total_berat', '>=', $minBerat);
    }

    public function scopeWithMaxBerat($query, $maxBerat)
    {
        return $query->where('total_berat', '<=', $maxBerat);
    }
}