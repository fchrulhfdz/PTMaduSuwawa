<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'berat_isi',
        'satuan_berat',
        'category',
        'barcode',
        'image',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean'
    ];

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock == 0) {
            return 'out-of-stock';
        } elseif ($this->stock < 10) {
            return 'low-stock';
        } else {
            return 'in-stock';
        }
    }

    public function getStockStatusColorAttribute()
    {
        return match($this->stock_status) {
            'out-of-stock' => 'red',
            'low-stock' => 'yellow',
            'in-stock' => 'green'
        };
    }

    // PERBAIKAN: Accessor untuk items array
    public function getItemsArrayAttribute()
    {
        $items = is_string($this->items) ? json_decode($this->items, true) : $this->items;
        return is_array($items) ? $items : [];
    }

    // Accessor untuk format berat lengkap
    public function getFormattedWeightAttribute()
    {
        if ($this->berat_isi && $this->satuan_berat) {
            return $this->berat_isi . ' ' . $this->satuan_berat;
        }
        return '-';
    }
}