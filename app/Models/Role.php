<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
    ];

    protected $casts = [
        'display_name' => 'string',
        'description' => 'string',
    ];

    /**
     * Relazione con gli utenti (many-to-many polimorfa)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id')
                    ->wherePivot('model_type', User::class)
                    ->withPivot('model_type');
    }

    /**
     * Count users with this role
     */
    public function usersCount(): int
    {
        return \Illuminate\Support\Facades\DB::table('model_has_roles')
            ->where('role_id', $this->id)
            ->where('model_type', User::class)
            ->count();
    }

    /**
     * Relazione con i permessi (many-to-many)
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    /**
     * Assegna un permesso al ruolo
     */
    public function givePermissionTo(Permission|string $permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->firstOrFail();
        }

        if (!$this->hasPermissionTo($permission)) {
            $this->permissions()->attach($permission);
        }

        return $this;
    }

    /**
     * Rimuove un permesso dal ruolo
     */
    public function revokePermissionTo(Permission|string $permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->firstOrFail();
        }

        $this->permissions()->detach($permission);

        return $this;
    }

    /**
     * Sincronizza i permessi del ruolo
     */
    public function syncPermissions(array $permissions): self
    {
        $permissionIds = collect($permissions)->map(function ($permission) {
            // Se è già un ID numerico, restituiscilo direttamente
            if (is_numeric($permission)) {
                return (int) $permission;
            }
            
            // Se è un oggetto Permission, prendi l'ID
            if ($permission instanceof Permission) {
                return $permission->id;
            }
            
            // Altrimenti, cerca per nome
            return Permission::where('name', $permission)->first()?->id;
        })->filter()->toArray();

        $this->permissions()->sync($permissionIds);
        
        // Ricarica la relazione per assicurarsi che i permessi siano aggiornati
        $this->load('permissions');

        return $this;
    }

    /**
     * Verifica se il ruolo ha un permesso
     */
    public function hasPermissionTo(Permission|string $permission): bool
    {
        // Se la relazione non è caricata, caricala
        if (!$this->relationLoaded('permissions')) {
            $this->load('permissions');
        }
        
        if (is_string($permission)) {
            return $this->permissions()->where('name', $permission)->exists();
        }

        return $this->permissions()->where('permissions.id', $permission->id)->exists();
    }

    /**
     * Scope per ottenere ruolo per nome
     */
    public function scopeByName($query, string $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Accessor per display_name
     */
    public function getDisplayNameAttribute($value)
    {
        return $value ?? $this->name;
    }
}

