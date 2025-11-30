<?php

namespace App\Livewire;

use Livewire\Component;

class CookieBanner extends Component
{
    public $showBanner = false;
    public $showPreferences = false;
    
    public $necessary = true; // Always true, can't be disabled
    public $analytics = false;
    public $marketing = false;
    
    public function mount()
    {
        // Check if user has already made a choice
        // This will be checked via JavaScript to avoid server-side cookie reading
    }
    
    public function acceptAll()
    {
        $this->necessary = true;
        $this->analytics = true;
        $this->marketing = true;
        
        $this->savePreferences();
        $this->showBanner = false;
    }
    
    public function acceptNecessary()
    {
        $this->necessary = true;
        $this->analytics = false;
        $this->marketing = false;
        
        $this->savePreferences();
        $this->showBanner = false;
    }
    
    public function saveCustomPreferences()
    {
        $this->savePreferences();
        $this->showBanner = false;
        $this->showPreferences = false;
    }
    
    public function togglePreferences()
    {
        $this->showPreferences = !$this->showPreferences;
    }
    
    private function savePreferences()
    {
        // Emit event to JavaScript to save preferences in localStorage
        $this->dispatch('cookie-preferences-saved', [
            'necessary' => $this->necessary,
            'analytics' => $this->analytics,
            'marketing' => $this->marketing,
        ]);
    }
    
    public function render()
    {
        return view('livewire.cookie-banner');
    }
}
