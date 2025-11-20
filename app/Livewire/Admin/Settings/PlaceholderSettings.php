<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\PlaceholderSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlaceholderSettings extends Component
{
    public $poem_placeholder_color;
    public $article_placeholder_color;
    public $event_placeholder_color;

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }

        $settings = PlaceholderSetting::getSettings();
        $this->poem_placeholder_color = $settings->poem_placeholder_color ?? '#6c757d';
        $this->article_placeholder_color = $settings->article_placeholder_color ?? '#007bff';
        $this->event_placeholder_color = $settings->event_placeholder_color ?? '#17a2b8';
    }

    public function update()
    {
        $validator = Validator::make([
            'poem_placeholder_color' => $this->poem_placeholder_color,
            'article_placeholder_color' => $this->article_placeholder_color,
            'event_placeholder_color' => $this->event_placeholder_color,
        ], [
            'poem_placeholder_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'article_placeholder_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'event_placeholder_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'poem_placeholder_color.required' => __('admin.placeholder_settings.poem_color_required'),
            'poem_placeholder_color.regex' => __('admin.placeholder_settings.color_regex'),
            'article_placeholder_color.required' => __('admin.placeholder_settings.article_color_required'),
            'article_placeholder_color.regex' => __('admin.placeholder_settings.color_regex'),
            'event_placeholder_color.regex' => __('admin.placeholder_settings.color_regex'),
        ]);

        if ($validator->fails()) {
            $this->addError('validation', $validator->errors()->first());
            return;
        }

        try {
            PlaceholderSetting::updateSettings([
                'poem_placeholder_color' => $this->poem_placeholder_color,
                'article_placeholder_color' => $this->article_placeholder_color,
                'event_placeholder_color' => $this->event_placeholder_color,
            ]);

            session()->flash('success', __('admin.placeholder_settings.updated_success'));
        } catch (\Exception $e) {
            session()->flash('error', __('admin.placeholder_settings.update_error') . ': ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.placeholder-settings')
            ->layout('components.layouts.app');
    }
}

