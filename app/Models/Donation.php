<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'committee_id',
        'member_id',
        'donor_name',
        'donor_phone',
        'amount',
        'payment_method',
        'payment_date',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public static function generateReceiptNumber(): string
    {
        $prefix = 'REC-' . date('Ym');
        $lastDonation = static::where('receipt_number', 'like', $prefix . '-%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastDonation) {
            $lastNum = (int) Str::afterLast($lastDonation->receipt_number, '-');
            $newNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNum = '0001';
        }

        return $prefix . '-' . $newNum;
    }

    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
