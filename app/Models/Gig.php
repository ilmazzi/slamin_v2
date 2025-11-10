<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gig extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // Campi base
        'title',
        'description',
        'requirements',
        'compensation',
        'deadline',
        'category',
        'type',
        'language',
        'location',
        // Flags
        'is_remote',
        'is_urgent',
        'is_featured',
        'is_closed',
        // Limiti
        'max_applications',
        'allow_group_admin_edit',
        // Contatori
        'view_count',
        'like_count',
        'comment_count',
        'application_count',
        'accepted_applications_count',
        // Relazioni
        'user_id',
        'event_id',
        'group_id',
        // Campi traduzioni
        'poem_id',
        'requester_id',
        'target_language',
        'proposed_compensation',
        'status',
        'accepted_translator_id',
        'accepted_at',
        'completed_at',
        'gig_type',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'is_remote' => 'boolean',
        'is_urgent' => 'boolean',
        'is_featured' => 'boolean',
        'is_closed' => 'boolean',
        'allow_group_admin_edit' => 'boolean',
        'view_count' => 'integer',
        'like_count' => 'integer',
        'comment_count' => 'integer',
        'application_count' => 'integer',
        'accepted_applications_count' => 'integer',
        'proposed_compensation' => 'decimal:2',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // ==================== RELAZIONI ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(GigApplication::class);
    }

    public function pendingApplications(): HasMany
    {
        return $this->hasMany(GigApplication::class)->where('status', 'pending');
    }

    public function acceptedApplications(): HasMany
    {
        return $this->hasMany(GigApplication::class)->where('status', 'accepted');
    }

    public function rejectedApplications(): HasMany
    {
        return $this->hasMany(GigApplication::class)->where('status', 'rejected');
    }

    // Relazioni traduzioni
    public function poem(): BelongsTo
    {
        return $this->belongsTo(Poem::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function acceptedTranslator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_translator_id');
    }

    public function poemTranslations(): HasMany
    {
        return $this->hasMany(PoemTranslation::class);
    }

    // ==================== SCOPES ====================

    public function scopeOpen($query)
    {
        return $query->where('is_closed', false)
                     ->where(function($q) {
                         $q->whereNull('deadline')
                           ->orWhere('deadline', '>', now());
                     });
    }

    public function scopeClosed($query)
    {
        return $query->where(function($q) {
            $q->where('is_closed', true)
              ->orWhere('deadline', '<=', now());
        });
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRemote($query)
    {
        return $query->where('is_remote', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', '%' . $location . '%');
    }

    // Scopes traduzioni
    public function scopeTranslationGigs($query)
    {
        return $query->where('gig_type', 'translation');
    }

    public function scopeEventGigs($query)
    {
        return $query->where('gig_type', 'event');
    }

    public function scopeForPoem($query, $poemId)
    {
        return $query->where('poem_id', $poemId);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForLanguage($query, $language)
    {
        return $query->where('target_language', $language);
    }

    public function scopeByRequester($query, $requesterId)
    {
        return $query->where('requester_id', $requesterId);
    }

    // ==================== ACCESSORS ====================

    public function getIsExpiredAttribute(): bool
    {
        if (!$this->deadline) {
            return false;
        }
        return $this->deadline <= now();
    }

    public function getDaysUntilDeadlineAttribute(): ?int
    {
        if (!$this->deadline) {
            return null;
        }
        return now()->diffInDays($this->deadline, false);
    }

    public function getCanApplyAttribute(): bool
    {
        return !$this->is_closed && 
               !$this->is_expired &&
               ($this->max_applications === null || $this->application_count < $this->max_applications);
    }

    // ==================== METODI ====================

    /**
     * Verifica se un utente può candidarsi a questo gig
     */
    public function canUserApply(User $user): bool
    {
        // Controlli base
        if (!$this->can_apply) {
            return false;
        }

        // L'utente non può candidarsi ai propri gig
        if ($this->user_id === $user->id) {
            return false;
        }

        // Per gigs di traduzione, il requester non può candidarsi
        if ($this->requester_id && $this->requester_id === $user->id) {
            return false;
        }

        // Per gigs di traduzione, l'autore della poesia non può candidarsi
        if ($this->gig_type === 'translation' && $this->poem && $this->poem->user_id === $user->id) {
            return false;
        }

        // Verifica se l'utente ha già candidato
        $existingApplication = $this->applications()->where('user_id', $user->id)->first();
        if ($existingApplication) {
            return false;
        }

        // Utenti audience non possono candidarsi
        if ($user->hasRole('audience')) {
            return false;
        }

        return true;
    }

    /**
     * Alias per accessor
     */
    public function canApply(User $user): bool
    {
        return $this->canUserApply($user);
    }

    /**
     * Verifica se tutte le posizioni sono state coperte
     */
    public function areAllPositionsFilled(): bool
    {
        if ($this->max_applications === null) {
            return false;
        }

        return $this->accepted_applications_count >= $this->max_applications;
    }

    /**
     * Verifica se il gig dovrebbe essere chiuso automaticamente
     */
    public function shouldBeClosed(): bool
    {
        return $this->areAllPositionsFilled() || $this->is_expired;
    }

    /**
     * Chiude il gig
     */
    public function close(): void
    {
        $this->update(['is_closed' => true]);
    }

    /**
     * Riapre il gig
     */
    public function reopen(): void
    {
        $this->update(['is_closed' => false]);
    }

    /**
     * Segna come urgente
     */
    public function markAsUrgent(): void
    {
        $this->update(['is_urgent' => true]);
    }

    /**
     * Segna come featured
     */
    public function markAsFeatured(): void
    {
        $this->update(['is_featured' => true]);
    }

    /**
     * Verifica se può essere modificato dall'utente
     */
    public function canBeEditedBy(User $user): bool
    {
        // Il proprietario può sempre modificare
        if ($this->user_id === $user->id) {
            return true;
        }

        // Il requester (traduzioni) può modificare
        if ($this->requester_id && $this->requester_id === $user->id) {
            return true;
        }

        // Se è abilitata la modifica da admin del gruppo
        if ($this->allow_group_admin_edit && $this->group_id && $this->group) {
            $groupMember = $this->group->members()->where('user_id', $user->id)->first();
            if ($groupMember && in_array($groupMember->role, ['admin', 'moderator'])) {
                return true;
            }
        }

        // Admin possono sempre modificare
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    /**
     * Verifica se può essere visualizzato dall'utente
     */
    public function canBeViewedBy(?User $user = null): bool
    {
        // Se non c'è utente, solo gig pubblici
        if (!$user) {
            return true;
        }

        // Gli utenti audience non possono vedere i gig
        if ($user->hasRole('audience')) {
            return false;
        }

        return true;
    }

    /**
     * Condividi il gig inviando notifiche
     */
    public function share(): int
    {
        // Ottieni tutti gli utenti non-audience
        $users = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'audience');
        })->get();

        // Invia notifica a tutti (TODO: implementare notifica)
        // foreach ($users as $user) {
        //     $user->notify(new \App\Notifications\GigShared($this));
        // }

        return $users->count();
    }

    /**
     * Accetta una candidatura
     */
    public function acceptApplication(GigApplication $application): bool
    {
        // Verifica stato
        if ($this->is_closed || $this->is_expired) {
            return false;
        }

        \DB::transaction(function () use ($application) {
            // Accetta la candidatura
            $application->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

            // Rifiuta tutte le altre candidature pendenti
            $this->applications()
                ->where('id', '!=', $application->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'rejected_at' => now(),
                    'rejection_reason' => 'Another applicant was selected',
                ]);

            // Aggiorna contatori
            $this->increment('accepted_applications_count');

            // Se era un gig di traduzione, aggiorna anche quei campi
            if ($this->gig_type === 'translation') {
                $this->update([
                    'status' => 'in_progress',
                    'accepted_translator_id' => $application->user_id,
                    'accepted_at' => now(),
                ]);
            }

            // Se tutte le posizioni sono coperte, chiudi
            if ($this->areAllPositionsFilled()) {
                $this->close();
            }
        });

        return true;
    }
}
