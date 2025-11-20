<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SystemSettings extends Component
{
    public $settings = [];
    public $activeGroup = 'upload'; // upload, video, moderation, payment, system

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }

        $this->loadSettings();
    }

    public function loadSettings()
    {
        $groups = [
            'upload' => 'Limiti Upload',
            'video' => 'Limiti Video',
            'moderation' => 'Moderazione',
            'payment' => 'Pagamenti e Commissioni',
            'system' => 'Impostazioni'
        ];

        $this->settings = [];
        
        foreach ($groups as $group => $displayName) {
            $groupSettings = SystemSetting::getGroup($group);

            foreach ($groupSettings as $key => $setting) {
                if (is_array($setting)) {
                    $this->settings[$group][$key] = $setting;
                } else {
                    $this->settings[$group][$key] = [
                        'value' => $setting,
                        'type' => 'string',
                        'display_name' => ucfirst(str_replace('_', ' ', $key)),
                        'description' => ''
                    ];
                }
            }
        }
    }

    public function selectGroup($group)
    {
        $this->activeGroup = $group;
    }

    public function updateSetting($key, $value)
    {
        $setting = SystemSetting::where('key', $key)->first();

        if (!$setting) {
            session()->flash('error', "Impostazione '{$key}' non trovata");
            return;
        }

        $validatedValue = $this->validateValue($value, $setting->type);

        if ($validatedValue === false) {
            session()->flash('error', "Valore non valido per '{$setting->display_name}'");
            return;
        }

        try {
            $setting->value = is_array($validatedValue) ? json_encode($validatedValue) : (string) $validatedValue;
            $setting->save();

            Cache::forget("system_setting_{$key}");

            session()->flash('message', "Impostazione '{$setting->display_name}' aggiornata");
            $this->loadSettings(); // Reload per aggiornare view
        } catch (\Exception $e) {
            session()->flash('error', "Errore nell'aggiornamento: " . $e->getMessage());
        }
    }

    public function updateSettings()
    {
        $this->validate([
            'settings.*.*.value' => 'nullable'
        ]);

        $updated = 0;
        $errors = [];

        foreach ($this->settings as $group => $groupSettings) {
            foreach ($groupSettings as $key => $setting) {
                if (!isset($setting['value'])) {
                    continue;
                }

                $settingModel = SystemSetting::where('key', $key)->first();

                if (!$settingModel) {
                    $errors[] = "Impostazione '{$key}' non trovata";
                    continue;
                }

                $validatedValue = $this->validateValue($setting['value'], $settingModel->type);

                if ($validatedValue === false) {
                    $errors[] = "Valore non valido per '{$settingModel->display_name}'";
                    continue;
                }

                try {
                    $settingModel->value = is_array($validatedValue) ? json_encode($validatedValue) : (string) $validatedValue;
                    $settingModel->save();

                    Cache::forget("system_setting_{$key}");
                    $updated++;
                } catch (\Exception $e) {
                    $errors[] = "Errore nell'aggiornamento di '{$key}': " . $e->getMessage();
                }
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
                is_string($value) => in_array(strtolower($value), ['true', '1', 'yes', 'on']) ? true :
                                   (in_array(strtolower($value), ['false', '0', 'no', 'off']) ? false : false),
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
            SystemSetting::initializeDefaults();
            $this->loadSettings();
            session()->flash('message', 'Impostazioni reimpostate ai valori di default');
        } catch (\Exception $e) {
            session()->flash('error', 'Errore nel reset: ' . $e->getMessage());
        }
    }

    public function getGroupsProperty()
    {
        return [
            'upload' => 'Limiti Upload',
            'video' => 'Limiti Video',
            'moderation' => 'Moderazione',
            'payment' => 'Pagamenti e Commissioni',
            'system' => 'Impostazioni'
        ];
    }

    public function render()
    {
        return view('livewire.admin.settings.system-settings')
            ->layout('components.layouts.app');
    }
}

