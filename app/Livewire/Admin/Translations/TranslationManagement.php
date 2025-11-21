<?php

namespace App\Livewire\Admin\Translations;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TranslationManagement extends Component
{
    use WithPagination;

    public $selectedLanguage = 'it';
    public $selectedFile = 'admin';
    public $languages = [];
    public $translationFiles = [];
    public $languageStats = [];
    public $translationData = [];
    public $stats = [];
    
    // Modal per nuova lingua
    public $showCreateLanguageModal = false;
    public $newLanguageCode = '';
    public $newLanguageName = '';

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

        $allKeys = array_unique(array_merge(array_keys($referenceTranslations), array_keys($translations)));

        $this->translationData = [];
        foreach ($allKeys as $key) {
            $referenceValue = $referenceTranslations[$key] ?? '';
            $translationValue = $translations[$key] ?? '';

            if (is_array($referenceValue)) {
                $referenceValue = json_encode($referenceValue, JSON_UNESCAPED_UNICODE);
            }
            if (is_array($translationValue)) {
                $translationValue = json_encode($translationValue, JSON_UNESCAPED_UNICODE);
            }

            $this->translationData[$key] = [
                'reference' => $referenceValue,
                'translation' => $translationValue,
                'is_translated' => !empty($translations[$key]) && !empty(trim($translationValue)),
                'is_missing' => empty($translations[$key]) || empty(trim($translationValue)),
            ];
        }

        $this->stats = [
            'total_keys' => count($allKeys),
            'translated_keys' => count(array_filter($this->translationData, fn($item) => $item['is_translated'])),
            'missing_keys' => count(array_filter($this->translationData, fn($item) => $item['is_missing'])),
            'progress_percentage' => count($allKeys) > 0 
                ? round((count(array_filter($this->translationData, fn($item) => $item['is_translated'])) / count($allKeys)) * 100, 1) 
                : 0
        ];
    }

    public function updatedSelectedLanguage()
    {
        $this->loadTranslationData();
        $this->resetPage();
    }

    public function updatedSelectedFile()
    {
        $this->loadTranslationData();
        $this->resetPage();
    }

    public function saveTranslation($key, $value)
    {
        try {
            $translations = $this->getTranslations($this->selectedLanguage, $this->selectedFile);
            $translations[$key] = $value;
            $this->saveTranslations($this->selectedLanguage, $this->selectedFile, $translations);
            
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
        $filePath = lang_path($language . '/' . $file . '.php');

        if (!File::exists($filePath)) {
            return [];
        }

        try {
            $result = include $filePath;
            return is_array($result) ? $result : [];
        } catch (\Exception $e) {
            Log::error("Error loading translation file: {$filePath} - " . $e->getMessage());
            return [];
        }
    }

    private function saveTranslations(string $language, string $file, array $translations): void
    {
        $filePath = lang_path($language . '/' . $file . '.php');

        $directory = dirname($filePath);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $content = "<?php\n\nreturn [\n";

        foreach ($translations as $key => $value) {
            $escapedKey = addslashes($key);
            
            if (is_array($value)) {
                $content .= "    '{$escapedKey}' => [\n";
                foreach ($value as $subKey => $subValue) {
                    $escapedSubKey = addslashes($subKey);
                    $escapedSubValue = addslashes($subValue);
                    $content .= "        '{$escapedSubKey}' => '{$escapedSubValue}',\n";
                }
                $content .= "    ],\n";
            } else {
                $escapedValue = addslashes($value);
                $content .= "    '{$escapedKey}' => '{$escapedValue}',\n";
            }
        }

        $content .= "\n];\n";

        File::put($filePath, $content);
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

    public function render()
    {
        return view('livewire.admin.translations.translation-management')
            ->layout('components.layouts.app');
    }
}

