<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslationComment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'poem_translation_id',
        'user_id',
        'selection_start',
        'selection_end',
        'highlighted_text',
        'comment',
        'is_resolved',
        'resolved_by',
        'resolved_at',
    ];
    
    protected $casts = [
        'selection_start' => 'integer',
        'selection_end' => 'integer',
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];
    
    // Relationships
    public function translation(): BelongsTo
    {
        return $this->belongsTo(PoemTranslation::class, 'poem_translation_id');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
    
    // Helper methods
    public function resolve($userId = null)
    {
        $this->update([
            'is_resolved' => true,
            'resolved_by' => $userId ?? auth()->id(),
            'resolved_at' => now(),
        ]);
    }
}
