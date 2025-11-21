<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
        'group',
    ];

    protected $casts = [
        'display_name' => 'string',
        'description' => 'string',
        'group' => 'string',
    ];

    /**
     * Relazione con i ruoli (many-to-many)
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    /**
     * Relazione con gli utenti (many-to-many attraverso model_has_permissions)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_permissions', 'permission_id', 'model_id')
                    ->where('model_has_permissions.model_type', User::class);
    }

    /**
     * Scope per ottenere permesso per nome
     */
    public function scopeByName($query, string $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Scope per gruppo
     */
    public function scopeByGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Accessor per display_name
     */
    public function getDisplayNameAttribute($value)
    {
        return $value ?? $this->name;
    }
}

