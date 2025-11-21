<?php

namespace App\Livewire\Poems;

use App\Models\Poem;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class PoemEdit extends Component
{
    use WithFileUploads;
    
    public Poem $poem;
    
    // Form fields
    public string $title = '';
    public string $content = '';
    public string $description = '';
    public string $category = '';
    public string $poemType = '';
    public string $language = 'it';
    public string $tags = '';
    public $thumbnail;
    public bool $isDraft = false;
    
    // Auto-save
    public ?string $lastSaved = null;
    
    // Preview
    public bool $showPreview = false;
    
    public function mount($slug)
    {
        // Check authentication
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Devi essere autenticato per modificare poesie');
        }
        
        // Check permissions
        if (!$user->canCreatePoem()) {
            abort(403, 'Non hai i permessi per modificare poesie');
        }
        
        // Trova poesia per slug
        $this->poem = Poem::where('slug', $slug)->firstOrFail();
        
        // Verifica autorizzazione (proprietario o admin)
        if (!$this->poem->canBeEditedBy($user)) {
            abort(403, 'Non sei autorizzato a modificare questa poesia');
        }
        
        $this->title = $this->poem->title ?? '';
        $this->content = $this->poem->content;
        $this->description = $this->poem->description ?? '';
        $this->category = $this->poem->category ?? '';
        $this->poemType = $this->poem->poem_type ?? '';
        $this->language = $this->poem->language;
        $this->tags = $this->poem->tags ? implode(', ', $this->poem->tags) : '';
        $this->isDraft = $this->poem->is_draft;
    }
    
    public function saveDraft()
    {
        $this->save(isDraft: true);
    }
    
    public function autoSave()
    {
        if (empty($this->content)) {
            return;
        }
        
        $this->save(silent: true, isDraft: true);
        $this->lastSaved = now()->format('H:i');
    }
    
    public function save($silent = false, $isDraft = false)
    {
        $this->isDraft = $isDraft;
        
        \Log::info('🚀 PoemEdit::save() called', [
            'poem_id' => $this->poem->id,
            'content_length' => strlen($this->content),
            'title' => $this->title,
            'isDraft' => $this->isDraft,
        ]);
        
        try {
            $this->validate([
                'content' => 'required|min:10|max:10000',
                'title' => 'nullable|max:255',
                'description' => 'nullable|max:500',
                'category' => 'nullable|in:' . implode(',', array_keys(config('poems.categories', []))),
                'poemType' => 'nullable|in:' . implode(',', array_keys(config('poems.poem_types', []))),
                'language' => 'required|string|max:10',
                'tags' => 'nullable|string|max:255',
                'thumbnail' => 'nullable|image|max:2048',
            ]);
            
            \Log::info('✅ Validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            \Log::error('❌ Validation failed', ['errors' => $errors]);
            session()->flash('error', 'Errore di validazione: ' . implode(' ', $errors));
            return;
        } catch (\Exception $e) {
            \Log::error('❌ Exception during validation', [
                'message' => $e->getMessage(),
            ]);
            session()->flash('error', 'Errore: ' . $e->getMessage());
            return;
        }
        
        $data = [
            'title' => $this->title ?: null,
            'content' => $this->content,
            'description' => $this->description ?: null,
            'category' => $this->category ?: 'other',
            'poem_type' => $this->poemType ?: 'free_verse',
            'language' => $this->language,
            'is_draft' => $this->isDraft,
            'is_public' => !$this->isDraft,
        ];
        
        // Tags processing
        if ($this->tags) {
            $tagsArray = array_map('trim', explode(',', $this->tags));
            $data['tags'] = array_filter($tagsArray);
        }
        
        // Draft or publish
        if ($this->isDraft) {
            $data['draft_saved_at'] = now();
        } else {
            $data['published_at'] = $data['published_at'] ?? now();
            $data['moderation_status'] = 'approved';
        }
        
        // Update poem
        $this->poem->update($data);
        
        // Upload thumbnail
        if ($this->thumbnail) {
            $path = $this->thumbnail->store('poems/thumbnails', 'public');
            $this->poem->update(['thumbnail_path' => $path]);
            $this->thumbnail = null;
        }
        
        $this->lastSaved = now()->format('H:i');
        
        \Log::info('💾 Poem updated successfully', [
            'poem_id' => $this->poem->id,
            'isDraft' => $this->isDraft,
        ]);
        
        if (!$silent) {
            if ($this->isDraft) {
                session()->flash('success', 'Bozza aggiornata con successo!');
            } else {
                session()->flash('success', 'Poesia aggiornata con successo!');
                return $this->redirect(route('poems.show', $this->poem->slug), navigate: true);
            }
        }
        
        \Log::info('✅ Update completed');
    }
    
    public function togglePreview()
    {
        $this->showPreview = !$this->showPreview;
    }
    
    public function render()
    {
        return view('livewire.poems.poem-edit', [
            'categories' => config('poems.categories', []),
            'poemTypes' => config('poems.poem_types', []),
            'languages' => config('poems.languages', []),
        ]);
    }
}
