<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class PoemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function poems(): HasMany
    {
        return $this->hasMany(Poem::class, 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Ottiene il nome nella lingua corrente
     * L'accessor gestisce il fatto che 'name' è un JSON nel database
     */
    public function getNameAttribute($value)
    {
        // Se non c'è valore o è null, restituisci stringa vuota
        if (!$value) {
            return '';
        }
        
        // Se è una stringa JSON, decodificala
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $locale = app()->getLocale();
                return $decoded[$locale] ?? $decoded['it'] ?? $decoded['en'] ?? array_values($decoded)[0] ?? '';
            }
            // Se non è JSON valido, restituisci la stringa così com'è
            return $value;
        }
        
        // Se è già un array (potrebbe succedere in alcune situazioni), gestiscilo
        if (is_array($value)) {
            $locale = app()->getLocale();
            return $value[$locale] ?? $value['it'] ?? $value['en'] ?? array_values($value)[0] ?? '';
        }
        
        return '';
    }

    /**
     * Salva il nome come JSON nel database
     */
    public function setNameAttribute($value)
    {
        // Se è già un array, codificalo come JSON
        if (is_array($value)) {
            $this->attributes['name'] = json_encode($value);
        } 
        // Se è una stringa, salvala così com'è (potrebbe essere già JSON o una stringa semplice)
        else {
            $this->attributes['name'] = $value;
        }
    }

    /**
     * Ottiene tutte le traduzioni del nome come array
     */
    public function getNameTranslationsAttribute(): array
    {
        $value = $this->attributes['name'] ?? null;
        
        if (!$value) {
            return [];
        }
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
        }
        
        return is_array($value) ? $value : [];
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
