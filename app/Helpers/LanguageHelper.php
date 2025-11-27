<?php

namespace App\Helpers;

class LanguageHelper
{
    /**
     * Get language information (name and flag emoji)
     */
    public static function getLanguageInfo(string $locale): array
    {
        $languages = [
            'it' => ['name' => 'Italiano', 'flag' => '🇮🇹'],
            'en' => ['name' => 'English', 'flag' => '🇬🇧'],
            'fr' => ['name' => 'Français', 'flag' => '🇫🇷'],
            'de' => ['name' => 'Deutsch', 'flag' => '🇩🇪'],
            'es' => ['name' => 'Español', 'flag' => '🇪🇸'],
            'pt' => ['name' => 'Português', 'flag' => '🇵🇹'],
            'ru' => ['name' => 'Русский', 'flag' => '🇷🇺'],
            'zh' => ['name' => '中文', 'flag' => '🇨🇳'],
            'ja' => ['name' => '日本語', 'flag' => '🇯🇵'],
            'ar' => ['name' => 'العربية', 'flag' => '🇸🇦'],
        ];

        return $languages[$locale] ?? [
            'name' => strtoupper($locale),
            'flag' => '🌐'
        ];
    }

    /**
     * Get all available locales from lang directory
     */
    public static function getAvailableLocales(): array
    {
        // Cache the result to avoid repeated filesystem operations
        return cache()->remember('available_locales', 3600, function () {
            $langPath = base_path('lang');
            $locales = [];
            
            if (is_dir($langPath)) {
                $directories = array_filter(glob($langPath . '/*'), 'is_dir');
                foreach ($directories as $dir) {
                    $locale = basename($dir);
                    $locales[] = $locale;
                }
            }
            
            return $locales;
        });
    }
    
    /**
     * Clear the locales cache (call this when adding new languages)
     */
    public static function clearLocalesCache(): void
    {
        cache()->forget('available_locales');
    }
}
