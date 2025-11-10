<?php

namespace App\Livewire\Translations;

use App\Models\Poem;
use App\Models\Gig;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TranslationRequest extends Component
{
    public Poem $poem;
    public bool $showModal = false;
    
    // Form fields
    public string $targetLanguage = '';
    public string $requirements = '';
    public string $proposedCompensation = '';
    public string $deadline = '';
    
    public function mount(Poem $poem)
    {
        $this->poem = $poem;
    }
    
    public function openModal()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }
        
        // Solo l'autore può richiedere traduzioni
        if ($this->poem->user_id !== Auth::id()) {
            session()->flash('error', __('translations.only_author_can_request'));
            return;
        }
        
        $this->showModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['targetLanguage', 'requirements', 'proposedCompensation', 'deadline']);
    }
    
    public function submit()
    {
        $this->validate([
            'targetLanguage' => 'required|string|max:10',
            'requirements' => 'nullable|string|max:1000',
            'proposedCompensation' => 'required|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
        ]);
        
        // Verifica che non esista già un gig aperto per questa lingua
        $existingGig = $this->poem->gigs()
            ->where('target_language', $this->targetLanguage)
            ->whereIn('status', ['open', 'in_progress'])
            ->first();
        
        if ($existingGig) {
            session()->flash('error', __('translations.gig_already_exists'));
            return;
        }
        
        // Prepara dati per il gig
        $languageName = config("poems.languages.{$this->targetLanguage}") ?? $this->targetLanguage;
        $poemTitle = $this->poem->title ?: __('poems.untitled');
        
        // Crea il gig
        $gig = Gig::create([
            'poem_id' => $this->poem->id,
            'requester_id' => Auth::id(),
            'title' => "Traduzione: {$poemTitle} → {$languageName}",
            'description' => "Richiesta di traduzione della poesia \"{$poemTitle}\" in {$languageName}",
            'target_language' => $this->targetLanguage,
            'requirements' => $this->requirements ?: null,
            'proposed_compensation' => $this->proposedCompensation,
            'deadline' => $this->deadline ?: null,
            'status' => 'open',
            'category' => 'translation',
            'type' => 'translation',
            'language' => $this->poem->language ?? 'it',
            'is_remote' => true,
        ]);
        
        session()->flash('success', __('translations.request_created'));
        $this->closeModal();
        
        // Redirect alla pagina gig
        return $this->redirect(route('translations.gig.show', $gig), navigate: true);
    }
    
    public function render()
    {
        $availableLanguages = config('poems.languages', []);
        
        // Rimuovi le lingue per cui esistono già traduzioni o gig attivi
        $existingLanguages = $this->poem->poemTranslations()->pluck('language')->toArray();
        $activeGigLanguages = $this->poem->gigs()
            ->whereIn('status', ['open', 'in_progress'])
            ->pluck('target_language')
            ->toArray();
        
        $unavailableLanguages = array_merge($existingLanguages, $activeGigLanguages, [$this->poem->language]);
        
        foreach ($unavailableLanguages as $lang) {
            unset($availableLanguages[$lang]);
        }
        
        return view('livewire.translations.translation-request', [
            'availableLanguages' => $availableLanguages,
        ]);
    }
}
