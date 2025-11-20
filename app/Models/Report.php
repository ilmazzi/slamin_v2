<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reportable_type',
        'reportable_id',
        'reason',
        'description',
        'status',
        'resolved_by',
        'resolved_at',
        'resolution_notes',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_INVESTIGATING = 'investigating';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_DISMISSED = 'dismissed';

    // Reason constants
    const REASON_SPAM = 'spam';
    const REASON_INAPPROPRIATE = 'inappropriate';
    const REASON_VIOLENCE = 'violence';
    const REASON_HARASSMENT = 'harassment';
    const REASON_COPYRIGHT = 'copyright';
    const REASON_MISINFORMATION = 'misinformation';
    const REASON_OTHER = 'other';

    /**
     * Relazione con l'utente che ha fatto la segnalazione
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relazione polimorfa con il contenuto segnalato
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relazione con il moderatore che ha risolto
     */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Scope per segnalazioni in attesa
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope per segnalazioni in investigazione
     */
    public function scopeInvestigating($query)
    {
        return $query->where('status', self::STATUS_INVESTIGATING);
    }

    /**
     * Scope per segnalazioni risolte
     */
    public function scopeResolved($query)
    {
        return $query->where('status', self::STATUS_RESOLVED);
    }

    /**
     * Scope per segnalazioni respinte
     */
    public function scopeDismissed($query)
    {
        return $query->where('status', self::STATUS_DISMISSED);
    }

    /**
     * Scope per segnalazioni attive (non risolte)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_INVESTIGATING]);
    }
}

