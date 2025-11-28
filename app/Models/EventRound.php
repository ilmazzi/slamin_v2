<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventRound extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'round_number',
        'name',
        'max_participants',
        'scoring_type',
        'judges_count',
        'is_active',
        'order',
        'notes',
        'selected_participants',
    ];
    
    protected $casts = [
        'round_number' => 'integer',
        'max_participants' => 'integer',
        'judges_count' => 'integer',
        'is_active' => 'boolean',
        'order' => 'integer',
        'selected_participants' => 'array',
    ];


    /**
     * Event this round belongs to
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Scores for this round
     */
    public function scores(): HasMany
    {
        return $this->hasMany(EventScore::class, 'round', 'round_number')
            ->where('event_id', $this->event_id);
    }

    /**
     * Scope: active rounds
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordered
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('round_number');
    }
}

