<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'locale'];

    public function help(): BelongsTo
    {
        return $this->belongsTo(Help::class);
    }
}
