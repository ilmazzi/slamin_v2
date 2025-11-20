<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SocialSettings extends Component
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
        $socialSettings = SystemSetting::where('group', 'social')->get();
        
        $this->settings = [
            'social_enable_likes' => $this->getSettingValue('social_enable_likes', true),
            'social_likeable_content' => $this->getSettingValue('social_likeable_content', ['video', 'photo', 'poem', 'article', 'event', 'comment']),
            'social_enable_comments' => $this->getSettingValue('social_enable_comments', true),
            'social_commentable_content' => $this->getSettingValue('social_commentable_content', ['video', 'photo', 'poem', 'article', 'event']),
            'social_auto_approve_comments' => $this->getSettingValue('social_auto_approve_comments', true),
            'social_enable_notifications' => $this->getSettingValue('social_enable_notifications', true),
            'social_notification_types' => $this->getSettingValue('social_notification_types', ['like', 'comment', 'snap']),
            'social_enable_views' => $this->getSettingValue('social_enable_views', true),
            'social_viewable_content' => $this->getSettingValue('social_viewable_content', ['video', 'photo', 'poem', 'article', 'event']),
        ];
    }

    private function getSettingValue($key, $default)
    {
        $setting = SystemSetting::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }

        if ($setting->type === 'json') {
            return json_decode($setting->value, true) ?? $default;
        } elseif ($setting->type === 'boolean') {
            return filter_var($setting->value, FILTER_VALIDATE_BOOLEAN);
        }

        return $setting->value ?? $default;
    }

    public function update()
    {
        try {
            $this->updateSetting('social_enable_likes', $this->settings['social_enable_likes'] ?? false, 'boolean');
            $this->updateSetting('social_likeable_content', $this->settings['social_likeable_content'] ?? [], 'json');
            $this->updateSetting('social_enable_comments', $this->settings['social_enable_comments'] ?? false, 'boolean');
            $this->updateSetting('social_commentable_content', $this->settings['social_commentable_content'] ?? [], 'json');
            $this->updateSetting('social_auto_approve_comments', $this->settings['social_auto_approve_comments'] ?? false, 'boolean');
            $this->updateSetting('social_enable_notifications', $this->settings['social_enable_notifications'] ?? false, 'boolean');
            $this->updateSetting('social_notification_types', $this->settings['social_notification_types'] ?? [], 'json');
            $this->updateSetting('social_enable_views', $this->settings['social_enable_views'] ?? false, 'boolean');
            $this->updateSetting('social_viewable_content', $this->settings['social_viewable_content'] ?? [], 'json');

            Log::info('Impostazioni social aggiornate', [
                'admin_id' => Auth::id(),
            ]);

            session()->flash('success', __('admin.social_settings.updated_success'));
        } catch (\Exception $e) {
            Log::error('Errore aggiornamento impostazioni social', [
                'error' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);

            session()->flash('error', __('admin.social_settings.update_error'));
        }
    }

    public function resetToDefaults()
    {
        $defaultSettings = [
            'social_enable_likes' => true,
            'social_likeable_content' => ['video', 'photo', 'poem', 'article', 'event', 'comment'],
            'social_enable_comments' => true,
            'social_commentable_content' => ['video', 'photo', 'poem', 'article', 'event'],
            'social_auto_approve_comments' => true,
            'social_enable_notifications' => true,
            'social_notification_types' => ['like', 'comment', 'snap'],
            'social_enable_views' => true,
            'social_viewable_content' => ['video', 'photo', 'poem', 'article', 'event'],
        ];

        foreach ($defaultSettings as $key => $value) {
            $type = is_array($value) ? 'json' : 'boolean';
            $this->updateSetting($key, $value, $type);
        }

        $this->loadSettings();

        session()->flash('success', __('admin.social_settings.reset_success'));
    }

    private function updateSetting(string $key, $value, string $type): void
    {
        SystemSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : (string) $value,
                'type' => $type,
                'group' => 'social',
            ]
        );
    }

    public function render()
    {
        return view('livewire.admin.settings.social-settings')
            ->layout('components.layouts.app');
    }
}

