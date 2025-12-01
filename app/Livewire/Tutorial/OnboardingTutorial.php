<?php

namespace App\Livewire\Tutorial;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OnboardingTutorial extends Component
{
    public $show = false;
    public $currentStep = 0;
    public $forceShow = false; // Per il pulsante footer

    protected $listeners = ['openTutorial' => 'open'];

    public function mount()
    {
        // Mostra automaticamente se è il primo login e non ha completato il tutorial
        if (Auth::check() && !$this->forceShow) {
            $user = Auth::user();
            if (!$user->tutorial_completed_at) {
                $this->show = true;
            }
        }
    }

    public function open()
    {
        $this->forceShow = true;
        $this->show = true;
        $this->currentStep = 0;
    }

    public function close()
    {
        $this->show = false;
        $this->currentStep = 0;
        
        // Se non era forzato, segna come completato
        if (!$this->forceShow && Auth::check()) {
            $user = Auth::user();
            if (!$user->tutorial_completed_at) {
                $user->update(['tutorial_completed_at' => now()]);
            }
        }
        
        $this->forceShow = false;
    }

    public function next()
    {
        if ($this->currentStep < $this->getTotalSteps() - 1) {
            $this->currentStep++;
        }
    }

    public function previous()
    {
        if ($this->currentStep > 0) {
            $this->currentStep--;
        }
    }

    public function skip()
    {
        $this->close();
    }

    public function getTotalSteps()
    {
        return 6; // Benvenuto + 5 step
    }

    public function getStepsProperty()
    {
        return [
            [
                'title' => __('tutorial.welcome.title'),
                'content' => __('tutorial.welcome.content'),
                'showButtons' => true,
                'focusElement' => null,
            ],
            [
                'title' => __('tutorial.dashboard.title'),
                'content' => __('tutorial.dashboard.content'),
                'showButtons' => true,
                'focusElement' => 'dashboard-link',
            ],
            [
                'title' => __('tutorial.profile.title'),
                'content' => __('tutorial.profile.content'),
                'showButtons' => true,
                'focusElement' => 'profile-sidebar',
            ],
            [
                'title' => __('tutorial.home.title'),
                'content' => __('tutorial.home.content'),
                'showButtons' => true,
                'focusElement' => 'logo-link',
            ],
            [
                'title' => __('tutorial.sidebar.title'),
                'content' => __('tutorial.sidebar.content'),
                'showButtons' => true,
                'focusElement' => 'sidebar-nav',
            ],
            [
                'title' => __('tutorial.gigs.title'),
                'content' => __('tutorial.gigs.content'),
                'showButtons' => true,
                'focusElement' => 'gigs-link',
            ],
        ];
    }

    public function getCurrentStepData()
    {
        $steps = $this->steps;
        return $steps[$this->currentStep] ?? $steps[0];
    }

    public function render()
    {
        return view('livewire.tutorial.onboarding-tutorial');
    }
}
