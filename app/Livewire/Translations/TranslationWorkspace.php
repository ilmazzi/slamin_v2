<?php

namespace App\Livewire\Translations;

use App\Models\GigApplication;
use App\Models\PoemTranslation;
use App\Models\TranslationComment;
use App\Notifications\TranslationWorkspaceNotification;
use App\Livewire\Components\NotificationCenter;
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
                \Log::info('🔔 Sending translation_updated notification', [
                    'from' => Auth::id(),
                    'to' => $otherUser->id,
                    'translation_id' => $this->translation->id,
                ]);
                
                $otherUser->notify(new TranslationWorkspaceNotification($this->translation, 'translation_updated'));
                // Don't dispatch here - it would trigger on sender's browser
                // Recipient will see notification via polling
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
            \Log::info('🔔 Sending comment_added notification', [
                'from' => Auth::id(),
                'to' => $otherUser->id,
                'other_user_email' => $otherUser->email,
            ]);
            
            try {
                $otherUser->notify(new TranslationWorkspaceNotification($this->translation, 'comment_added'));
                \Log::info('✅ Notification sent successfully');
            } catch (\Exception $e) {
                \Log::error('❌ Notification failed', ['error' => $e->getMessage()]);
            }
            // Don't dispatch - recipient will see via polling
        } else {
            \Log::warning('⚠️ Notification NOT sent', [
                'otherUser_exists' => $otherUser ? 'yes' : 'no',
                'otherUser_id' => $otherUser ? $otherUser->id : 'null',
                'current_user_id' => Auth::id(),
                'same_user' => $otherUser ? ($otherUser->id === Auth::id()) : 'unknown',
            ]);
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
                \Log::info('🔔 Sending comment_resolved notification', [
                    'from' => Auth::id(),
                    'to' => $comment->user_id,
                ]);
                
                $comment->user->notify(new TranslationWorkspaceNotification($this->translation, 'comment_resolved'));
                // Don't dispatch - recipient will see via polling
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
        
        // Reload relationships to ensure fresh data
        $this->application->load('gig.poem.user');
        
        // Notify poem AUTHOR (not translator)
        $author = $this->application->gig->poem->user;
        
        \Log::info('🔔 submitForReview - DEBUG', [
            'current_user' => Auth::id(),
            'current_user_email' => Auth::user()->email,
            'author_id' => $author ? $author->id : 'null',
            'author_email' => $author ? $author->email : 'null',
            'are_same' => $author ? ($author->id === Auth::id() ? 'YES - PROBLEM!' : 'NO - OK') : 'author null',
        ]);
        
        if ($author && $author->id !== Auth::id()) {
            \Log::info('✅ Sending submitted_for_review notification', [
                'from' => Auth::id(),
                'from_email' => Auth::user()->email,
                'to' => $author->id,
                'to_email' => $author->email,
            ]);
            
            $author->notify(new TranslationWorkspaceNotification($this->translation, 'submitted_for_review'));
            // Don't dispatch - recipient will see via polling
        } else {
            \Log::error('❌ Notification NOT sent!', [
                'reason' => $author ? 'Same user' : 'Author is null',
                'author_id' => $author ? $author->id : 'null',
                'current_user_id' => Auth::id(),
            ]);
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
            \Log::info('🔔 Sending translation_approved notification', [
                'from' => Auth::id(),
                'to' => $translator->id,
            ]);
            
            $translator->notify(new TranslationWorkspaceNotification($this->translation, 'translation_approved'));
            // Don't dispatch - recipient will see via polling
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
