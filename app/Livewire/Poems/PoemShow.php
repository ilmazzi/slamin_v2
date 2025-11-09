<?php

namespace App\Livewire\Poems;

use App\Models\Poem;
use App\Models\PoemTranslation;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PoemShow extends Component
{
    public Poem $poem;
    public string $currentLanguage;
    public ?PoemTranslation $currentTranslation = null;
    public bool $isLiked = false;
    public int $likeCount = 0;
    
    public function mount($slug)
    {
        $this->poem = Poem::where('slug', $slug)
            ->with(['user', 'poemTranslations'])
            ->firstOrFail();
        
        // Increment views
        $this->poem->incrementViewIfNotOwner(Auth::user());
        
        // Set current language to original
        $this->currentLanguage = $this->poem->language;
        
        // Check like status for display
        if (Auth::check()) {
            $this->isLiked = $this->poem->likes()
                ->where('user_id', Auth::id())
                ->exists();
        }
        
        $this->likeCount = $this->poem->like_count ?? 0;
    }
    
    public function switchLanguage($language)
    {
        $this->currentLanguage = $language;
        
        if ($language === $this->poem->language) {
            // Original language
            $this->currentTranslation = null;
        } else {
            // Load translation
            $this->currentTranslation = $this->poem->poemTranslations()
                ->where('language', $language)
                ->where('status', 'approved')
                ->first();
        }
    }
    
    public function render()
    {
        // Load related poems
        $relatedPoems = Poem::published()
            ->where('id', '!=', $this->poem->id)
            ->where(function($query) {
                $query->where('category', $this->poem->category)
                      ->orWhere('language', $this->poem->language)
                      ->orWhere('user_id', $this->poem->user_id);
            })
            ->with(['user'])
            ->limit(3)
            ->get();
        
        return view('livewire.poems.poem-show', [
            'relatedPoems' => $relatedPoems,
        ]);
    }
}
