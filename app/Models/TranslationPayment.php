<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslationPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_application_id',
        'poem_id',
        'client_id',
        'translator_id',
        'amount',
        'currency',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'status',
        'failure_reason',
        'stripe_metadata',
        'paid_at',
        'commission_rate',
        'commission_fixed',
        'commission_total',
        'translator_amount',
        'platform_amount',
        'payment_method',
        'payout_status',
        'payout_transfer_id',
        'payout_date',
        'payout_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_rate' => 'decimal:4',
        'commission_fixed' => 'decimal:2',
        'commission_total' => 'decimal:2',
        'translator_amount' => 'decimal:2',
        'platform_amount' => 'decimal:2',
        'stripe_metadata' => 'array',
        'paid_at' => 'datetime',
        'payout_date' => 'datetime',
    ];

    /**
     * Relazione con il gig application
     */
    public function gigApplication(): BelongsTo
    {
        return $this->belongsTo(GigApplication::class);
    }

    /**
     * Relazione con la poesia
     */
    public function poem(): BelongsTo
    {
        return $this->belongsTo(Poem::class);
    }

    /**
     * Relazione con il client (chi paga)
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relazione con il traduttore (chi riceve)
     */
    public function translator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'translator_id');
    }
}

