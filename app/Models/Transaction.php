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
        'product_id',
        'quantity',
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
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship dengan Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor untuk items yang aman
    public function getItemsArrayAttribute()
    {
        if (is_array($this->items)) {
            return $this->items;
        }
        
        if (is_string($this->items)) {
            try {
                $items = $this->attributes['items'] ?? '[]';
                
                // Clean the JSON string
                $items = str_replace(['\\"', '\"'], '"', $items);
                $items = preg_replace('/[^\x20-\x7E]/', '', $items);
                
                $decoded = json_decode($items, true);
                
                return is_array($decoded) ? $decoded : [];
            } catch (\Exception $e) {
                \Log::error('Error decoding items JSON for transaction ' . $this->id . ': ' . $e->getMessage());
                return [];
            }
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
            $totalQuantity += intval($quantity);
        }
        
        return $totalQuantity;
    }

    // Accessor untuk format berat
    public function getFormattedBeratAttribute()
    {
        $berat = $this->total_berat ?? 0;
        
        if ($berat >= 1000) {
            return number_format($berat / 1000, 2) . ' kg';
        } else {
            return number_format($berat, 0) . ' g';
        }
    }

    // Method untuk mendapatkan ringkasan items
    public function getItemsSummaryAttribute()
    {
        $items = $this->items_array;
        
        if (empty($items)) {
            return [
                'total_items' => 0,
                'total_quantity' => 0,
                'item_names' => [],
                'formatted_names' => 'Tidak ada item'
            ];
        }
        
        $totalQuantity = 0;
        $itemNames = [];
        
        foreach ($items as $item) {
            $quantity = $item['quantity'] ?? 0;
            $name = $item['name'] ?? 'Produk';
            $totalQuantity += intval($quantity);
            $itemNames[] = $name;
        }
        
        return [
            'total_items' => count($items),
            'total_quantity' => $totalQuantity,
            'item_names' => $itemNames,
            'formatted_names' => $this->formatItemNames($itemNames)
        ];
    }

    // Helper method untuk format nama item
    private function formatItemNames($itemNames)
    {
        if (empty($itemNames)) {
            return 'Tidak ada item';
        }
        
        $displayNames = array_slice($itemNames, 0, 2);
        $result = implode(', ', $displayNames);
        
        if (count($itemNames) > 2) {
            $result .= ' ... dan ' . (count($itemNames) - 2) . ' lainnya';
        }
        
        return $result;
    }

    // Scope untuk transaksi completed
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Scope untuk rentang tanggal
    public function scopeDateRange($query, $startDate, $endDate)
    {
        if ($startDate && $endDate) {
            return $query->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }
        
        return $query;
    }

    // Scope untuk produk tertentu
    public function scopeForProduct($query, $productId)
    {
        if ($productId) {
            return $query->where('product_id', $productId)
                        ->orWhereJsonContains('items', [['product_id' => (int)$productId]]);
        }
        
        return $query;
    }
}