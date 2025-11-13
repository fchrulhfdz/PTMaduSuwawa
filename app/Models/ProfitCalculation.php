<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'description',
        'type', // tambahkan type untuk membedakan antara profit calculation dan expense
        'expense_date', // tambahkan untuk expense
        'expense_amount', // tambahkan untuk expense
        'expense_description' // tambahkan untuk expense
    ];

    protected $casts = [
        'total_revenue' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'expense_amount' => 'decimal:2',
        'calculation_details' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'expense_date' => 'date'
    ];

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->where('start_date', $startDate)
                    ->where('end_date', $endDate);
    }

    // Scope untuk expenses
    public function scopeExpenses($query)
    {
        return $query->where('type', 'expense');
    }

    // Scope untuk profit calculations
    public function scopeProfitCalculations($query)
    {
        return $query->where('type', 'profit_calculation');
    }

    // Accessor untuk margin laba
    public function getProfitMarginAttribute()
    {
        return $this->total_revenue > 0 ? ($this->total_profit / $this->total_revenue) * 100 : 0;
    }

    
}