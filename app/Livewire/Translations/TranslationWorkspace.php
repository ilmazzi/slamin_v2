<?php

namespace App\Livewire\Translations;

use App\Models\GigApplication;
use App\Models\PoemTranslation;
use App\Models\TranslationComment;
use App\Notifications\TranslationWorkspaceNotification;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class TranslationWorkspace extends Component
{
    public GigApplication $application;
    public $translation;
    public $translatedText = '';
    public $newComment = '';
    public $selectedText = '';
    public $selectionStart = 0;
    public $selectionEnd = 0;
    public $showCommentForm = false;
    public $showVersionHistory = false;
    
    public function mount(GigApplication $application)
    {
        $this->application = $application->load([
            'gig.poem.user',
            'user',
            'translations.versions.modifier',
            'translations.comments.user'
        ]);
        
        // Get or create translation
        $this->translation = $this->application->translations()
            ->orderBy('version', 'desc')
            ->first();
            
        if (!$this->translation) {
            // Create initial translation
            $this->translation = PoemTranslation::create([
                'gig_application_id' => $this->application->id,
                'gig_id' => $this->application->gig_id,
                'poem_id' => $this->application->gig->poem_id,
                'translator_id' => $this->application->user_id,
                'language' => $this->application->gig->target_language,
                'target_language' => $this->application->gig->target_language,
                'title' => $this->application->gig->poem->title,
                'content' => '',
                'translated_text' => '',
                'status' => 'draft',
                'version' => 1,
            ]);
            
            // Create first version
            $this->translation->createVersion($this->application->user_id, 'Initial version');
        }
        
        $this->translatedText = $this->translation->translated_text ?? $this->translation->content ?? '';
    }
    
    public function saveTranslation()
    {
        $this->validate([
            'translatedText' => 'required|string|min:10',
        ]);
        
        $hasChanges = $this->translatedText !== ($this->translation->translated_text ?? $this->translation->content);
        
        if ($hasChanges) {
            // Increment version and create history
            $this->translation->update([
                'translated_text' => $this->translatedText,
                'content' => $this->translatedText,
            ]);
            
            $this->translation->incrementVersion(Auth::id(), 'Text updated');
            
            // Notify the OTHER party (not current user)
            $isAuthor = Auth::id() === $this->application->gig->poem->user_id;
            $otherUser = $isAuthor ? $this->application->user : $this->application->gig->poem->user;
            
            if ($otherUser && $otherUser->id !== Auth::id()) {
                $otherUser->notify(new TranslationWorkspaceNotification($this->translation, 'translation_updated'));
                $this->dispatch('refresh-notifications');
                $this->js('window.dispatchEvent(new CustomEvent("notification-received"))');
            }
            
            session()->flash('success', 'Traduzione salvata! Versione ' . $this->translation->version);
        } else {
            session()->flash('info', 'Nessuna modifica rilevata');
        }
        
        $this->translation->refresh();
    }
    
    #[On('text-selected')]
    public function handleTextSelection($start, $end, $text)
    {
        $this->selectionStart = $start;
        $this->selectionEnd = $end;
        $this->selectedText = $text;
        $this->showCommentForm = true;
    }
    
    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|min:3|max:1000',
        ]);
        
        TranslationComment::create([
            'poem_translation_id' => $this->translation->id,
            'user_id' => Auth::id(),
            'selection_start' => $this->selectionStart,
            'selection_end' => $this->selectionEnd,
            'highlighted_text' => $this->selectedText,
            'comment' => $this->newComment,
        ]);
        
        // Notify the OTHER party (not current user)
        $isAuthor = Auth::id() === $this->application->gig->poem->user_id;
        $otherUser = $isAuthor ? $this->application->user : $this->application->gig->poem->user;
        
        if ($otherUser && $otherUser->id !== Auth::id()) {
            $otherUser->notify(new TranslationWorkspaceNotification($this->translation, 'comment_added'));
            $this->dispatch('refresh-notifications');
            $this->js('window.dispatchEvent(new CustomEvent("notification-received"))');
        }
        
        $this->reset(['newComment', 'selectedText', 'selectionStart', 'selectionEnd', 'showCommentForm']);
        $this->translation->load('comments.user');
        
        session()->flash('success', 'Commento aggiunto!');
    }
    
    public function resolveComment($commentId)
    {
        $comment = TranslationComment::findOrFail($commentId);
        
        if ($comment->poem_translation_id === $this->translation->id) {
            $comment->resolve(Auth::id());
            $this->translation->load('comments.user');
            
            // Notify the COMMENT AUTHOR (not current user)
            if ($comment->user_id !== Auth::id()) {
                $comment->user->notify(new TranslationWorkspaceNotification($this->translation, 'comment_resolved'));
                $this->dispatch('refresh-notifications');
                $this->js('window.dispatchEvent(new CustomEvent("notification-received"))');
            }
            
            session()->flash('success', 'Commento risolto!');
        }
    }
    
    public function submitForReview()
    {
        $this->translation->update([
            'status' => 'in_review',
            'submitted_at' => now(),
        ]);
        
        // Notify poem AUTHOR (not translator)
        $author = $this->application->gig->poem->user;
        if ($author && $author->id !== Auth::id()) {
            $author->notify(new TranslationWorkspaceNotification($this->translation, 'submitted_for_review'));
            $this->dispatch('refresh-notifications');
            $this->js('window.dispatchEvent(new CustomEvent("notification-received"))');
        }
        
        session()->flash('success', 'Traduzione inviata per revisione!');
        $this->translation->refresh();
    }
    
    public function approveTranslation()
    {
        // Only poem author can approve
        if (Auth::id() !== $this->application->gig->poem->user_id) {
            session()->flash('error', 'Solo l\'autore può approvare la traduzione');
            return;
        }
        
        $this->translation->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
        
        // Update application status
        $this->application->update(['status' => 'completed']);
        
        // Notify TRANSLATOR (not author)
        $translator = $this->application->user;
        if ($translator && $translator->id !== Auth::id()) {
            $translator->notify(new TranslationWorkspaceNotification($this->translation, 'translation_approved'));
            $this->dispatch('refresh-notifications');
            $this->js('window.dispatchEvent(new CustomEvent("notification-received"))');
        }
        
        session()->flash('success', 'Traduzione approvata! Ora puoi procedere al pagamento.');
        $this->translation->refresh();
    }
    
    
    public function render()
    {
        $isAuthor = Auth::id() === $this->application->gig->poem->user_id;
        $isTranslator = Auth::id() === $this->application->user_id;
        
        return view('livewire.translations.translation-workspace', [
            'isAuthor' => $isAuthor,
            'isTranslator' => $isTranslator,
            'versions' => $this->translation->versions()->with('modifier')->orderBy('version_number', 'desc')->get(),
            'comments' => $this->translation->comments()->with('user')->orderBy('created_at', 'desc')->get(),
        ]);
    }
}
