<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class ArticleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'order',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Ottiene il nome nella lingua corrente
     * L'accessor gestisce il fatto che 'name' è un array JSON (grazie al cast)
     */
    public function getNameAttribute($value)
    {
        // Il cast JSON fa sì che $value sia già un array quando viene letto
        // Se non c'è valore o è null, restituisci stringa vuota
        if (!$value) {
            return '';
        }
        
        // Se è già un array (dopo il cast JSON), restituisci il nome nella lingua corrente
        if (is_array($value)) {
            $locale = app()->getLocale();
            return $value[$locale] ?? $value['it'] ?? $value['en'] ?? array_values($value)[0] ?? '';
        }
        
        // Fallback: se per qualche motivo non è un array, restituisci come stringa
        return is_string($value) ? $value : '';
    }

    /**
     * Ottiene il nome nella lingua corrente (alias per compatibilità)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Scope per ottenere solo le categorie attive
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope per ordinare per sort_order
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
