<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Committee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'target_amount',
        'status',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function getTotalCollectedAttribute()
    {
        return $this->donations()->sum('amount');
    }

    public function getTotalExpensesAttribute()
    {
        return $this->expenses()->sum('amount');
    }

    public function getNetBalanceAttribute()
    {
        return $this->total_collected - $this->total_expenses;
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) {
            return 100;
        }
        return min(100, round(($this->total_collected / $this->target_amount) * 100, 1));
    }
}
