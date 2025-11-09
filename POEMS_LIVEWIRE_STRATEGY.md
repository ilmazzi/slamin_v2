# 🎯 STRATEGIA IMPLEMENTAZIONE POESIE - 100% LIVEWIRE

> **Migrazione sistema poesie con approccio Livewire-first**  
> Data: 8 Novembre 2025  
> Vincoli: SOLO Livewire + Tailwind + Alpine.js (minimo)

---

## ⚡ PRINCIPI ARCHITETTURALI

### ✅ SI (Allowed):
- ✅ **Livewire components** per TUTTO
- ✅ **Tailwind CSS** utility classes
- ✅ **Alpine.js** solo per micro-interazioni UI (già incluso con Livewire)
- ✅ **Componenti Blade** riutilizzabili
- ✅ **Traits** PHP per logica condivisa

### ❌ NO (Forbidden):
- ❌ **Controller tradizionali** (tranne API se strettamente necessario)
- ❌ **JavaScript custom** personalizzato
- ❌ **CSS custom** file separati
- ❌ **AJAX** manuale (fetch, axios, etc.)
- ❌ **jQuery** o librerie JS esterne

---

## 🏗️ ARCHITETTURA LIVEWIRE

### Struttura Componenti:

```
app/Livewire/Poems/
├── PoemIndex.php              # Lista poesie con filtri
├── PoemShow.php               # Dettaglio poesia (con modal opzionale)
├── PoemCreate.php             # Form creazione
├── PoemEdit.php               # Form modifica
├── PoemCard.php               # Card singola poesia
├── PoemModal.php              # Modal dettaglio full
├── PoemSearch.php             # Barra ricerca avanzata
├── PoemFilters.php            # Sidebar filtri
├── PoemLanguageSelector.php   # Selettore traduzioni
├── PoemSocialActions.php      # Like/Comment/Share/Bookmark
├── PoemStats.php              # Statistiche poesia
├── PoemAuthorBox.php          # Box autore
├── PoemRelated.php            # Poesie correlate
├── MyPoems.php                # Le mie poesie
├── MyDrafts.php               # Bozze
├── MyBookmarks.php            # Salvati
├── MyLiked.php                # Piaciute
└── Translations/
    ├── TranslationCreate.php
    ├── TranslationEdit.php
    ├── TranslationShow.php
    └── TranslationList.php
```

---

## 🎨 STYLING - SOLO TAILWIND

### Font Poesia (Tailwind Config):

```javascript
// tailwind.config.js o vite.config.js
theme: {
  extend: {
    fontFamily: {
      'poem': ['Crimson Pro', 'Georgia', 'serif'],
    }
  }
}
```

### Classi Tailwind per Contenuto Poesia:

```html
<div class="
  font-poem              // Font serif personalizzato
  text-lg                // Testo grande
  leading-relaxed        // Line-height 1.625
  whitespace-pre-wrap    // Preserva spazi e newlines
  text-neutral-900       // Colore testo
  dark:text-neutral-100  // Dark mode
  prose prose-lg         // Prose plugin Tailwind (opzionale)
  max-w-none             // No max-width
">
  {!! $poem->content !!}
</div>
```

### Utility Classes per Formattazione:

```html
<!-- Allineamenti -->
text-left
text-center
text-right
text-justify

<!-- Citazioni -->
<blockquote class="border-l-4 border-primary-500 pl-6 italic text-neutral-600">
  Citazione
</blockquote>

<!-- Liste -->
<ul class="list-disc list-inside space-y-2">
<ol class="list-decimal list-inside space-y-2">
```

---

## 🔧 COMPONENTI LIVEWIRE DETTAGLIATI

### 1️⃣ PoemIndex.php

**Responsabilità:**
- Lista tutte le poesie pubblicate
- Filtri real-time (categoria, lingua, tipo, search)
- Ordinamento (recenti, popolari, alfabetico)
- Paginazione

**Properties:**
```php
public string $search = '';
public string $category = '';
public string $language = '';
public string $poemType = '';
public string $sortBy = 'recent';
public int $perPage = 12;
```

