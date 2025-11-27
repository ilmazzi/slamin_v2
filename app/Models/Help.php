<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

class Help extends Model
{
    protected $fillable = [
        'type',
        'locale',
        'title',
        'content',
        'order',
        'is_active',
        'category',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected $with = ['translations']; // Eager load translations by default

    /**
     * Relazione con l'utente che ha creato l'help
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relazione con le traduzioni
     */
    public function translations(): HasMany
    {
        return $this->hasMany(HelpTranslation::class);
    }

    /**
     * Get translated title
     */
    public function getTranslatedTitleAttribute(): string
    {
        $translation = $this->translations->where('locale', App::getLocale())->first();
        return $translation ? $translation->title : $this->title;
    }

    /**
     * Get translated content
     */
    public function getTranslatedContentAttribute(): string
    {
        $translation = $this->translations->where('locale', App::getLocale())->first();
        return $translation ? $translation->content : $this->content;
    }

    /**
     * Scope per Help attivi
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope per tipo (help o faq)
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope ordinato
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }

    /**
     * Scope per lingua
     */
    public function scopeInLocale($query, string $locale)
    {
        return $query->where('locale', $locale);
    }
}

