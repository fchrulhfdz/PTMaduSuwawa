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
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}