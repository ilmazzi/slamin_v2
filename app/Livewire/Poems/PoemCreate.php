<?php

namespace App\Livewire\Poems;

use App\Models\Poem;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PoemCreate extends Component
{
    use WithFileUploads;
    
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
    public ?int $draftId = null;
    
    // Preview
    public bool $showPreview = false;
    
    public function mount()
    {
        // Carica eventuali bozze esistenti
        $latestDraft = Auth::user()->poems()
            ->where('is_draft', true)
            ->latest('draft_saved_at')
            ->first();
        
        if ($latestDraft && request()->query('restore')) {
            $this->draftId = $latestDraft->id;
            $this->title = $latestDraft->title ?? '';
            $this->content = $latestDraft->content;
            $this->description = $latestDraft->description ?? '';
            $this->category = $latestDraft->category ?? '';
            $this->poemType = $latestDraft->poem_type ?? '';
            $this->language = $latestDraft->language;
            $this->tags = $latestDraft->tags ? implode(', ', $latestDraft->tags) : '';
        }
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
        // Imposta isDraft basato sul parametro
        $this->isDraft = $isDraft;
        
        \Log::info('🚀 PoemCreate::save() called', [
            'content_length' => strlen($this->content),
            'content_preview' => substr($this->content, 0, 100),
            'title' => $this->title,
            'isDraft' => $this->isDraft,
            'silent' => $silent
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
            // Mostra errori di validazione
            $errors = $e->validator->errors()->all();
            \Log::error('❌ Validation failed', ['errors' => $errors]);
            session()->flash('error', 'Errore di validazione: ' . implode(' ', $errors));
            return;
        } catch (\Exception $e) {
            \Log::error('❌ Exception during validation', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
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
            'original_language' => $this->language,
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
            $data['published_at'] = now();
            $data['moderation_status'] = 'approved'; // Auto-approve per ora
        }
        
        // Update existing draft or create new
        if ($this->draftId) {
            $poem = Poem::find($this->draftId);
            $poem->update($data);
        } else {
            $poem = Auth::user()->poems()->create($data);
            $this->draftId = $poem->id;
        }
        
        // Upload thumbnail
        if ($this->thumbnail) {
            $path = $this->thumbnail->store('poems/thumbnails', 'public');
            $poem->update(['thumbnail_path' => $path]);
            $this->thumbnail = null;
        }
        
        $this->lastSaved = now()->format('H:i');
        
        \Log::info('💾 Poem saved successfully', [
            'poem_id' => $poem->id,
            'isDraft' => $this->isDraft,
            'silent' => $silent
        ]);
        
        if (!$silent) {
            if ($this->isDraft) {
                \Log::info('📋 Showing draft success message');
                session()->flash('success', 'Bozza salvata con successo! ID: ' . $poem->id);
                $this->dispatch('poem-saved', ['id' => $poem->id]);
            } else {
                \Log::info('🎉 Redirecting to poem show page', ['slug' => $poem->slug]);
                session()->flash('success', 'Poesia pubblicata con successo!');
                return $this->redirect(route('poems.show', $poem->slug), navigate: true);
            }
        }
        
        \Log::info('✅ Save method completed');
        return $poem;
    }
    
    public function togglePreview()
    {
        $this->showPreview = !$this->showPreview;
    }
    
    public function render()
    {
        return view('livewire.poems.poem-create', [
            'categories' => config('poems.categories', []),
            'poemTypes' => config('poems.poem_types', []),
            'languages' => config('poems.languages', []),
        ]);
    }
}