**Methods:**
```php
public function updatedSearch()      // Auto-filtra su keyup
public function applyFilters()       // Applica filtri
public function resetFilters()       // Reset
public function loadMore()           // Infinite scroll
```

**View:**
```blade
<div>
    <!-- Barra ricerca -->
    <input wire:model.live.debounce.500ms="search" 
           type="text" 
           placeholder="Cerca poesie...">
    
    <!-- Filtri -->
    <select wire:model.live="category">
        <option value="">Tutte le categorie</option>
        @foreach(config('poems.categories') as $key => $name)
            <option value="{{ $key }}">{{ $name }}</option>
        @endforeach
    </select>
    
    <!-- Grid poesie -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($poems as $poem)
            <livewire:poems.poem-card :poem="$poem" :key="$poem->id" />
        @endforeach
    </div>
    
    <!-- Paginazione -->
    {{ $poems->links() }}
</div>
```

---

### 2️⃣ PoemShow.php

**Responsabilità:**
- Mostra dettaglio poesia
- Cambio lingua traduzioni
- Incrementa views
- Gestisce like/comment/bookmark inline

**Properties:**
```php
public Poem $poem;
public string $currentLanguage;
public ?PoemTranslation $currentTranslation = null;
public bool $isLiked = false;
public bool $isBookmarked = false;
```

**Methods:**
```php
public function mount($slug)
public function switchLanguage($language)
public function toggleLike()
public function toggleBookmark()
public function share()
```

**View:**
```blade
<div>
    <!-- Header -->
    <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">
        {{ $poem->title ?: __('poems.untitled') }}
    </h1>
    
    <!-- Language Selector -->
    @if($poem->available_languages->count() > 1)
        <div class="flex gap-2 mb-6">
            @foreach($poem->available_languages as $lang)
                <button wire:click="switchLanguage('{{ $lang['code'] }}')"
                        class="px-4 py-2 rounded-lg transition
                               {{ $currentLanguage === $lang['code'] 
                                  ? 'bg-primary-500 text-white' 
                                  : 'bg-neutral-100 text-neutral-700' }}">
                    {{ $lang['name'] }}
                </button>
            @endforeach
        </div>
    @endif
    
    <!-- Content -->
    <div class="font-poem text-lg leading-relaxed whitespace-pre-wrap 
                text-neutral-900 dark:text-white">
        {!! $currentTranslation?->content ?? $poem->content !!}
    </div>
    
    <!-- Social Actions -->
    <div class="flex gap-4 mt-8">
        <button wire:click="toggleLike" 
                class="flex items-center gap-2 px-4 py-2 rounded-lg
                       {{ $isLiked ? 'bg-red-500 text-white' : 'bg-neutral-100' }}">
            <svg class="w-5 h-5">...</svg>
            <span>{{ $poem->like_count }}</span>
        </button>
        
        <button wire:click="toggleBookmark"
                class="flex items-center gap-2 px-4 py-2 rounded-lg
                       {{ $isBookmarked ? 'bg-yellow-500 text-white' : 'bg-neutral-100' }}">
            <svg class="w-5 h-5">...</svg>
        </button>
        
        <button wire:click="share"
                class="flex items-center gap-2 px-4 py-2 rounded-lg bg-neutral-100">
            <svg class="w-5 h-5">...</svg>
        </button>
    </div>
    
    <!-- Comments Section -->
    <div class="mt-12">
        <livewire:comments.comment-section 
            :commentableType="Poem::class"
            :commentableId="$poem->id" />
    </div>
</div>
```

---

### 3️⃣ PoemCreate.php

**Responsabilità:**
- Form creazione poesia
- Upload thumbnail
- Auto-save bozze (Livewire polling)
- Validazione real-time

**Properties:**
```php
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
public bool $autoSaveEnabled = true;
public ?string $lastSavedAt = null;
```

**Methods:**
```php
public function mount()
public function save()
public function saveDraft()
public function autoSave()          // Chiamato da wire:poll
public function updatedThumbnail()  // Validazione file
```

