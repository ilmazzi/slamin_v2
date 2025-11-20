<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PaymentSettings extends Component
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
        $this->settings = SystemSetting::where('group', 'payment')
            ->get()
            ->mapWithKeys(function ($setting) {
                $value = $setting->value;

                // Gestisci valori JSON
                if (is_string($value) && $this->isJson($value)) {
                    $decoded = json_decode($value, true);
                    if (isset($decoded['value'])) {
                        $value = is_string($decoded['value']) && $this->isJson($decoded['value']) 
                            ? json_decode($decoded['value'], true)['value'] ?? $decoded['value']
                            : $decoded['value'];
                    }
                }

                // Normalizza valore
                if (is_array($value)) {
                    $value = json_encode($value);
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
                        'group' => 'payment',
                        'type' => 'string',
                        'display_name' => ucfirst(str_replace('_', ' ', $key)),
                        'description' => '',
                        'value' => $value,
                    ]);
                } else {
                    $validatedValue = $this->validateValue($value, $setting->type);

                    if ($validatedValue === false) {
                        $errors[] = "Valore non valido per '{$setting->display_name}'";
                        continue;
                    }

                    $setting->value = is_array($validatedValue) ? json_encode($validatedValue) : (string) $validatedValue;
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
        // TODO: Implementare reset impostazioni pagamenti
        session()->flash('message', 'Reset impostazioni pagamenti');
    }

    public function render()
    {
        return view('livewire.admin.settings.payment-settings')
            ->layout('components.layouts.app');
    }
}

