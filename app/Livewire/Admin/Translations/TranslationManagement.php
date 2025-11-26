<?php

namespace App\Livewire\Admin\Translations;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\TranslationOverride;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Ods;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TranslationManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $selectedLanguage = 'it';
    public $selectedFile = 'admin';
    public $languages = [];
    public $translationFiles = [];
    public $languageStats = [];
    public $translationData = [];
    public $stats = [];
    
    // Filtri e ricerca
    public $search = '';
    public $filterStatus = 'all'; // all, translated, missing
    public $editingKey = null;
    public $editingValue = '';
    
    // Modal per nuova lingua
    public $showCreateLanguageModal = false;
    public $newLanguageCode = '';
    public $newLanguageName = '';
    
    // Import/Export
    public $showImportModal = false;
    public $importFile;
    public $importFormat = 'csv'; // csv, excel
    public $isImporting = false;
    public $importProgress = 0;
    public $importStatus = '';

    public function updatedImportFile()
    {
        // Reset errori quando viene selezionato un nuovo file
        $this->resetErrorBag('importFile');
        
        if ($this->importFile) {
            $extension = strtolower($this->importFile->getClientOriginalExtension());
            $allowedExtensions = ['csv', 'txt', 'xlsx', 'xls', 'ods'];
            
            if (!in_array($extension, $allowedExtensions)) {
                $this->addError('importFile', 'Il file deve essere CSV, Excel (.xlsx, .xls) o LibreOffice (.ods).');
                $this->importFile = null;
            }
        }
    }

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }

        $this->loadLanguages();
        $this->loadTranslationFiles();
        $this->loadStats();
    }

    public function loadLanguages()
    {
        $this->languages = $this->getAvailableLanguages();
        
        if (empty($this->languages)) {
            $this->languages = ['it'];
        }
        
        if (!in_array($this->selectedLanguage, $this->languages)) {
            $this->selectedLanguage = $this->languages[0];
        }
    }

    public function loadTranslationFiles()
    {
        $this->translationFiles = $this->getTranslationFiles();
        
        if (empty($this->translationFiles)) {
            $this->translationFiles = ['admin' => 'Admin'];
        }
        
        if (!isset($this->translationFiles[$this->selectedFile])) {
            $this->selectedFile = array_key_first($this->translationFiles);
        }
    }

    public function loadStats()
    {
        $this->languageStats = [];
        
        foreach ($this->languages as $lang) {
            $this->languageStats[$lang] = $this->getLanguageStats($lang);
        }
        
        $this->loadTranslationData();
    }

    public function loadTranslationData()
    {
        $referenceTranslations = $this->getTranslations('it', $this->selectedFile);
        $translations = $this->getTranslations($this->selectedLanguage, $this->selectedFile);

        $referenceTranslations = is_array($referenceTranslations) ? $referenceTranslations : [];
        $translations = is_array($translations) ? $translations : [];

        // Espandi gli array in chiavi piatte (parent.child invece di JSON)
        $flatReference = $this->flattenArray($referenceTranslations);
        $flatTranslations = $this->flattenArray($translations);

        $allKeys = array_unique(array_merge(array_keys($flatReference), array_keys($flatTranslations)));

        $this->translationData = [];
        foreach ($allKeys as $key) {
            $referenceValue = $flatReference[$key] ?? '';
            $translationValue = $flatTranslations[$key] ?? '';

            // Assicurati che i valori siano stringhe
            if (is_array($referenceValue)) {
                $referenceValue = '';
            }
            if (is_array($translationValue)) {
                $translationValue = '';
            }

            $this->translationData[$key] = [
                'reference' => (string) $referenceValue,
                'translation' => (string) $translationValue,
                'is_translated' => !empty($flatTranslations[$key]) && !empty(trim((string) $translationValue)),
                'is_missing' => empty($flatTranslations[$key]) || empty(trim((string) $translationValue)),
            ];
        }

        // Ordina le chiavi per renderle più leggibili
        ksort($this->translationData);

        $this->stats = [
            'total_keys' => count($allKeys),
            'translated_keys' => count(array_filter($this->translationData, fn($item) => $item['is_translated'])),
            'missing_keys' => count(array_filter($this->translationData, fn($item) => $item['is_missing'])),
            'progress_percentage' => count($allKeys) > 0 
                ? round((count(array_filter($this->translationData, fn($item) => $item['is_translated'])) / count($allKeys)) * 100, 1) 
                : 0
        ];
    }

    /**
     * Appiattisce un array multidimensionale in chiavi piatte
     * Es: ['parent' => ['child' => 'value']] diventa ['parent.child' => 'value']
     */
    private function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];
        
        foreach ($array as $key => $value) {
            $newKey = $prefix ? "{$prefix}.{$key}" : $key;
            
            if (is_array($value)) {
                // Se è un array, espandilo ricorsivamente
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                // Se è un valore semplice, aggiungilo
                $result[$newKey] = $value;
            }
        }
        
        return $result;
    }

    /**
     * Filtra le traduzioni in base a ricerca e stato
     */
    public function getFilteredTranslationsProperty()
    {
        $filtered = $this->translationData;

        // Filtro per ricerca
        if (!empty($this->search)) {
            $search = strtolower($this->search);
            $filtered = array_filter($filtered, function ($item, $key) use ($search) {
                return str_contains(strtolower($key), $search) 
                    || str_contains(strtolower($item['reference']), $search)
                    || str_contains(strtolower($item['translation']), $search);
            }, ARRAY_FILTER_USE_BOTH);
        }

        // Filtro per stato
        if ($this->filterStatus === 'translated') {
            $filtered = array_filter($filtered, fn($item) => $item['is_translated']);
        } elseif ($this->filterStatus === 'missing') {
            $filtered = array_filter($filtered, fn($item) => $item['is_missing']);
        }

        return $filtered;
    }

    /**
     * Inizia editing di una chiave
     */
    public function startEditing($key)
    {
        $this->editingKey = $key;
        $this->editingValue = $this->translationData[$key]['translation'] ?? '';
    }

    /**
     * Annulla editing
     */
    public function cancelEditing()
    {
        $this->editingKey = null;
        $this->editingValue = '';
    }

    /**
     * Salva traduzione in editing
     */
    public function saveEditing()
    {
        if ($this->editingKey) {
            // Se la chiave contiene punti (chiave annidata), dobbiamo ricostruire l'array
            if (str_contains($this->editingKey, '.')) {
                $this->saveNestedTranslation($this->editingKey, $this->editingValue);
            } else {
                $this->saveTranslation($this->editingKey, $this->editingValue);
            }
            $this->cancelEditing();
            $this->loadTranslationData(); // Ricarica per aggiornare la vista
        }
    }

    /**
     * Salva una traduzione annidata (chiave con punti)
     */
    private function saveNestedTranslation(string $flatKey, string $value)
    {
        // Per ora salviamo come chiave piatta nel database
        // Il sistema ibrido gestirà correttamente la ricostruzione
        $this->saveTranslation($flatKey, $value);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedSelectedLanguage()
    {
        $this->loadTranslationData();
        $this->resetPage();
        $this->cancelEditing();
    }

    public function updatedSelectedFile()
    {
        $this->loadTranslationData();
        $this->resetPage();
        $this->cancelEditing();
    }

    public function saveTranslation($key, $value)
    {
        try {
            // Salva nel database (sistema ibrido)
            TranslationOverride::setOverride(
                $this->selectedLanguage,
                $this->selectedFile,
                $key,
                $value,
                Auth::id()
            );
            
            session()->flash('success', __('admin.translations.translation_saved'));
            $this->loadTranslationData();
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', __('admin.translations.save_error') . ': ' . $e->getMessage());
        }
    }

    public function saveAllTranslations($translations)
    {
        try {
            $this->saveTranslations($this->selectedLanguage, $this->selectedFile, $translations);
            session()->flash('success', __('admin.translations.translations_saved'));
            $this->loadTranslationData();
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', __('admin.translations.save_error') . ': ' . $e->getMessage());
        }
    }

    public function createLanguage()
    {
        $this->validate([
            'newLanguageCode' => 'required|string|size:2|regex:/^[a-z]{2}$/',
            'newLanguageName' => 'required|string|max:50',
        ]);

        $languageCode = strtolower($this->newLanguageCode);

        if ($this->languageExists($languageCode)) {
            session()->flash('error', __('admin.translations.language_exists'));
            return;
        }

        try {
            $languagePath = lang_path($languageCode);
            if (!File::exists($languagePath)) {
                File::makeDirectory($languagePath, 0755, true);
            }

            // Copia tutti i file dall'italiano
            $italianPath = lang_path('it');
            if (File::exists($italianPath)) {
                $files = File::allFiles($italianPath);
                foreach ($files as $file) {
                    if (!$file->isFile()) continue;
                    $relativePath = $file->getRelativePathname();
                    $targetPath = $languagePath . '/' . $relativePath;
                    File::copy($file->getPathname(), $targetPath);
                }
            }

            session()->flash('success', __('admin.translations.language_created'));
            $this->showCreateLanguageModal = false;
            $this->newLanguageCode = '';
            $this->newLanguageName = '';
            $this->loadLanguages();
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', __('admin.translations.create_error') . ': ' . $e->getMessage());
        }
    }

    public function deleteLanguage($languageCode)
    {
        if ($languageCode === 'it') {
            session()->flash('error', __('admin.translations.cannot_delete_italian'));
            return;
        }

        if (!$this->languageExists($languageCode)) {
            session()->flash('error', __('admin.translations.language_not_found'));
            return;
        }

        try {
            $languagePath = lang_path($languageCode);
            if (File::exists($languagePath)) {
                File::deleteDirectory($languagePath);
            }

            session()->flash('success', __('admin.translations.language_deleted'));
            
            if ($this->selectedLanguage === $languageCode) {
                $this->selectedLanguage = 'it';
            }
            
            $this->loadLanguages();
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', __('admin.translations.delete_error') . ': ' . $e->getMessage());
        }
    }

    public function syncLanguage($languageCode = null)
    {
        $languages = $languageCode ? [$languageCode] : $this->languages;

        $updatedFiles = 0;
        foreach ($languages as $lang) {
            if ($lang === 'it') continue;
            $updatedFiles += $this->syncLanguageFiles($lang);
        }

        session()->flash('success', __('admin.translations.sync_completed', ['count' => $updatedFiles]));
        $this->loadStats();
    }

    public function copyFromItalian()
    {
        $italianTranslations = $this->getTranslations('it', $this->selectedFile);
        try {
            $this->saveTranslations($this->selectedLanguage, $this->selectedFile, $italianTranslations);
            session()->flash('success', __('admin.translations.copied_from_italian'));
            $this->loadTranslationData();
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', __('admin.translations.copy_error') . ': ' . $e->getMessage());
        }
    }

    public function clearAll()
    {
        try {
            $this->saveTranslations($this->selectedLanguage, $this->selectedFile, []);
            session()->flash('success', __('admin.translations.cleared'));
            $this->loadTranslationData();
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', __('admin.translations.clear_error') . ': ' . $e->getMessage());
        }
    }

    // Metodi privati helper

    private function getAvailableLanguages(): array
    {
        $languages = [];
        $langPath = lang_path();

        if (File::exists($langPath)) {
            $directories = File::directories($langPath);
            foreach ($directories as $dir) {
                $languageCode = basename($dir);
                $languages[] = $languageCode;
            }
        }

        sort($languages);
        return $languages;
    }

    private function getTranslationFiles(): array
    {
        $files = [];
        $italianPath = lang_path('it');

        if (File::exists($italianPath)) {
            $fileObjects = File::allFiles($italianPath);
            foreach ($fileObjects as $file) {
                if ($file->isDir()) continue;

                $filename = $file->getFilenameWithoutExtension();
                if (str_starts_with($filename, 'backup_')) continue;

                $files[$filename] = $this->getFileDisplayName($filename);
            }
        }

        ksort($files);
        return $files;
    }

    private function getFileDisplayName($filename): string
    {
        $displayNames = [
            'admin' => __('admin.translations.file_admin'),
            'auth' => __('admin.translations.file_auth'),
            'common' => __('admin.translations.file_common'),
            'dashboard' => __('admin.translations.file_dashboard'),
            'events' => __('admin.translations.file_events'),
            'videos' => __('admin.translations.file_videos'),
            'carousel' => __('admin.translations.file_carousel'),
            'home' => 'Home',
            'poems' => 'Poems',
            'profile' => 'Profile',
        ];

        return $displayNames[$filename] ?? ucfirst($filename);
    }

    private function languageExists(string $language): bool
    {
        return File::exists(lang_path($language));
    }

    private function getTranslations(string $language, string $file): array
    {
        // Carica prima dai file PHP
        $filePath = lang_path($language . '/' . $file . '.php');
        $fileTranslations = [];

        if (File::exists($filePath)) {
            try {
                $result = include $filePath;
                $fileTranslations = is_array($result) ? $result : [];
            } catch (\Exception $e) {
                Log::error("Error loading translation file: {$filePath} - " . $e->getMessage());
            }
        }

        // Poi applica override dal database (hanno priorità)
        $overrides = TranslationOverride::getOverridesForGroup($language, $file);

        // Merge: gli override dal database hanno priorità
        return array_merge($fileTranslations, $overrides);
    }

    private function saveTranslations(string $language, string $file, array $translations): void
    {
        $filePath = lang_path($language . '/' . $file . '.php');

        $directory = dirname($filePath);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $content = "<?php\n\nreturn [\n";
        $content .= $this->formatTranslationsArray($translations, 1);
        $content .= "\n];\n";

        File::put($filePath, $content);
    }

    /**
     * Formatta ricorsivamente un array di traduzioni in codice PHP
     */
    private function formatTranslationsArray(array $array, int $indent = 1): string
    {
        $content = '';
        $indentStr = str_repeat('    ', $indent);
        
        foreach ($array as $key => $value) {
            $escapedKey = addslashes($key);
            
            if (is_array($value)) {
                $content .= "{$indentStr}'{$escapedKey}' => [\n";
                $content .= $this->formatTranslationsArray($value, $indent + 1);
                $content .= "{$indentStr}],\n";
            } else {
                $escapedValue = addslashes((string)$value);
                $content .= "{$indentStr}'{$escapedKey}' => '{$escapedValue}',\n";
            }
        }
        
        return $content;
    }

    private function syncLanguageFiles(string $language): int
    {
        $updatedFiles = 0;
        $italianPath = lang_path('it');
        $languagePath = lang_path($language);

        if (!File::exists($italianPath) || !File::exists($languagePath)) {
            return $updatedFiles;
        }

        $italianFiles = File::allFiles($italianPath);

        foreach ($italianFiles as $file) {
            if (!$file->isFile()) continue;

            $filename = $file->getFilenameWithoutExtension();
            $relativePath = $file->getRelativePathname();
            $targetPath = $languagePath . '/' . $relativePath;

            $italianTranslations = $this->getTranslations('it', $filename);
            $existingTranslations = File::exists($targetPath) ? $this->getTranslations($language, $filename) : [];

            $mergedTranslations = array_merge($italianTranslations, $existingTranslations);

            if ($mergedTranslations !== $existingTranslations) {
                $this->saveTranslations($language, $filename, $mergedTranslations);
                $updatedFiles++;
            }
        }

        return $updatedFiles;
    }

    private function getLanguageStats(string $language): array
    {
        $translationFiles = $this->getTranslationFiles();
        $totalKeys = 0;
        $translatedKeys = 0;
        $missingKeys = 0;

        foreach ($translationFiles as $fileKey => $fileDisplayName) {
            $referenceTranslations = $this->getTranslations('it', $fileKey);
            $translations = $this->getTranslations($language, $fileKey);

            $referenceTranslations = is_array($referenceTranslations) ? $referenceTranslations : [];
            $translations = is_array($translations) ? $translations : [];

            $totalKeys += count($referenceTranslations);

            foreach ($referenceTranslations as $key => $referenceValue) {
                $translationValue = $translations[$key] ?? '';

                if (is_array($translationValue)) {
                    $translationValue = json_encode($translationValue, JSON_UNESCAPED_UNICODE);
                }

                if (isset($translations[$key]) && !empty(trim($translationValue))) {
                    $translatedKeys++;
                } else {
                    $missingKeys++;
                }
            }
        }

        return [
            'total_keys' => $totalKeys,
            'translated_keys' => $translatedKeys,
            'missing_keys' => $missingKeys,
            'progress_percentage' => $totalKeys > 0 ? round(($translatedKeys / $totalKeys) * 100, 1) : 0
        ];
    }

    /**
     * Export traduzioni in Excel con sheet multipli (uno per file)
     * User-friendly: ogni file di traduzione ha il suo sheet
     */
    public function exportTranslations($format = 'excel')
    {
        try {
            // Determina estensione e writer in base al formato
            $extension = ($format === 'ods') ? 'ods' : 'xlsx';
            $filename = "translations_{$this->selectedLanguage}_" . now()->format('Y-m-d_His') . ".{$extension}";
            $filePath = storage_path('app/temp/' . $filename);
            
            // Crea directory temp se non esiste
            $tempDir = storage_path('app/temp');
            if (!File::exists($tempDir)) {
                File::makeDirectory($tempDir, 0755, true);
            }

            // Crea nuovo spreadsheet
            $spreadsheet = new Spreadsheet();
            $spreadsheet->removeSheetByIndex(0); // Rimuovi sheet di default

            $sheetIndex = 0;

            // Crea un sheet per ogni file di traduzione
            foreach ($this->translationFiles as $fileKey => $fileDisplayName) {
                $referenceTranslations = $this->getTranslations('it', $fileKey);
                $translations = $this->getTranslations($this->selectedLanguage, $fileKey);

                // Appiattisci gli array
                $flatReference = $this->flattenArray($referenceTranslations);
                $flatTranslations = $this->flattenArray($translations);

                // Crea sheet per questo file
                $sheet = $spreadsheet->createSheet($sheetIndex);
                $sheet->setTitle($this->sanitizeSheetName($fileDisplayName));
                
                $this->populateSheet($sheet, $flatReference, $flatTranslations, $fileKey);
                
                $sheetIndex++;
            }

            // Crea sheet README con istruzioni
            $readmeSheet = $spreadsheet->createSheet($sheetIndex);
            $readmeSheet->setTitle('📖 ISTRUZIONI');
            $this->populateReadmeSheet($readmeSheet);

            // Salva file con il writer appropriato
            if ($format === 'ods') {
                $writer = new Ods($spreadsheet);
            } else {
                $writer = new Xlsx($spreadsheet);
            }
            $writer->save($filePath);

            // Download del file
            return response()->download($filePath, $filename)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->flash('error', __('admin.translations.export_error') . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Popola un sheet con le traduzioni
     */
    private function populateSheet($sheet, array $flatReference, array $flatTranslations, string $fileKey)
    {
        // Header
        $sheet->setCellValue('A1', 'Chiave');
        $sheet->setCellValue('B1', 'Italiano (IT)');
        $sheet->setCellValue('C1', 'Traduzione (' . strtoupper($this->selectedLanguage) . ')');
        $sheet->setCellValue('D1', 'Stato');
        $sheet->setCellValue('E1', 'Note');

        // Stile header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'], // Indigo
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        // Larghezza colonne
        $sheet->getColumnDimension('A')->setWidth(40); // Chiave
        $sheet->getColumnDimension('B')->setWidth(50); // Italiano
        $sheet->getColumnDimension('C')->setWidth(50); // Traduzione
        $sheet->getColumnDimension('D')->setWidth(15); // Stato
        $sheet->getColumnDimension('E')->setWidth(30); // Note

        // Ordina le chiavi
        $allKeys = array_unique(array_merge(array_keys($flatReference), array_keys($flatTranslations)));
        ksort($allKeys);

        $row = 2;
        foreach ($allKeys as $key) {
            $referenceValue = (string) ($flatReference[$key] ?? '');
            $translationValue = (string) ($flatTranslations[$key] ?? '');
            $isTranslated = !empty(trim($translationValue));
            $status = $isTranslated ? 'Tradotto' : 'Da Tradurre';
            $note = $isTranslated ? '' : 'Completare questa traduzione';

            // Dati
            $sheet->setCellValue('A' . $row, $key);
            $sheet->setCellValue('B' . $row, $referenceValue);
            $sheet->setCellValue('C' . $row, $translationValue);
            $sheet->setCellValue('D' . $row, $status);
            $sheet->setCellValue('E' . $row, $note);

            // Stile riga
            $rowStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E5E7EB'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrapText' => true,
                ],
            ];

            // Colore di sfondo per righe mancanti
            if (!$isTranslated) {
                $rowStyle['fill'] = [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FEF2F2'], // Rosso chiaro
                ];
            }

            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($rowStyle);

            // Colore stato
            if ($isTranslated) {
                $sheet->getStyle('D' . $row)->applyFromArray([
                    'font' => ['color' => ['rgb' => '059669'], 'bold' => true], // Verde
                ]);
            } else {
                $sheet->getStyle('D' . $row)->applyFromArray([
                    'font' => ['color' => ['rgb' => 'DC2626'], 'bold' => true], // Rosso
                ]);
            }

            $row++;
        }

        // Freeze prima riga (header)
        $sheet->freezePane('A2');

        // Auto-filter
        $sheet->setAutoFilter('A1:E' . ($row - 1));
    }

    /**
     * Popola il sheet README con istruzioni
     */
    private function populateReadmeSheet($sheet)
    {
        $instructions = [
            ['═══════════════════════════════════════════════════════════════'],
            ['  ISTRUZIONI PER LA TRADUZIONE - SLAMIN v2'],
            ['═══════════════════════════════════════════════════════════════'],
            [''],
            ['Lingua di destinazione: ' . strtoupper($this->selectedLanguage)],
            ['Data export: ' . now()->format('d/m/Y H:i:s')],
            [''],
            ['───────────────────────────────────────────────────────────────'],
            ['COME USARE QUESTO FILE:'],
            ['───────────────────────────────────────────────────────────────'],
            [''],
            ['1. Questo file Excel contiene un foglio (sheet) per ogni sezione'],
            ['   di traduzione (admin, auth, common, ecc.)'],
            [''],
            ['2. Ogni foglio contiene queste colonne:'],
            ['   - Chiave: Identificatore tecnico (NON MODIFICARE)'],
            ['   - Italiano (IT): Testo di riferimento in italiano'],
            ['   - Traduzione (' . strtoupper($this->selectedLanguage) . '): La tua traduzione'],
            ['   - Stato: Stato della traduzione'],
            ['   - Note: Note aggiuntive'],
            [''],
            ['3. Compila la colonna "Traduzione (' . strtoupper($this->selectedLanguage) . ')" con la tua traduzione'],
            [''],
            ['4. IMPORTANTE:'],
            ['   - NON modificare la colonna "Chiave"'],
            ['   - NON modificare la colonna "Italiano (IT)"'],
            ['   - Compila SOLO la colonna "Traduzione (' . strtoupper($this->selectedLanguage) . ')"'],
            ['   - Le righe in rosso chiaro richiedono traduzione'],
            [''],
            ['5. Quando hai finito, salva il file e invialo indietro'],
            [''],
            ['───────────────────────────────────────────────────────────────'],
            ['NOTE TECNICHE:'],
            ['───────────────────────────────────────────────────────────────'],
            [''],
            ['- Le chiavi con punto (es: "admin.dashboard.title") sono chiavi annidate'],
            ['- Mantieni lo stesso stile e tono del testo italiano'],
            ['- Se una traduzione è già presente, puoi modificarla o lasciarla'],
            ['- Le righe con "Da Tradurre" nello stato richiedono traduzione'],
            [''],
            ['───────────────────────────────────────────────────────────────'],
            ['GRAZIE PER IL TUO LAVORO! 🙏'],
            ['───────────────────────────────────────────────────────────────'],
        ];

        $row = 1;
        foreach ($instructions as $line) {
            $sheet->setCellValue('A' . $row, $line[0]);
            $sheet->getRowDimension($row)->setRowHeight(20);
            
            // Stile per titoli
            if (str_contains($line[0], '═══') || str_contains($line[0], '───')) {
                $sheet->getStyle('A' . $row)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                ]);
            } elseif (str_contains($line[0], 'ISTRUZIONI') || str_contains($line[0], 'COME USARE') || str_contains($line[0], 'NOTE TECNICHE')) {
                $sheet->getStyle('A' . $row)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '4F46E5']],
                ]);
            }
            
            $row++;
        }

        // Larghezza colonna
        $sheet->getColumnDimension('A')->setWidth(80);
        $sheet->getStyle('A1:A' . ($row - 1))->getAlignment()->setWrapText(true);
    }

    /**
     * Sanitizza il nome del sheet (Excel ha limiti)
     */
    private function sanitizeSheetName(string $name): string
    {
        // Excel limita a 31 caratteri e non permette alcuni caratteri
        $name = preg_replace('/[\\\\\/\?\*\[\]:]/', '_', $name);
        return mb_substr($name, 0, 31);
    }

    /**
     * Genera contenuto CSV per un file di traduzione
     */
    private function generateCsvContent(array $referenceTranslations, array $translations, string $fileKey): string
    {
        $output = fopen('php://temp', 'r+');
        
        // BOM UTF-8 per Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        fputcsv($output, [
            'Chiave',
            'Italiano (IT)',
            'Traduzione (' . strtoupper($this->selectedLanguage) . ')',
            'Stato',
            'Note'
        ], ';');

        // Ordina le chiavi
        $allKeys = array_unique(array_merge(array_keys($referenceTranslations), array_keys($translations)));
        ksort($allKeys);

        // Dati
        foreach ($allKeys as $key) {
            $referenceValue = $referenceTranslations[$key] ?? '';
            $translationValue = $translations[$key] ?? '';
            
            // Assicurati che siano stringhe
            if (is_array($referenceValue)) {
                $referenceValue = '';
            }
            if (is_array($translationValue)) {
                $translationValue = '';
            }

            $referenceValue = (string) $referenceValue;
            $translationValue = (string) $translationValue;

            $status = !empty(trim($translationValue)) ? 'Tradotto' : 'Da Tradurre';
            $note = empty(trim($translationValue)) ? 'Completare questa traduzione' : '';

            fputcsv($output, [
                $key,
                $referenceValue,
                $translationValue,
                $status,
                $note
            ], ';');
        }

        rewind($output);
        $content = stream_get_contents($output);
        fclose($output);

        return $content;
    }

    /**
     * Genera README con istruzioni per i traduttori
     */
    private function generateReadme(): string
    {
        $readme = "═══════════════════════════════════════════════════════════════\n";
        $readme .= "  ISTRUZIONI PER LA TRADUZIONE - SLAMIN v2\n";
        $readme .= "═══════════════════════════════════════════════════════════════\n\n";
        $readme .= "Lingua di destinazione: " . strtoupper($this->selectedLanguage) . "\n";
        $readme .= "Data export: " . now()->format('d/m/Y H:i:s') . "\n\n";
        $readme .= "───────────────────────────────────────────────────────────────\n";
        $readme .= "COME USARE QUESTO FILE:\n";
        $readme .= "───────────────────────────────────────────────────────────────\n\n";
        $readme .= "1. Questo ZIP contiene un file CSV per ogni sezione di traduzione\n";
        $readme .= "   (admin.csv, auth.csv, common.csv, ecc.)\n\n";
        $readme .= "2. Apri ogni CSV con Excel, LibreOffice Calc o Google Sheets\n\n";
        $readme .= "3. Troverai queste colonne:\n";
        $readme .= "   - Chiave: Identificatore tecnico (NON MODIFICARE)\n";
        $readme .= "   - Italiano (IT): Testo di riferimento in italiano\n";
        $readme .= "   - Traduzione (" . strtoupper($this->selectedLanguage) . "): La tua traduzione\n";
        $readme .= "   - Stato: Stato della traduzione\n";
        $readme .= "   - Note: Note aggiuntive\n\n";
        $readme .= "4. Compila la colonna 'Traduzione (" . strtoupper($this->selectedLanguage) . ")' con la tua traduzione\n\n";
        $readme .= "5. IMPORTANTE:\n";
        $readme .= "   - NON modificare la colonna 'Chiave'\n";
        $readme .=   "   - NON modificare la colonna 'Italiano (IT)'\n";
        $readme .=   "   - Compila SOLO la colonna 'Traduzione (" . strtoupper($this->selectedLanguage) . ")'\n";
        $readme .=   "   - Mantieni il formato CSV (punto e virgola come separatore)\n\n";
        $readme .= "6. Quando hai finito, salva i file CSV e inviali indietro\n\n";
        $readme .= "───────────────────────────────────────────────────────────────\n";
        $readme .= "NOTE TECNICHE:\n";
        $readme .= "───────────────────────────────────────────────────────────────\n\n";
        $readme .= "- Le chiavi con punto (es: 'admin.dashboard.title') sono chiavi annidate\n";
        $readme .= "- Mantieni lo stesso stile e tono del testo italiano\n";
        $readme .= "- Se una traduzione è già presente, puoi modificarla o lasciarla\n";
        $readme .= "- Le righe con 'Da Tradurre' nello stato richiedono traduzione\n\n";
        $readme .= "───────────────────────────────────────────────────────────────\n";
        $readme .= "GRAZIE PER IL TUO LAVORO! 🙏\n";
        $readme .= "───────────────────────────────────────────────────────────────\n";

        return $readme;
    }
    
    /**
     * Download export - metodo helper per Livewire
     */
    public function downloadExport($format = 'excel')
    {
        $response = $this->exportTranslations($format);
        if ($response) {
            return $response;
        }
        session()->flash('error', __('admin.translations.export_error'));
        return redirect()->back();
    }


    /**
     * Import traduzioni da file CSV/Excel
     */
    public function importTranslations()
    {
        // Verifica che il file sia stato caricato
        if (!$this->importFile) {
            session()->flash('error', 'Nessun file selezionato. Seleziona un file prima di importare.');
            return;
        }

        // Imposta lo stato di importazione PRIMA della validazione per mostrare subito la barra
        $this->isImporting = true;
        $this->importProgress = 0;
        $this->importStatus = 'Validazione file...';
        
        // Log per debug
        Log::info('Import started', [
            'file' => $this->importFile ? $this->importFile->getClientOriginalName() : 'null',
            'extension' => $this->importFile ? $this->importFile->getClientOriginalExtension() : 'null',
            'size' => $this->importFile ? $this->importFile->getSize() : 'null'
        ]);

        try {
            // Validazione più permissiva per ODS (il MIME type può variare)
            $this->validate([
                'importFile' => [
                    'required',
                    'file',
                    'max:10240', // 10MB max
                    function ($attribute, $value, $fail) {
                        if (!$value) {
                            $fail('Il file è obbligatorio.');
                            return;
                        }
                        
                        $extension = strtolower($value->getClientOriginalExtension());
                        $allowedExtensions = ['csv', 'txt', 'xlsx', 'xls', 'ods'];
                        
                        if (!in_array($extension, $allowedExtensions)) {
                            $fail('Il file deve essere CSV, Excel (.xlsx, .xls) o LibreOffice (.ods). Estensione rilevata: ' . $extension);
                        }
                    },
                ],
            ], [
                'importFile.required' => 'Seleziona un file da importare.',
                'importFile.file' => 'Il file selezionato non è valido.',
                'importFile.max' => 'Il file è troppo grande. Dimensione massima: 10MB.',
            ]);

            $this->importStatus = 'Inizio importazione...';
            $this->importProgress = 5;

            $this->importStatus = 'Caricamento file...';
            $this->importProgress = 10;
            $path = $this->importFile->store('temp-imports');
            $fullPath = Storage::path($path);

            $imported = 0;
            $errors = [];
            $fileExtension = strtolower($this->importFile->getClientOriginalExtension());

            $this->importStatus = 'Analisi file...';
            $this->importProgress = 20;

            // Determina il tipo di file
            if (in_array($fileExtension, ['xlsx', 'xls', 'ods'])) {
                $this->importStatus = 'Importazione da ' . strtoupper($fileExtension) . ' in corso...';
                $imported = $this->importFromExcel($fullPath, $errors);
            } else {
                $this->importStatus = 'Importazione da CSV in corso...';
                $imported = $this->importFromCsv($fullPath, $errors);
            }

            $this->importProgress = 90;
            $this->importStatus = 'Pulizia file temporanei...';

            // Pulisci file temporaneo
            Storage::delete($path);

            $this->importProgress = 100;
            $this->importStatus = 'Completato!';
            
            Log::info('Import completed', [
                'imported' => $imported,
                'errors_count' => count($errors)
            ]);

            if ($imported > 0) {
                session()->flash('success', __('admin.translations.import_success', ['count' => $imported]));
            } else {
                session()->flash('warning', 'Nessuna traduzione importata. Verifica il formato del file.');
            }

            if (count($errors) > 0) {
                session()->flash('warning', __('admin.translations.import_errors', ['count' => count($errors)]) . ' Controlla i log per i dettagli.');
                Log::warning('Translation import errors', ['errors' => $errors]);
            }

            // Aspetta un attimo prima di chiudere per mostrare il messaggio
            sleep(1);
            
            $this->showImportModal = false;
            $this->importFile = null;
            $this->loadTranslationData();
            $this->loadStats();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Errore di validazione - ripristina lo stato
            $this->isImporting = false;
            $this->importProgress = 0;
            $this->importStatus = '';
            throw $e; // Rilancia per mostrare gli errori di validazione
        } catch (\Exception $e) {
            $this->importStatus = 'Errore durante l\'importazione!';
            
            session()->flash('error', __('admin.translations.import_error') . ': ' . $e->getMessage());
            Log::error('Translation import error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $this->importFile ? $this->importFile->getClientOriginalName() : 'null'
            ]);
        } finally {
            // Ripristina lo stato solo se non è un errore di validazione
            if ($this->isImporting) {
                $this->isImporting = false;
                $this->importProgress = 0;
                $this->importStatus = '';
                $this->dispatch('import-completed');
            }
        }
    }

    /**
     * Import da CSV
     */
    private function importFromCsv(string $filePath, array &$errors): int
    {
        $imported = 0;
        $batch = [];
        $batchSize = 100;
        $userId = Auth::id();
        $handle = fopen($filePath, 'r');

        if (!$handle) {
            throw new \Exception('Impossibile aprire il file');
        }

        // Salta header (prima riga)
        $header = fgetcsv($handle, 0, ';');
        if (!$header) {
            fclose($handle);
            return 0;
        }

        // Determina l'indice della colonna traduzione
        $translationColIndex = null;
        foreach ($header as $index => $col) {
            $col = strtolower(trim($col));
            if (str_contains($col, 'traduzione') || str_contains($col, 'translation')) {
                $translationColIndex = $index;
                break;
            }
        }

        if ($translationColIndex === null) {
            $errors[] = 'Colonna "Traduzione" non trovata nell\'header';
            fclose($handle);
            return 0;
        }

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            if (count($row) < 2) {
                continue; // Salta righe vuote o incomplete
            }

            $key = trim($row[0] ?? '');
            $translation = trim($row[$translationColIndex] ?? '');

            if (empty($key)) {
                continue;
            }

            if (!empty($translation)) {
                try {
                    // Aggiungi al batch invece di salvare immediatamente
                    $batch[] = [
                        'locale' => $this->selectedLanguage,
                        'group' => $this->selectedFile,
                        'key' => $key,
                        'value' => $translation,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    
                    // Quando il batch raggiunge la dimensione, inserisci
                    if (count($batch) >= 100) {
                        DB::table('translation_overrides')->upsert(
                            $batch,
                            ['locale', 'group', 'key'],
                            ['value', 'created_by', 'updated_at']
                        );
                        $imported += count($batch);
                        $batch = [];
                    }
                } catch (\Exception $e) {
                    $errors[] = "Errore chiave '{$key}': " . $e->getMessage();
                }
            }
        }

        // Inserisci le traduzioni rimanenti nel batch
        if (!empty($batch)) {
            DB::table('translation_overrides')->upsert(
                $batch,
                ['locale', 'group', 'key'],
                ['value', 'created_by', 'updated_at']
            );
            $imported += count($batch);
        }
        
        // Pulisci la cache una volta alla fine
        TranslationOverride::clearCacheForLocaleAndGroup($this->selectedLanguage, $this->selectedFile);
        
        fclose($handle);
        return $imported;
    }

    /**
     * Import da Excel - supporta file con fogli multipli
     */
    private function importFromExcel(string $filePath, array &$errors): int
    {
        $imported = 0;

        try {
            $this->importStatus = 'Caricamento file Excel/ODS...';
            $this->importProgress = 30;

            // Aumenta il limite di memoria e tempo per file grandi
            $originalMemoryLimit = ini_get('memory_limit');
            $originalMaxExecutionTime = ini_get('max_execution_time');
            ini_set('memory_limit', '1024M');
            set_time_limit(600); // 10 minuti per file grandi

            try {
                // Carica il file Excel/ODS
                $spreadsheet = IOFactory::load($filePath);
                $sheetCount = $spreadsheet->getSheetCount();

                $this->importStatus = "Trovati {$sheetCount} fogli. Elaborazione in corso...";
                $this->importProgress = 40;
            } catch (\Exception $e) {
                // Ripristina limiti
                ini_set('memory_limit', $originalMemoryLimit);
                set_time_limit($originalMaxExecutionTime);
                throw $e;
            }

            // Itera su tutti i fogli
            for ($i = 0; $i < $sheetCount; $i++) {
                $sheet = $spreadsheet->getSheet($i);
                $sheetName = $sheet->getTitle();

                // Aggiorna progresso per ogni foglio
                $sheetProgress = 40 + (($i + 1) / $sheetCount) * 50; // Da 40% a 90%
                $this->importProgress = (int) $sheetProgress;
                $this->importStatus = "Elaborazione foglio " . ($i + 1) . "/{$sheetCount}: {$sheetName}...";

                // Salta il foglio ISTRUZIONI
                if (stripos($sheetName, 'istruzioni') !== false || stripos($sheetName, 'readme') !== false) {
                    continue;
                }

                // Determina il file di traduzione dal nome del foglio
                // Il nome del foglio dovrebbe corrispondere al file (es: "Admin" -> "admin")
                $fileKey = $this->findFileKeyFromSheetName($sheetName);
                
                if (!$fileKey) {
                    $errors[] = "Impossibile determinare il file di traduzione per il foglio '{$sheetName}'";
                    continue;
                }

                // Importa le traduzioni da questo foglio
                $imported += $this->importFromSheet($sheet, $fileKey, $errors);
            }

            $this->importStatus = "Importazione completata! {$imported} traduzioni importate.";
            $this->importProgress = 90;

            // Ripristina limiti
            ini_set('memory_limit', $originalMemoryLimit);
            set_time_limit($originalMaxExecutionTime);

            return $imported;
        } catch (\Exception $e) {
            // Ripristina limiti anche in caso di errore
            if (isset($originalMemoryLimit)) {
                ini_set('memory_limit', $originalMemoryLimit);
            }
            if (isset($originalMaxExecutionTime)) {
                set_time_limit($originalMaxExecutionTime);
            }

            $this->importStatus = 'Errore durante la lettura del file: ' . $e->getMessage();
            $errors[] = 'Errore durante la lettura del file Excel/ODS: ' . $e->getMessage();
            Log::error('Excel/ODS import error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $filePath,
                'file_size' => file_exists($filePath) ? filesize($filePath) : 'unknown'
            ]);
            return $imported;
        }
    }

    /**
     * Trova la chiave del file di traduzione dal nome del foglio
     */
    private function findFileKeyFromSheetName(string $sheetName): ?string
    {
        // Rimuovi emoji e caratteri speciali
        $cleanName = preg_replace('/[^\w\s-]/u', '', $sheetName);
        $cleanName = strtolower(trim($cleanName));

        // Cerca corrispondenza esatta o parziale
        foreach ($this->translationFiles as $fileKey => $fileDisplayName) {
            $cleanDisplayName = strtolower(preg_replace('/[^\w\s-]/u', '', $fileDisplayName));
            
            if ($cleanName === $cleanDisplayName || $cleanName === strtolower($fileKey)) {
                return $fileKey;
            }
        }

        // Se non trova corrispondenza, prova a usare il nome pulito come chiave
        if (isset($this->translationFiles[$cleanName])) {
            return $cleanName;
        }

        return null;
    }

    /**
     * Importa traduzioni da un singolo foglio Excel
     */
    private function importFromSheet($sheet, string $fileKey, array &$errors): int
    {
        $imported = 0;
        $batch = []; // Batch per inserimenti multipli
        $batchSize = 100; // Inserisci ogni 100 record
        $userId = Auth::id();
        
        try {
            // Usa getHighestDataRow() invece di getHighestRow() per evitare celle vuote formattate
            $highestDataRow = $sheet->getHighestDataRow();
            $highestColumn = $sheet->getHighestColumn();

            // Trova le colonne (header in prima riga)
            $headerRow = 1;
            $keyColumn = null;
            $translationColumn = null;

            // Cerca le colonne nell'header
            for ($col = 'A'; $col <= $highestColumn; $col++) {
                $cell = $sheet->getCell($col . $headerRow);
                if ($cell->getDataType() === DataType::TYPE_NULL) {
                    continue;
                }
                
                $cellValue = $cell->getCalculatedValue();
                $cellValue = strtolower(trim((string) $cellValue));

                if (str_contains($cellValue, 'chiave') || str_contains($cellValue, 'key')) {
                    $keyColumn = $col;
                }
                if (str_contains($cellValue, 'traduzione') || str_contains($cellValue, 'translation')) {
                    $translationColumn = $col;
                }
            }

            if (!$keyColumn || !$translationColumn) {
                $errors[] = "Impossibile trovare le colonne 'Chiave' e 'Traduzione' nel foglio '{$sheet->getTitle()}'";
                return 0;
            }

            // Leggi le righe (inizia dalla riga 2, dopo l'header)
            // Limita a 10000 righe per sicurezza
            $maxRows = min($highestDataRow, 10000);
            $totalRows = $maxRows - 1; // Escludi header
            
            for ($row = 2; $row <= $maxRows; $row++) {
                try {
                    $keyCell = $sheet->getCell($keyColumn . $row);
                    $translationCell = $sheet->getCell($translationColumn . $row);
                    
                    // Salta se la cella chiave è vuota o non è testo
                    if ($keyCell->getDataType() === DataType::TYPE_NULL) {
                        continue;
                    }
                    
                    $key = trim((string) $keyCell->getCalculatedValue());
                    $translation = trim((string) $translationCell->getCalculatedValue());

                    // Salta righe vuote
                    if (empty($key)) {
                        continue;
                    }

                    // Valida che la chiave sia una stringa valida (non binari)
                    if (!$this->isValidTranslationKey($key)) {
                        continue; // Salta chiavi non valide senza loggare (probabilmente dati binari)
                    }

                    // Importa solo se c'è una traduzione
                    if (!empty($translation)) {
                        // Valida anche la traduzione
                        if (!$this->isValidTranslationValue($translation)) {
                            continue;
                        }
                        
                        // Aggiungi al batch invece di salvare immediatamente
                        $batch[] = [
                            'locale' => $this->selectedLanguage,
                            'group' => $fileKey,
                            'key' => $key,
                            'value' => $translation,
                            'created_by' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        
                        // Quando il batch raggiunge la dimensione, inserisci
                        if (count($batch) >= $batchSize) {
                            $this->batchInsertTranslations($batch);
                            $imported += count($batch);
                            $batch = []; // Reset batch
                        }
                    }
                } catch (\Exception $e) {
                    // Salta righe con errori senza loggare (probabilmente dati non validi)
                    continue;
                }
            }
            
            // Inserisci le traduzioni rimanenti nel batch
            if (!empty($batch)) {
                $this->batchInsertTranslations($batch);
                $imported += count($batch);
            }
            
            // Pulisci la cache una volta alla fine invece di per ogni elemento
            TranslationOverride::clearCacheForLocaleAndGroup($this->selectedLanguage, $fileKey);
        } catch (\Exception $e) {
            $errors[] = "Errore durante l'elaborazione del foglio '{$sheet->getTitle()}': " . $e->getMessage();
            Log::error('Sheet import error', [
                'sheet' => $sheet->getTitle(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return $imported;
    }

    /**
     * Valida che una chiave di traduzione sia valida (non binari)
     */
    private function isValidTranslationKey(string $key): bool
    {
        // La chiave deve essere una stringa valida
        // Non deve contenere caratteri di controllo (eccetto spazi, tab, newline)
        // Non deve essere troppo lunga
        if (strlen($key) > 255) {
            return false;
        }
        
        // Rimuovi spazi, tab, newline e controlla se ci sono caratteri non stampabili
        $cleanKey = preg_replace('/[\s\t\n\r]/', '', $key);
        
        // Controlla se ci sono caratteri non stampabili (ASCII < 32, eccetto quelli già rimossi)
        if (preg_match('/[\x00-\x08\x0B-\x0C\x0E-\x1F]/', $cleanKey)) {
            return false;
        }
        
        // La chiave deve contenere almeno un carattere alfanumerico o punto
        if (!preg_match('/[a-zA-Z0-9._-]/', $key)) {
            return false;
        }
        
        return true;
    }

    /**
     * Valida che un valore di traduzione sia valido
     */
    private function isValidTranslationValue(string $value): bool
    {
        // Il valore può essere vuoto (verrà gestito altrove)
        if (empty($value)) {
            return false;
        }
        
        // Non deve contenere caratteri di controllo (eccetto spazi, tab, newline)
        // Rimuovi spazi, tab, newline e controlla se ci sono caratteri non stampabili
        $cleanValue = preg_replace('/[\s\t\n\r]/', '', $value);
        
        // Controlla se ci sono caratteri di controllo non validi (eccetto quelli già gestiti)
        // Permettiamo caratteri UTF-8 validi
        if (preg_match('/[\x00-\x08\x0B-\x0C\x0E-\x1F]/', $cleanValue)) {
            return false;
        }
        
        return true;
    }

    /**
     * Inserisce un batch di traduzioni in modo efficiente
     */
    private function batchInsertTranslations(array $batch): void
    {
        if (empty($batch)) {
            return;
        }

        try {
            // Usa upsert per inserire o aggiornare in batch
            DB::table('translation_overrides')->upsert(
                $batch,
                ['locale', 'group', 'key'], // Chiavi uniche per il conflitto
                ['value', 'created_by', 'updated_at'] // Colonne da aggiornare se esiste già
            );
        } catch (\Exception $e) {
            Log::error('Batch insert translations error', [
                'error' => $e->getMessage(),
                'batch_size' => count($batch)
            ]);
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.admin.translations.translation-management')
            ->layout('components.layouts.app');
    }
}

