<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslationVersion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'poem_translation_id',
        'modified_by',
        'content',
        'version_number',
        'changes_summary',
        'diff_data',
    ];
    
    protected $casts = [
        'version_number' => 'integer',
        'diff_data' => 'array',
    ];
    
    // Relationships
    public function translation(): BelongsTo
    {
        return $this->belongsTo(PoemTranslation::class, 'poem_translation_id');
    }
    
    public function modifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