**View con Auto-save:**
```blade
<div wire:poll.30s="autoSave">  <!-- Auto-save ogni 30 secondi -->
    
    <form wire:submit="save">
        <!-- Title -->
        <input wire:model.blur="title" 
               type="text"
               placeholder="Titolo (opzionale)"
               class="w-full px-4 py-3 rounded-lg border border-neutral-200
                      focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
        @error('title') 
            <span class="text-red-500 text-sm">{{ $message }}</span> 
        @enderror
        
        <!-- Content Editor -->
        <textarea wire:model.lazy="content"
                  rows="20"
                  placeholder="Scrivi qui la tua poesia..."
                  class="w-full px-4 py-3 rounded-lg border border-neutral-200
                         focus:border-primary-500 focus:ring-2 focus:ring-primary-200
                         font-poem text-lg leading-relaxed whitespace-pre-wrap">
        </textarea>
        @error('content') 
            <span class="text-red-500 text-sm">{{ $message }}</span> 
        @enderror
        
        <!-- Category -->
        <select wire:model="category"
                class="w-full px-4 py-3 rounded-lg border border-neutral-200">
            <option value="">Seleziona categoria</option>
            @foreach(config('poems.categories') as $key => $name)
                <option value="{{ $key }}">{{ $name }}</option>
            @endforeach
        </select>
        
        <!-- Language -->
        <select wire:model="language"
                class="w-full px-4 py-3 rounded-lg border border-neutral-200">
            @foreach(config('poems.languages') as $code => $name)
                <option value="{{ $code }}">{{ $name }}</option>
            @endforeach
        </select>
        
        <!-- Thumbnail Upload -->
        <input wire:model="thumbnail" 
               type="file" 
               accept="image/*"
               class="block w-full text-sm text-neutral-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-lg file:border-0
                      file:bg-primary-50 file:text-primary-700
                      hover:file:bg-primary-100">
        
        @if ($thumbnail)
            <div class="mt-2">
                <img src="{{ $thumbnail->temporaryUrl() }}" 
                     class="w-32 h-32 object-cover rounded-lg">
            </div>
        @endif
        
        <!-- Tags -->
        <input wire:model="tags" 
               type="text"
               placeholder="tag1, tag2, tag3"
               class="w-full px-4 py-3 rounded-lg border border-neutral-200">
        
        <!-- Auto-save indicator -->
        @if($lastSavedAt)
            <div class="flex items-center gap-2 text-sm text-neutral-500">
                <svg class="w-4 h-4 text-green-500">...</svg>
                Salvato {{ $lastSavedAt }}
            </div>
        @endif
        
        <!-- Actions -->
        <div class="flex gap-4">
            <button type="button" 
                    wire:click="saveDraft"
                    class="px-6 py-3 rounded-lg bg-neutral-100 text-neutral-700
                           hover:bg-neutral-200 transition">
                Salva Bozza
            </button>
            
            <button type="submit"
                    class="px-6 py-3 rounded-lg bg-primary-500 text-white
                           hover:bg-primary-600 transition">
                Pubblica
            </button>
        </div>
    </form>
    
    <!-- Loading indicator -->
    <div wire:loading class="fixed bottom-4 right-4 px-4 py-2 rounded-lg
                             bg-primary-500 text-white shadow-lg">
        Salvando...
    </div>
</div>
```

---

### 4️⃣ PoemCard.php (Component Riutilizzabile)

**Properties:**
```php
public Poem $poem;
public bool $showActions = true;
```

