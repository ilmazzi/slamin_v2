<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GigPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relazione con i gigs
     */
    public function gigs(): HasMany
    {
        return $this->hasMany(Gig::class, 'position_key', 'key');
    }
}

