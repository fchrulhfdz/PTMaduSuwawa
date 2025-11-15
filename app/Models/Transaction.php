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
                
                // Clean the JSON string - remove unwanted characters
                $items = str_replace('\\"', '"', $items);
                $items = str_replace('\"', '"', $items);
                $items = preg_replace('/[^\x20-\x7E]/', '', $items);
                
                $decoded = json_decode($items, true);
                
                return is_array($decoded) ? $decoded : [];
            } catch (\Exception $e) {
                \Log::error('Error decoding items JSON: ' . $e->getMessage());
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
            $totalQuantity += $quantity;
        }
        
        return $totalQuantity;
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

    // Scope untuk kategori tertentu
    public function scopeForCategory($query, $category)
    {
        if ($category) {
            return $query->whereHas('product', function($q) use ($category) {
                $q->where('category', $category);
            });
        }
        
        return $query;
    }

    // Method untuk mendapatkan total revenue dengan filter
    public static function getFilteredRevenue($startDate = null, $endDate = null, $productId = null, $category = null)
    {
        return self::completed()
            ->dateRange($startDate, $endDate)
            ->forProduct($productId)
            ->forCategory($category)
            ->sum('total');
    }

    // Method untuk mendapatkan total quantity dengan filter
    public static function getFilteredQuantity($startDate = null, $endDate = null, $productId = null, $category = null)
    {
        $transactions = self::completed()
            ->dateRange($startDate, $endDate)
            ->forProduct($productId)
            ->forCategory($category)
            ->get();

        $totalQuantity = 0;
        foreach ($transactions as $transaction) {
            $totalQuantity += $transaction->calculated_quantity;
        }

        return $totalQuantity;
    }

    // Method untuk mendapatkan total transactions dengan filter
    public static function getFilteredTransactionCount($startDate = null, $endDate = null, $productId = null, $category = null)
    {
        return self::completed()
            ->dateRange($startDate, $endDate)
            ->forProduct($productId)
            ->forCategory($category)
            ->count();
    }
}