**View:**
```blade
<article class="group cursor-pointer" 
         wire:click="$dispatch('open-poem-modal', { poemId: {{ $poem->id }} })">
    
    <!-- Thumbnail -->
    <div class="aspect-[4/3] rounded-xl overflow-hidden mb-4 relative">
        @if($poem->thumbnail_url)
            <img src="{{ $poem->thumbnail_url }}" 
                 alt="{{ $poem->title }}"
                 class="w-full h-full object-cover 
                        group-hover:scale-105 transition-transform duration-700">
        @else
            <!-- Placeholder con gradient Tailwind -->
            <div class="w-full h-full bg-gradient-to-br 
                        from-primary-400 to-primary-600
                        flex items-center justify-center">
                <svg class="w-16 h-16 text-white opacity-50">
                    <!-- Icona poesia -->
                </svg>
            </div>
        @endif
        
        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-t 
                    from-black/50 to-transparent"></div>
    </div>
    
    <!-- Author info -->
    <div class="flex items-center gap-3 mb-3">
        <img src="{{ $poem->user->profile_photo_url }}" 
             alt="{{ $poem->user->name }}"
             class="w-10 h-10 rounded-full object-cover 
                    ring-2 ring-primary-200">
        <div>
            <p class="font-semibold text-sm text-neutral-900 dark:text-white">
                {{ $poem->user->name }}
            </p>
            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                {{ $poem->created_at->diffForHumans() }}
            </p>
        </div>
    </div>
    
    <!-- Title -->
    <h3 class="text-xl font-bold mb-2 text-neutral-900 dark:text-white
               group-hover:text-primary-600 transition-colors
               font-poem">
        "{{ $poem->title ?: __('poems.untitled') }}"
    </h3>
    
    <!-- Excerpt -->
    <p class="text-neutral-600 dark:text-neutral-400 italic 
              line-clamp-2 text-sm mb-3">
        {{ $poem->description ?? Str::limit(strip_tags($poem->content), 100) }}
    </p>
    
    <!-- Social actions -->
    @if($showActions)
        <div class="flex items-center gap-4 mt-3" @click.stop>
            <button wire:click="$dispatch('toggle-like', { poemId: {{ $poem->id }} })"
                    class="flex items-center gap-2 text-sm text-neutral-600 
                           hover:text-red-500 transition">
                <svg class="w-4 h-4">...</svg>
                <span>{{ $poem->like_count }}</span>
            </button>
            
            <button wire:click="$dispatch('open-comments', { poemId: {{ $poem->id }} })"
                    class="flex items-center gap-2 text-sm text-neutral-600
                           hover:text-primary-500 transition">
                <svg class="w-4 h-4">...</svg>
                <span>{{ $poem->comment_count }}</span>
            </button>
            
            <button class="flex items-center gap-2 text-sm text-neutral-600
                          hover:text-primary-500 transition">
                <svg class="w-4 h-4">...</svg>
            </button>
        </div>
    @endif
</article>
```

---

### 5️⃣ PoemModal.php

**Responsabilità:**
- Modal full-screen per dettaglio poesia
- Stesso contenuto di PoemShow ma in overlay
- Navigazione prev/next tra poesie

**Properties:**
```php
public bool $isOpen = false;
public ?int $poemId = null;
public ?Poem $poem = null;
```

**Listeners:**
```php
protected $listeners = ['openPoemModal' => 'open'];

public function open($poemId)
{
    $this->poemId = $poemId;
    $this->poem = Poem::with(['user', 'translations'])->find($poemId);
    $this->isOpen = true;
}
```

**View:**
```blade
<div x-data="{ open: @entangle('isOpen') }"
     x-show="open"
     @keydown.escape.window="open = false"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto">
    
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 transition-opacity"
         @click="open = false"></div>
    
    <!-- Modal -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-neutral-900 rounded-2xl
                    max-w-4xl w-full max-h-[90vh] overflow-y-auto
                    shadow-2xl">
            
            <!-- Close button -->
            <button @click="open = false"
                    class="absolute top-4 right-4 p-2 rounded-lg
                           hover:bg-neutral-100 dark:hover:bg-neutral-800">
                <svg class="w-6 h-6">...</svg>
            </button>
            
            <!-- Content (same as PoemShow) -->
            @if($poem)
                <div class="p-8">
                    <!-- Include PoemShow content here -->
                </div>
            @endif
        </div>
    </div>
</div>
```

---

### 6️⃣ PoemLanguageSelector.php

**Properties:**
```php
public Poem $poem;
public string $currentLanguage;
```

