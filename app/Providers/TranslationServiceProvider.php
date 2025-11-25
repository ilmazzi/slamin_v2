<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use App\Models\TranslationOverride;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     * Estende il sistema di traduzione Laravel per supportare override dal database
     */
    public function boot(): void
    {
        // Estende il FileLoader per includere override dal database
        $this->app->extend('translation.loader', function ($loader, $app) {
            return new class($loader, $app) extends FileLoader {
                protected $originalLoader;
                protected $app;

                public function __construct($originalLoader, $app)
                {
                    $this->originalLoader = $originalLoader;
                    $this->app = $app;
                    parent::__construct($app['files'], $app['path.lang']);
                }

                /**
                 * Load the messages for the given locale and group.
                 * Prima carica dai file, poi applica override dal database
                 */
                public function load($locale, $group, $namespace = null)
                {
                    // Carica traduzioni dai file PHP (comportamento standard)
                    $translations = $this->originalLoader->load($locale, $group, $namespace);

                    // Applica override dal database solo se non è namespace
                    if ($namespace === null) {
                        try {
                            $overrides = TranslationOverride::getOverridesForGroup($locale, $group);
                            // Merge: gli override dal database hanno priorità
                            // Usa array_replace per mantenere le chiavi numeriche e sovrascrivere quelle stringa
                            $translations = array_replace($translations, $overrides);
                        } catch (\Exception $e) {
                            // Se c'è un errore (es. tabella non esiste), usa solo file
                            Log::warning('Translation override error: ' . $e->getMessage());
                        }
                    }

                    return $translations;
                }
            };
        });

        // Estende anche il Translator per invalidare la cache quando necessario
        $this->app->extend('translator', function ($translator, $app) {
            return new class($translator, $app) extends Translator {
                protected $baseTranslator;

                public function __construct($translator, $app)
                {
                    $this->baseTranslator = $translator;
                    parent::__construct($translator->getLoader(), $app['config']['app.locale']);
                }

                /**
                 * Get the translation for the given key.
                 * Override per assicurarsi che gli override dal database vengano sempre caricati
                 */
                public function get($key, array $replace = [], $locale = null, $fallback = true)
                {
                    $locale = $locale ?: $this->locale;
                    
                    // Parse della chiave per ottenere gruppo e item
                    $segments = explode('.', $key);
                    if (count($segments) < 2) {
                        return parent::get($key, $replace, $locale, $fallback);
                    }
                    
                    $group = $segments[0];
                    $item = implode('.', array_slice($segments, 1));
                    
                    // Prova a caricare l'override dal database
                    try {
                        $override = TranslationOverride::getOverride($locale, $group, $item);
                        if ($override !== null) {
                            return $this->makeReplacements($override, $replace);
                        }
                    } catch (\Exception $e) {
                        // Ignora errori
                    }
                    
                    // Se non c'è override, usa il comportamento standard
                    return parent::get($key, $replace, $locale, $fallback);
                }

                /**
                 * Get all translations for a given group.
                 */
                public function getLoader()
                {
                    return $this->baseTranslator->getLoader();
                }
            };
        });
    }
}
