<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'author_id',
        'title',
        'content',
        'type',
        'is_pinned',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Alias per retrocompatibilità
    public function user(): BelongsTo
    {
        return $this->author();
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }
}