**View:**
```blade
<div class="flex flex-wrap gap-2">
    @foreach($poem->available_languages as $lang)
        <button wire:click="$dispatch('language-changed', { language: '{{ $lang['code'] }}' })"
                class="px-4 py-2 rounded-lg transition
                       {{ $currentLanguage === $lang['code']
                          ? 'bg-primary-500 text-white'
                          : 'bg-neutral-100 text-neutral-700 hover:bg-neutral-200' }}">
            
            @if($lang['is_original'])
                <svg class="w-4 h-4 inline">🏁</svg>
            @else
                <svg class="w-4 h-4 inline">🌐</svg>
            @endif
            
            {{ $lang['name'] }}
            
            @if($lang['is_official'])
                <svg class="w-4 h-4 inline text-green-500">✓</svg>
            @endif
        </button>
    @endforeach
</div>
```

---

## 📱 COMPONENTI SOCIAL (Livewire)

### Sistema Like Unificato

Già esiste il componente `like-button` ma lo adattiamo per Livewire puro:

```php
// app/Livewire/Social/LikeButton.php
class LikeButton extends Component
{
    public string $itemType;
    public int $itemId;
    public bool $isLiked = false;
    public int $likesCount = 0;
    
    public function mount()
    {
        $this->checkLikeStatus();
    }
    
    public function toggleLike()
    {
        if (!auth()->check()) {
            $this->dispatch('notify', [
                'message' => 'Effettua il login per mettere mi piace',
                'type' => 'info'
            ]);
            return;
        }
        
        $modelClass = $this->getModelClass();
        $model = $modelClass::find($this->itemId);
        
        if ($this->isLiked) {
            // Unlike
            $model->unlike(auth()->user());
            $this->isLiked = false;
            $this->likesCount--;
        } else {
            // Like
            $model->like(auth()->user());
            $this->isLiked = true;
            $this->likesCount++;
            
            // Draghetto!
            $this->dispatch('notify', ['type' => 'like']);
        }
    }
}
```

---

## 🔍 RICERCA E FILTRI (Livewire)

### Component PoemSearch.php

```php
class PoemSearch extends Component
{
    public string $query = '';
    public string $category = '';
    public string $language = '';
    public string $sortBy = 'recent';
    
    // Real-time search con debounce
    public function updatedQuery()
    {
        $this->dispatch('search-updated', [
            'query' => $this->query
        ]);
    }
    
    public function render()
    {
        $poems = Poem::published()
            ->when($this->query, function($q) {
                $q->where(function($subQ) {
                    $subQ->where('title', 'like', "%{$this->query}%")
                         ->orWhere('content', 'like', "%{$this->query}%");
                });
            })
            ->when($this->category, fn($q) => $q->byCategory($this->category))
            ->when($this->language, fn($q) => $q->byLanguage($this->language))
            ->when($this->sortBy === 'popular', fn($q) => $q->popular())
            ->when($this->sortBy === 'recent', fn($q) => $q->recent())
            ->paginate(12);
        
        return view('livewire.poems.poem-search', [
            'poems' => $poems
        ]);
    }
}
```

---

## 🎯 ALTERNATIVE SENZA JAVASCRIPT

### Editor Poesia (No Quill)

**Opzione 1: Textarea Semplice** (CONSIGLIATO)
```blade
<textarea wire:model="content"
          class="font-poem text-lg leading-relaxed whitespace-pre-wrap
                 w-full min-h-[500px] p-6 rounded-lg border">
</textarea>
```

**Opzione 2: Markdown**
```blade
<!-- Usa libreria PHP per parsing Markdown -->
<textarea wire:model="contentMarkdown">
{{ $poem->content_markdown }}
</textarea>

<!-- Nel component: -->
use Illuminate\Support\Str;

public function save()
{
    $this->poem->content = Str::markdown($this->contentMarkdown);
}
```

**Opzione 3: Livewire WYSIWYG (Wire Elements Pro)**
```blade
<x-editor wire:model="content" />
```

### Auto-save Bozze

```php
// Nel component
public function autoSave()
{
    if (!$this->isDraft) {
        return;
    }
    
    $this->validate();
    
    $this->poem->update([
        'title' => $this->title,
        'content' => $this->content,
        'draft_saved_at' => now(),
    ]);
    
    $this->lastSavedAt = now()->diffForHumans();
}
```

