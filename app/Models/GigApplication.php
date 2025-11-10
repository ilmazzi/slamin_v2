<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GigApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_id',
        'user_id', // Campo corretto nella tabella gig_applications
        'cover_letter',
        'proposed_compensation',
        'estimated_delivery',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'proposed_compensation' => 'decimal:2',
        'estimated_delivery' => 'date',
    ];

    /**
     * Relazione con il gig
     */
    public function gig(): BelongsTo
    {
        return $this->belongsTo(Gig::class);
    }

    /**
     * Relazione con l'utente (traduttore)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Alias per compatibilità
     */
    public function translator(): BelongsTo
    {
        return $this->user();
    }

    /**
     * Messaggi di contrattazione
     */
    public function negotiations(): HasMany
    {
        return $this->hasMany(PoemTranslationNegotiation::class);
    }

    /**
     * Scope per candidature pendenti
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope per candidature accettate
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope per candidature rifiutate
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope per traduttore specifico
     */
    public function scopeByTranslator($query, $translatorId)
    {
        return $query->where('user_id', $translatorId);
    }
}
