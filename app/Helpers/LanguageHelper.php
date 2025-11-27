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
        cache()->forget('available_languages');
    }

    /**
     * Get all available languages with full information
     */
    public static function getAvailableLanguages(): array
    {
        return cache()->remember('available_languages', 3600, function () {
            $languages = [];
            $langPath = lang_path();

            foreach (glob($langPath . '/*', GLOB_ONLYDIR) as $dir) {
                $locale = basename($dir);
                $languages[$locale] = [
                    'code' => $locale,
                    'name' => self::getLanguageName($locale),
                    'flag' => self::getLanguageFlag($locale),
                ];
            }

            // Sort by name for consistent display
            uasort($languages, fn($a, $b) => strcmp($a['name'], $b['name']));
            
            return $languages;
        });
    }

    /**
     * Get language name from locale code
     */
    public static function getLanguageName(string $locale): string
    {
        return match ($locale) {
            'en' => 'English',
            'it' => 'Italiano',
            'fr' => 'Français',
            'de' => 'Deutsch',
            'es' => 'Español',
            'pt' => 'Português',
            'ru' => 'Русский',
            'zh' => '中文',
            'ja' => '日本語',
            'ar' => 'العربية',
            default => ucfirst($locale),
        };
    }

    /**
     * Get language flag emoji from locale code
     */
    public static function getLanguageFlag(string $locale): string
    {
        return match ($locale) {
            'en' => '🇬🇧',
            'it' => '🇮🇹',
            'fr' => '🇫🇷',
            'de' => '🇩🇪',
            'es' => '🇪🇸',
            'pt' => '🇵🇹',
            'ru' => '🇷🇺',
            'zh' => '🇨🇳',
            'ja' => '🇯🇵',
            'ar' => '🇸🇦',
            default => '🌐',
        };
    }
}
