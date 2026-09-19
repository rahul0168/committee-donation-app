<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'committee_id',
        'name',
        'phone',
        'email',
        'address',
        'monthly_pledge_amount',
        'status',
    ];

    protected $casts = [
        'monthly_pledge_amount' => 'decimal:2',
    ];

    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function getTotalDonatedAttribute()
    {
        return $this->donations()->sum('amount');
    }
}
