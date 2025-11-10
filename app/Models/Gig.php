<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gig extends Model
{
    use HasFactory;

    protected $fillable = [
        'poem_id',
        'user_id', // Campo originale tabella gigs
        'requester_id',
        'title',
        'description',
        'target_language',
        'requirements',
        'proposed_compensation',
        'deadline',
        'status',
        'accepted_translator_id',
        'accepted_at',
        'completed_at',
        'category',
        'type',
        'language',
        'is_remote',
        'gig_type',
    ];

    protected $casts = [
        'proposed_compensation' => 'decimal:2',
        'deadline' => 'date',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relazione con la poesia da tradurre
     */
    public function poem(): BelongsTo
    {
        return $this->belongsTo(Poem::class);
    }

    /**
     * Relazione con il richiedente (autore)
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Relazione con il traduttore accettato
     */
    public function acceptedTranslator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_translator_id');
    }

    /**
     * Candidature ricevute
     */
    public function applications(): HasMany
    {
        return $this->hasMany(GigApplication::class);
    }

    /**
     * Traduzione completata
     */
    public function translation(): HasMany
    {
        return $this->hasMany(PoemTranslation::class);
    }

    /**
     * Scope per gig aperti
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope per gig in corso
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope per gig completati
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope per lingua target
     */
    public function scopeForLanguage($query, $language)
    {
        return $query->where('target_language', $language);
    }

    /**
     * Scope per gig del richiedente
     */
    public function scopeByRequester($query, $requesterId)
    {
        return $query->where('requester_id', $requesterId);
    }

    /**
     * Check se un utente può candidarsi
     */
    public function canApply(User $user): bool
    {
        // Non può candidarsi il richiedente
        if ($this->requester_id === $user->id) {
            return false;
        }

        // Non può candidarsi se già candidato
        if ($this->applications()->where('translator_id', $user->id)->exists()) {
            return false;
        }

        // Deve essere aperto
        return $this->status === 'open';
    }

    /**
     * Accetta una candidatura
     */
    public function acceptApplication(GigApplication $application): bool
    {
        if ($this->status !== 'open') {
            return false;
        }

        \DB::transaction(function () use ($application) {
            // Accetta la candidatura
            $application->update(['status' => 'accepted']);

            // Rifiuta tutte le altre
            $this->applications()
                ->where('id', '!=', $application->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected', 'rejection_reason' => 'Another translator was selected']);

            // Aggiorna il gig
            $this->update([
                'status' => 'in_progress',
                'accepted_translator_id' => $application->translator_id,
                'accepted_at' => now(),
            ]);
        });

        return true;
    }
}