```blade
<!-- View con polling -->
<div wire:poll.30s="autoSave">
    <!-- Form -->
</div>
```

### Infinite Scroll

```php
// Nel component
public $page = 1;
public $perPage = 12;

public function loadMore()
{
    $this->page++;
}

public function render()
{
    $poems = Poem::published()
        ->paginate($this->perPage * $this->page);
        
    return view('livewire.poems.poem-index', [
        'poems' => $poems
    ]);
}
```

```blade
<!-- View con Intersection Observer (Alpine) -->
<div x-data="{
    observe() {
        let observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    $wire.loadMore()
                }
            })
        })
        observer.observe(this.$refs.loadMore)
    }
}" x-init="observe()">
    
    @foreach($poems as $poem)
        <livewire:poems.poem-card :poem="$poem" :key="$poem->id" />
    @endforeach
    
    <div x-ref="loadMore" class="h-20"></div>
</div>
```

---

## 📋 CHECKLIST IMPLEMENTAZIONE LIVEWIRE

### 🔴 FASE 1: Setup & Config

- [ ] **1.1** Aggiungere font 'Crimson Pro' a Tailwind config
- [ ] **1.2** Verificare Livewire v3 installato
- [ ] **1.3** Copiare Models (Poem, PoemTranslation)
- [ ] **1.4** Copiare Traits (HasLikes, HasComments, etc.)
- [ ] **1.5** Copiare config/poems.php
- [ ] **1.6** Copiare Helper PoemImageHelper
- [ ] **1.7** Copiare traduzioni lang/*/poems.php

### 🟠 FASE 2: Componenti Base

- [ ] **2.1** `PoemCard.php` + view
- [ ] **2.2** `PoemIndex.php` + view (lista + filtri)
- [ ] **2.3** `PoemShow.php` + view (dettaglio)
- [ ] **2.4** Routes per componenti full-page
- [ ] **2.5** Testare lista e dettaglio

### 🟡 FASE 3: CRUD Completo

- [ ] **3.1** `PoemCreate.php` + view (form creazione)
- [ ] **3.2** Implementare auto-save bozze (wire:poll)
- [ ] **3.3** Upload thumbnail con Livewire
- [ ] **3.4** `PoemEdit.php` + view (form modifica)
- [ ] **3.5** Eliminazione con conferma
- [ ] **3.6** Testare CRUD completo

### 🟢 FASE 4: Social Features

- [ ] **4.1** `LikeButton.php` (Livewire puro)
- [ ] **4.2** Integrazione likes in PoemCard e PoemShow
- [ ] **4.3** `BookmarkButton.php`
- [ ] **4.4** `ShareButton.php` (con clipboard API via Alpine)
- [ ] **4.5** Integrazione Comments (componente esistente)
- [ ] **4.6** Testare tutte le interazioni

### 🔵 FASE 5: Pagine Personali

- [ ] **5.1** `MyPoems.php` (le mie poesie)
- [ ] **5.2** `MyDrafts.php` (bozze)
- [ ] **5.3** `MyBookmarks.php` (salvati)
- [ ] **5.4** `MyLiked.php` (piaciute)
- [ ] **5.5** Routes per tutte le pagine
- [ ] **5.6** Testare navigazione

### 🟣 FASE 6: Ricerca Avanzata

- [ ] **6.1** `PoemSearch.php` con filtri live
- [ ] **6.2** Implementare debounce search (wire:model.live.debounce)
- [ ] **6.3** Filtri categoria/lingua/tipo
- [ ] **6.4** Ordinamenti (recent, popular, alphabetical)
- [ ] **6.5** Ottimizzare query con eager loading
- [ ] **6.6** Testare performance ricerca

### 🟤 FASE 7: Traduzioni

- [ ] **7.1** `PoemLanguageSelector.php`
- [ ] **7.2** Implementare cambio lingua (Livewire events)
- [ ] **7.3** `TranslationCreate.php` (form traduzione)
- [ ] **7.4** `TranslationList.php` (lista traduzioni)
- [ ] **7.5** Workflow approvazione traduzioni
- [ ] **7.6** Testare sistema traduzioni

### ⚫ FASE 8: Modal e UX

- [ ] **8.1** `PoemModal.php` (modal dettaglio)
- [ ] **8.2** Navigazione prev/next in modal
- [ ] **8.3** Loading states con wire:loading
- [ ] **8.4** Toast notifications
- [ ] **8.5** Skeleton loaders
- [ ] **8.6** Testare UX mobile

### ⚪ FASE 9: Moderazione

- [ ] **9.1** Implementare PoemPolicy
- [ ] **9.2** Coda moderazione (Livewire component)
- [ ] **9.3** Approvazione/rifiuto
- [ ] **9.4** Notifiche moderazione
- [ ] **9.5** Testare workflow moderazione

### 🎯 FASE 10: Ottimizzazioni

- [ ] **10.1** Lazy loading per PoemCard
- [ ] **10.2** Cache query popolari
- [ ] **10.3** Ottimizzare N+1 queries
- [ ] **10.4** Implementare defer per load asincrono
- [ ] **10.5** Testare performance con molti dati
- [ ] **10.6** SEO e metadata
- [ ] **10.7** Accessibilità (a11y)
- [ ] **10.8** Test mobile completo

---

## 🎨 ESEMPIO COMPLETO: PoemIndex

```php
<?php

namespace App\Livewire\Poems;

use App\Models\Poem;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class PoemIndex extends Component
{
    use WithPagination;
    
    #[Url(as: 'q')]
    public string $search = '';
    
    #[Url]
    public string $category = '';
    
    #[Url]
    public string $language = '';
    
    #[Url]
    public string $type = '';
    
    #[Url]
    public string $sort = 'recent';
    
    public int $perPage = 12;
    
    // Reset pagination on filter change
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedCategory()
    {
        $this->resetPage();
    }
    
    public function updatedLanguage()
    {
        $this->resetPage();
    }
    
    public function updatedType()
    {
        $this->resetPage();
    }
    
    public function updatedSort()
    {
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->reset(['search', 'category', 'language', 'type', 'sort']);
        $this->resetPage();
    }
    
    public function render()
    {
        $poems = Poem::query()
            ->with(['user:id,name,profile_photo_path'])
            ->published()
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                      ->orWhere('content', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%")
                      ->orWhereHas('user', function($userQuery) {
                          $userQuery->where('name', 'like', "%{$this->search}%");
                      });
                });
            })
            ->when($this->category, fn($q) => $q->where('category', $this->category))
            ->when($this->language, fn($q) => $q->where('language', $this->language))
            ->when($this->type, fn($q) => $q->where('poem_type', $this->type))
            ->when($this->sort === 'popular', fn($q) => $q->orderBy('view_count', 'desc')->orderBy('like_count', 'desc'))
            ->when($this->sort === 'oldest', fn($q) => $q->orderBy('published_at', 'asc'))
            ->when($this->sort === 'alphabetical', fn($q) => $q->orderBy('title', 'asc'))
            ->when($this->sort === 'recent', fn($q) => $q->orderBy('published_at', 'desc'))
            ->paginate($this->perPage);
        
        return view('livewire.poems.poem-index', [
            'poems' => $poems,
            'categories' => config('poems.categories'),
            'languages' => config('poems.languages'),
            'poemTypes' => config('poems.poem_types'),
        ]);
    }
}
```

```blade
<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2">
            {{ __('poems.title') }}
        </h1>
        <p class="text-neutral-600 dark:text-neutral-400">
            {{ __('poems.subtitle') }}
        </p>
    </div>
    
    <!-- Search & Filters -->
    <div class="bg-white dark:bg-neutral-800 rounded-2xl p-6 mb-8 shadow-sm">
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search -->
            <div class="lg:col-span-2">
                <input wire:model.live.debounce.500ms="search"
                       type="text"
                       placeholder="{{ __('poems.placeholders.search') }}"
                       class="w-full px-4 py-3 rounded-lg border border-neutral-200
                              dark:border-neutral-700 bg-white dark:bg-neutral-900
                              focus:border-primary-500 focus:ring-2 focus:ring-primary-200
                              transition">
            </div>
            
            <!-- Category -->
            <select wire:model.live="category"
                    class="px-4 py-3 rounded-lg border border-neutral-200
                           dark:border-neutral-700 bg-white dark:bg-neutral-900">
                <option value="">{{ __('poems.filters.all_categories') }}</option>
                @foreach($categories as $key => $name)
                    <option value="{{ $key }}">{{ $name }}</option>
                @endforeach
            </select>
            
            <!-- Language -->
            <select wire:model.live="language"
                    class="px-4 py-3 rounded-lg border border-neutral-200
                           dark:border-neutral-700 bg-white dark:bg-neutral-900">
                <option value="">{{ __('poems.filters.all_languages') }}</option>
                @foreach($languages as $code => $name)
                    <option value="{{ $code }}">{{ $name }}</option>
                @endforeach
            </select>
            
            <!-- Sort -->
            <select wire:model.live="sort"
                    class="px-4 py-3 rounded-lg border border-neutral-200
                           dark:border-neutral-700 bg-white dark:bg-neutral-900">
                @foreach(__('poems.filters.sort_options') as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Reset button -->
        @if($search || $category || $language || $type || $sort !== 'recent')
            <button wire:click="resetFilters"
                    class="mt-4 px-4 py-2 text-sm text-neutral-600 dark:text-neutral-400
                           hover:text-primary-500 transition">
                {{ __('poems.actions.reset_filters') }}
            </button>
        @endif
    </div>
    
    <!-- Loading indicator -->
    <div wire:loading.delay class="mb-4">
        <div class="bg-primary-50 dark:bg-primary-900/20 text-primary-600 
                    dark:text-primary-400 px-4 py-2 rounded-lg inline-flex items-center gap-2">
            <svg class="animate-spin h-4 w-4">...</svg>
            {{ __('common.loading') }}
        </div>
    </div>
    
    <!-- Poems Grid -->
    @if($poems->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach($poems as $poem)
                <livewire:poems.poem-card 
                    :poem="$poem" 
                    :key="'poem-'.$poem->id" />
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $poems->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-24 h-24 mx-auto text-neutral-300 dark:text-neutral-700 mb-4">
                <!-- Empty state icon -->
            </svg>
            <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                {{ __('poems.no_poems_found') }}
            </h3>
            <p class="text-neutral-600 dark:text-neutral-400">
                {{ __('poems.no_poems_description') }}
            </p>
        </div>
    @endif
</div>
```

---

## 🚀 VANTAGGI APPROCCIO LIVEWIRE

### ✅ PRO:
- **Zero JS custom** da mantenere
- **Zero AJAX** manuale
- **Real-time** reattività
- **SEO-friendly** (server-side rendering)
- **Più sicuro** (logica solo server-side)
- **Più veloce** da sviluppare
- **Consistente** con resto del progetto
- **Testabile** con PHPUnit

### ⚠️ CONS da Mitigare:
- Più richieste server (mitigare con debounce)
- Serve connessione (offline graceful degradation)
- Loading states da gestire bene

---

## 📝 NOTE FINALI

1. **Alpine.js**: Usare SOLO per micro-interazioni UI (dropdown, modals, tooltips)
2. **Tailwind**: Usare TUTTE utility esistenti, no CSS custom
3. **Livewire Defer**: Usare per componenti non critici (lazy load)
4. **Livewire Loading**: Sempre mostrare feedback con wire:loading
5. **Query Optimization**: Sempre eager load relazioni
6. **Debounce**: Search input con debounce 500ms
7. **Pagination**: Usare WithPagination trait
8. **URL State**: Usare #[Url] attribute per filtri
9. **Events**: Usare $dispatch per comunicazione componenti
10. **Cache**: Cache query pesanti

---

**Prossimo Step**: Iniziare FASE 1 - Setup & Config! 🚀


