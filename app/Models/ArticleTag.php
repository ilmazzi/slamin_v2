<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class ArticleTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'is_active',
        'usage_count',
    ];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
        'usage_count' => 'integer',
    ];

    /**
     * Relazione con gli articoli
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tag', 'article_tag_id', 'article_id')
                    ->withTimestamps();
    }

    /**
     * Scope per tag attivi
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope per tag più utilizzati
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->where('is_active', true)
                    ->orderBy('usage_count', 'desc')
                    ->limit($limit);
    }

    /**
     * Incrementa il contatore di utilizzo
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    /**
     * Decrementa il contatore di utilizzo
     */
    public function decrementUsage()
    {
        if ($this->usage_count > 0) {
            $this->decrement('usage_count');
        }
    }

    /**
     * Ottiene il nome nella lingua corrente
     */
    public function getDisplayNameAttribute()
    {
        $name = $this->attributes['name'] ?? null;
        if (is_string($name)) {
            $name = json_decode($name, true);
        }
        
        if (is_array($name)) {
            $locale = app()->getLocale();
            return $name[$locale] ?? $name['it'] ?? $name['en'] ?? '';
        }
        return $name ?? '';
    }

    /**
     * Genera lo slug dal nome se non esiste
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (!$tag->slug && $tag->name) {
                $name = is_array($tag->name) ? ($tag->name['it'] ?? $tag->name['en'] ?? '') : $tag->name;
                $tag->slug = Str::slug($name);
            }
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('name') && !$tag->isDirty('slug')) {
                $name = is_array($tag->name) ? ($tag->name['it'] ?? $tag->name['en'] ?? '') : $tag->name;
                $tag->slug = Str::slug($name);
            }
        });
    }
}

