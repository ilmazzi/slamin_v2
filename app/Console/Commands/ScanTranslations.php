<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ScanTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:scan 
                            {--path= : Path to scan (default: resources/views,app)}
                            {--output= : Output file for missing keys}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scansiona il codice per trovare chiavi di traduzione mancanti';

    protected $foundKeys = [];
    protected $missingKeys = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Scansione traduzioni in corso...');

        $paths = $this->option('path') 
            ? explode(',', $this->option('path'))
            : ['resources/views', 'app'];

        foreach ($paths as $path) {
            $fullPath = base_path($path);
            if (File::exists($fullPath)) {
                $this->scanDirectory($fullPath);
            }
        }

        $this->analyzeKeys();

        if ($this->option('output')) {
            $this->exportMissingKeys();
        }

        return 0;
    }

    /**
     * Scansiona una directory ricorsivamente
     */
    protected function scanDirectory(string $path)
    {
        $files = File::allFiles($path);

        foreach ($files as $file) {
            if (in_array($file->getExtension(), ['php', 'blade.php'])) {
                $this->scanFile($file->getPathname());
            }
        }
    }

    /**
     * Scansiona un singolo file per chiavi di traduzione
     */
    protected function scanFile(string $filePath)
    {
        $content = File::get($filePath);

        // Pattern per __('key'), __('group.key'), trans('key'), @lang('key')
        $patterns = [
            "/__\(['\"]([^'\"]+)['\"]\)/",
            "/trans\(['\"]([^'\"]+)['\"]\)/",
            "/@lang\(['\"]([^'\"]+)['\"]\)/",
            "/__\(['\"]([^'\"]+)['\"],\s*\[/", // Con parametri
            "/trans\(['\"]([^'\"]+)['\"],\s*\[/", // Con parametri
        ];

        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $content, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $key) {
                    $this->foundKeys[] = $key;
                }
            }
        }
    }

    /**
     * Analizza le chiavi trovate e verifica se esistono nei file di traduzione
     */
    protected function analyzeKeys()
    {
        $this->info('📊 Analisi chiavi...');

        $referenceLocale = 'it';
        $langPath = lang_path($referenceLocale);

        if (!File::exists($langPath)) {
            $this->error("Directory traduzioni non trovata: {$langPath}");
            return;
        }

        $translationFiles = File::allFiles($langPath);
        $existingKeys = [];

        // Carica tutte le chiavi esistenti
        foreach ($translationFiles as $file) {
            $group = $file->getFilenameWithoutExtension();
            $translations = include $file->getPathname();
            
            if (is_array($translations)) {
                $this->extractKeys($translations, $group, '', $existingKeys);
            }
        }

        // Trova chiavi mancanti
        $uniqueFoundKeys = array_unique($this->foundKeys);
        
        foreach ($uniqueFoundKeys as $key) {
            // Gestisce chiavi con punto (group.key)
            if (Str::contains($key, '.')) {
                $parts = explode('.', $key, 2);
                $group = $parts[0];
                $keyName = $parts[1];
                
                if (!isset($existingKeys["{$group}.{$keyName}"])) {
                    $this->missingKeys[] = [
                        'key' => $key,
                        'group' => $group,
                        'file' => $group . '.php',
                    ];
                }
            } else {
                // Chiave senza gruppo, cerca in tutti i file
                $found = false;
                foreach ($translationFiles as $file) {
                    $group = $file->getFilenameWithoutExtension();
                    if (isset($existingKeys["{$group}.{$key}"])) {
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $this->missingKeys[] = [
                        'key' => $key,
                        'group' => 'common', // Default
                        'file' => 'common.php',
                    ];
                }
            }
        }

        // Output risultati
        $this->newLine();
        $this->info("✅ Chiavi trovate: " . count($uniqueFoundKeys));
        $this->warn("⚠️  Chiavi mancanti: " . count($this->missingKeys));

        if (count($this->missingKeys) > 0) {
            $this->newLine();
            $this->table(
                ['Chiave', 'Gruppo', 'File'],
                array_map(function ($item) {
                    return [$item['key'], $item['group'], $item['file']];
                }, array_slice($this->missingKeys, 0, 20))
            );

            if (count($this->missingKeys) > 20) {
                $this->warn("... e altre " . (count($this->missingKeys) - 20) . " chiavi mancanti");
            }
        }
    }

    /**
     * Estrae chiavi ricorsivamente da un array di traduzioni
     */
    protected function extractKeys(array $translations, string $group, string $prefix, array &$keys)
    {
        foreach ($translations as $key => $value) {
            $fullKey = $prefix ? "{$prefix}.{$key}" : $key;
            $fullKeyWithGroup = "{$group}.{$fullKey}";
            
            $keys[$fullKeyWithGroup] = true;
            
            if (is_array($value)) {
                $this->extractKeys($value, $group, $fullKey, $keys);
            }
        }
    }

    /**
     * Esporta chiavi mancanti in un file
     */
    protected function exportMissingKeys()
    {
        $outputPath = $this->option('output');
        $content = "Chiavi di traduzione mancanti\n";
        $content .= "Generato il: " . now()->format('Y-m-d H:i:s') . "\n\n";

        foreach ($this->missingKeys as $item) {
            $content .= "{$item['key']}\t{$item['group']}\t{$item['file']}\n";
        }

        File::put($outputPath, $content);
        $this->info("📄 Report salvato in: {$outputPath}");
    }
}
