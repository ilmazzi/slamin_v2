<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UploadSettings extends Component
{
    public $settings = [];

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }

        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->settings = SystemSetting::where('group', 'upload')
            ->get()
            ->mapWithKeys(function ($setting) {
                // Converti il valore in base al tipo
                $value = $setting->value;
                
                switch ($setting->type) {
                    case 'integer':
                        $value = (int) $value;
                        break;
                    case 'boolean':
                        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                        break;
                    case 'json':
                        if (is_string($value)) {
                            $decoded = json_decode($value, true);
                            $value = $decoded ?? [];
                        } elseif (!is_array($value)) {
                            $value = [];
                        }
                        break;
                    case 'float':
                        $value = (float) $value;
                        break;
                    default:
                        $value = (string) $value;
                        break;
                }

                // Normalizza valore per la vista
                if ($setting->type === 'json' && is_array($value)) {
                    $value = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                } elseif ($setting->type === 'boolean') {
                    $value = $value ? '1' : '0';
                } elseif (is_null($value)) {
                    $value = '';
                } else {
                    $value = (string) $value;
                }

                return [$setting->key => $value];
            })
            ->toArray();
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function updateSettings()
    {
        $this->validate([
            'settings.*' => 'nullable'
        ]);

        $updated = 0;
        $errors = [];

        foreach ($this->settings as $key => $value) {
            try {
                $setting = SystemSetting::where('key', $key)->first();

                if (!$setting) {
                    $setting = SystemSetting::create([
                        'key' => $key,
                        'group' => 'upload',
                        'type' => 'string',
                        'display_name' => ucfirst(str_replace('_', ' ', $key)),
                        'description' => '',
                        'value' => $value,
                    ]);
                } else {
                    // Gestisci valori boolean come stringhe '1'/'0'
                    if ($setting->type === 'boolean') {
                        $value = ($value === '1' || $value === 1 || $value === true || $value === 'true') ? 'true' : 'false';
                    }
                    
                    // Gestisci valori JSON da stringhe
                    if ($setting->type === 'json') {
                        if (is_string($value)) {
                            $decoded = json_decode($value, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                $value = json_encode($decoded);
                            } else {
                                $errors[] = "Valore JSON non valido per '{$setting->display_name}'";
                                continue;
                            }
                        } elseif (is_array($value)) {
                            $value = json_encode($value);
                        }
                    } else {
                        $value = (string) $value;
                    }
                    
                    $setting->value = $value;
                    $setting->save();
                }

                Cache::forget("system_setting_{$key}");
                $updated++;
            } catch (\Exception $e) {
                $errors[] = "Errore nell'aggiornamento di '{$key}': " . $e->getMessage();
            }
        }

        if (count($errors) === 0) {
            session()->flash('message', "Impostazioni aggiornate con successo ({$updated} modificate)");
            $this->loadSettings();
        } else {
            session()->flash('error', "Errori nell'aggiornamento: " . implode(', ', $errors));
        }
    }

    private function validateValue($value, string $type)
    {
        return match($type) {
            'integer' => is_numeric($value) ? (int) $value : false,
            'boolean' => match(true) {
                is_bool($value) => $value,
                is_string($value) => in_array(strtolower($value), ['true', '1', 'yes', 'on']),
                default => false,
            },
            'json' => match(true) {
                is_array($value) => $value,
                is_string($value) => json_last_error() === JSON_ERROR_NONE ? json_decode($value, true) : false,
                default => false,
            },
            'float' => is_numeric($value) ? (float) $value : false,
            default => is_string($value) ? $value : false,
        };
    }

    public function resetSettings()
    {
        try {
            // Rimuovi tutte le impostazioni di upload
            SystemSetting::where('group', 'upload')->delete();
            
            // Reinizializza le impostazioni di default
            SystemSetting::initializeDefaults();
            
            $this->loadSettings();
            session()->flash('message', __('admin.settings.upload.reset_success'));
        } catch (\Exception $e) {
            session()->flash('error', __('admin.settings.upload.reset_error') . ': ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.upload-settings')
            ->layout('components.layouts.app');
    }
}

