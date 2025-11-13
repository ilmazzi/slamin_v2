<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ArticleLayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'article_id',
        'order',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    // Relazioni
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeByPosition(Builder $query, $position): void
    {
        $query->where('position', $position);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order', 'asc');
    }

    // Metodi
    public static function getPositions()
    {
        return [
            'banner' => __('articles.layout.banner'),
            'column1' => __('articles.layout.column1'),
            'column2' => __('articles.layout.column2'),
            'horizontal1' => __('articles.layout.horizontal1'),
            'horizontal2' => __('articles.layout.horizontal2'),
            'column3' => __('articles.layout.column3'),
            'column4' => __('articles.layout.column4'),
            'horizontal3' => __('articles.layout.horizontal3'),
            'column5' => __('articles.layout.column5'),
            'column6' => __('articles.layout.column6'),
            'sidebar1' => __('articles.layout.sidebar1'),
            'sidebar2' => __('articles.layout.sidebar2'),
            'sidebar3' => __('articles.layout.sidebar3'),
            'sidebar4' => __('articles.layout.sidebar4'),
            'sidebar5' => __('articles.layout.sidebar5'),
        ];
    }

    public function getPositionNameAttribute()
    {
        $positions = self::getPositions();
        return $positions[$this->position] ?? $this->position;
    }

    public static function getLayoutForPosition($position)
    {
        return self::where('position', $position)
                  ->where('is_active', true)
                  ->orderBy('order', 'asc')
                  ->with('article')
                  ->get();
    }

    public static function updateLayout($position, $articleId, $order = 0)
    {
        // Rimuovi layout esistenti per questa posizione
        self::where('position', $position)->delete();

        // Crea nuovo layout
        if ($articleId) {
            return self::create([
                'position' => $position,
                'article_id' => $articleId,
                'order' => $order,
                'is_active' => true,
            ]);
        }

        return null;
    }
}

