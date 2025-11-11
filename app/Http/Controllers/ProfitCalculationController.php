<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProfitCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'total_revenue',
        'total_cost',
        'total_profit',
        'total_transactions',
        'calculation_details',
        'description'
    ];

    protected $casts = [
        'total_revenue' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'calculation_details' => 'array',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    // Scope untuk filter by date
    public function scopeFilterByDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }

    // Scope untuk filter by date range
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Accessor untuk margin laba
    public function getProfitMarginAttribute()
    {
        return $this->total_revenue > 0 ? ($this->total_profit / $this->total_revenue) * 100 : 0;
    }
}