<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\SystemSetting;
use App\Services\PeerTubeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PeerTubeSettings extends Component
{
    public $settings = [];
    public $isConfigured = false;
    public $connectionTest = null;

    protected $peerTubeService;

    public function mount(PeerTubeService $peerTubeService)
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }

        $this->peerTubeService = $peerTubeService;
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $settings = SystemSetting::where('group', 'peertube')
            ->pluck('value', 'key')
            ->toArray();

        $this->settings = [
            'peertube_url' => $settings['peertube_url'] ?? '',
            'peertube_admin_username' => $settings['peertube_admin_username'] ?? '',
            'peertube_admin_password' => $settings['peertube_admin_password'] ?? '',
        ];

        $this->isConfigured = $this->peerTubeService->validateConfiguration();
    }

    public function update()
    {
        $validated = $this->validate([
            'settings.peertube_url' => 'required|url',
            'settings.peertube_admin_username' => 'required|string|max:255',
            'settings.peertube_admin_password' => 'required|string|min:6',
        ]);

        try {
            $this->updateSystemSettings([
                'peertube_url' => $this->settings['peertube_url'],
                'peertube_admin_username' => $this->settings['peertube_admin_username'],
                'peertube_admin_password' => $this->settings['peertube_admin_password'],
            ]);

            Cache::forget('system_settings');
            $this->isConfigured = $this->peerTubeService->validateConfiguration();

            session()->flash('success', __('admin.peertube.updated_success'));
        } catch (\Exception $e) {
            Log::error('Errore aggiornamento configurazioni PeerTube', [
                'error' => $e->getMessage(),
            ]);

            session()->flash('error', __('admin.peertube.update_error') . ': ' . $e->getMessage());
        }
    }

    public function testConnection()
    {
        try {
            $token = $this->peerTubeService->getAdminToken();

            if ($token) {
                $this->connectionTest = [
                    'success' => true,
                    'message' => __('admin.peertube.connection_success'),
                    'token' => substr($token, 0, 20) . '...'
                ];
            } else {
                $this->connectionTest = [
                    'success' => false,
                    'message' => __('admin.peertube.connection_failed')
                ];
            }
        } catch (\Exception $e) {
            $this->connectionTest = [
                'success' => false,
                'message' => __('admin.peertube.connection_error') . ': ' . $e->getMessage()
            ];
        }
    }

    private function updateSystemSettings(array $settings): void
    {
        foreach ($settings as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => 'peertube',
                    'type' => 'string',
                    'display_name' => ucfirst(str_replace('_', ' ', $key)),
                    'description' => 'Configurazione PeerTube: ' . ucfirst(str_replace('_', ' ', $key))
                ]
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.peertube-settings')
            ->layout('components.layouts.app');
    }
}

