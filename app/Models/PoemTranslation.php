<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoemTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_id',
        'gig_application_id',
        'poem_id',
        'translator_id',
        'language',
        'target_language',
        'title',
        'content',
        'translated_text',
        'translator_notes',
        'status',
        'version',
        'final_compensation',
        'submitted_at',
        'approved_at',
        'approved_by',
        'completed_at',
    ];

    protected $casts = [
        'version' => 'integer',
        'final_compensation' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relazione con il gig di traduzione
     */
    public function gig(): BelongsTo
    {
        return $this->belongsTo(Gig::class);
    }
    
    /**
     * Relazione con la candidatura
     */
    public function gigApplication(): BelongsTo
    {
        return $this->belongsTo(GigApplication::class);
    }

    /**
     * Relazione con la poesia originale
     */
    public function poem(): BelongsTo
    {
        return $this->belongsTo(Poem::class);
    }

    /**
     * Relazione con il traduttore
     */
    public function translator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'translator_id');
    }
    
    /**
     * Relazione con chi ha approvato
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    /**
     * Versioni della traduzione
     */
    public function versions(): HasMany
    {
        return $this->hasMany(TranslationVersion::class);
    }
    
    /**
     * Commenti sulla traduzione
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TranslationComment::class);
    }
    
    /**
     * Commenti non risolti
     */
    public function unresolvedComments(): HasMany
    {
        return $this->hasMany(TranslationComment::class)->where('is_resolved', false);
    }

    /**
     * Scope per stato specifico
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope per lingua specifica
     */
    public function scopeInLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    /**
     * Scope per traduttore specifico
     */
    public function scopeByTranslator($query, $translatorId)
    {
        return $query->where('translator_id', $translatorId);
    }

    /**
     * Scope per poesia specifica
     */
    public function scopeForPoem($query, $poemId)
    {
        return $query->where('poem_id', $poemId);
    }

    /**
     * Scope per traduzioni approvate
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope per traduzioni in bozza
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope per traduzioni completate
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }
    
    /**
     * Crea una nuova versione
     */
    public function createVersion($modifiedBy, $changesSummary = null)
    {
        return $this->versions()->create([
            'modified_by' => $modifiedBy,
            'content' => $this->translated_text ?? $this->content,
            'version_number' => $this->version ?? 1,
            'changes_summary' => $changesSummary,
        ]);
    }
    
    /**
     * Incrementa versione e salva
     */
    public function incrementVersion($modifiedBy, $changesSummary = null)
    {
        $this->version = ($this->version ?? 1) + 1;
        $this->save();
        
        return $this->createVersion($modifiedBy, $changesSummary);
    }
}
