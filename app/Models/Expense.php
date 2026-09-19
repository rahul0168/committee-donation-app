<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'committee_id',
        'title',
        'category',
        'amount',
        'expense_date',
        'approved_by',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }
}
