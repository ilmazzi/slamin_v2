<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class TranslationOverride extends Model
{
    protected $fillable = [
        'locale',
        'group',
        'key',
        'value',
        'created_by',
    ];

    /**
     * Relazione con l'utente che ha creato la traduzione
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Boot del model - invalida cache su save/delete
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($override) {
            static::clearCacheForLocaleAndGroup($override->locale, $override->group, $override->key);
        });

        static::deleted(function ($override) {
            static::clearCacheForLocaleAndGroup($override->locale, $override->group);
        });
    }

    /**
     * Pulisce la cache per una specifica lingua e gruppo
     * Rimuove tutte le chiavi di cache correlate
     */
    public static function clearCacheForLocaleAndGroup(string $locale, string $group, ?string $key = null): void
    {
        // Pulisce la cache del gruppo completo
        Cache::forget("translation_overrides_{$locale}_{$group}");
        
        // Se è specificata una chiave, pulisci anche la cache della singola chiave
        if ($key !== null) {
            Cache::forget("translation_override_{$locale}_{$group}_{$key}");
        } else {
            // Pulisci tutte le cache delle singole chiavi per questo gruppo
            // Recupera tutte le chiavi del gruppo e pulisci la cache per ognuna
            $overrides = static::where('locale', $locale)
                ->where('group', $group)
                ->pluck('key');
            
            foreach ($overrides as $overrideKey) {
                Cache::forget("translation_override_{$locale}_{$group}_{$overrideKey}");
            }
        }
        
        // Invalida la cache delle traduzioni di Laravel per questo gruppo
        // Laravel memorizza le traduzioni in cache con questa chiave
        $laravelCacheKey = "translation.{$locale}.{$group}";
        Cache::forget($laravelCacheKey);
        
        // Pulisce anche la cache del translator di Laravel
        // Il translator può avere una cache interna
        try {
            $translator = app('translator');
            if (method_exists($translator, 'resetLoaded')) {
                $translator->resetLoaded();
            }
        } catch (\Exception $e) {
            // Ignora errori
        }
    }

    /**
     * Ottiene una traduzione override
     */
    public static function getOverride(string $locale, string $group, string $key): ?string
    {
        $cacheKey = "translation_override_{$locale}_{$group}_{$key}";

        return Cache::remember($cacheKey, 86400, function () use ($locale, $group, $key) {
            $override = static::where('locale', $locale)
                ->where('group', $group)
                ->where('key', $key)
                ->first();

            return $override ? $override->value : null;
        });
    }

    /**
     * Salva o aggiorna un override
     */
    public static function setOverride(string $locale, string $group, string $key, string $value, ?int $userId = null): self
    {
        $override = static::updateOrCreate(
            [
                'locale' => $locale,
                'group' => $group,
                'key' => $key,
            ],
            [
                'value' => $value,
                'created_by' => $userId,
            ]
        );

        // Invalida cache
        static::clearCacheForLocaleAndGroup($locale, $group);

        return $override;
    }

    /**
     * Rimuove un override
     */
    public static function removeOverride(string $locale, string $group, string $key): bool
    {
        $deleted = static::where('locale', $locale)
            ->where('group', $group)
            ->where('key', $key)
            ->delete();

        if ($deleted) {
            static::clearCacheForLocaleAndGroup($locale, $group);
        }

        return $deleted > 0;
    }

    /**
     * Ottiene tutti gli override per una lingua e gruppo
     */
    public static function getOverridesForGroup(string $locale, string $group): array
    {
        $cacheKey = "translation_overrides_{$locale}_{$group}";

        return Cache::remember($cacheKey, 86400, function () use ($locale, $group) {
            return static::where('locale', $locale)
                ->where('group', $group)
                ->pluck('value', 'key')
                ->toArray();
        });
    }
}
