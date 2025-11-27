<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BadgeTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_id',
        'locale',
        'name',
        'description',
    ];

    /**
     * Badge relationship
     */
    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }
}
