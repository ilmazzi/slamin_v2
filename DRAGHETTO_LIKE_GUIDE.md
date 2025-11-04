# 🐉 Guida Animazione Draghetto con Coriandoli

## 🎯 Cosa Fa

Quando un utente mette **like** a qualsiasi contenuto (poesia, articolo, video, evento, galleria), appare:
- 🐉 **Draghetto animato** a schermo intero
- 🎉 **50 coriandoli colorati** che cadono dall'alto
- ✨ **Particelle rosse/rosa pulsanti**
- ⏱️ **Durata**: 2 secondi

---

## ✅ Setup (GIÀ FATTO)

L'animazione è già configurata in **entrambi i layout**:
- ✅ `resources/views/components/layouts/app.blade.php`
- ✅ `resources/views/components/layouts/master.blade.php`

**Funziona automaticamente** quando viene dispatched l'evento:
```javascript
$dispatch('notify', { type: 'like' });
```

---

## 🚀 Come Usare i Componenti Riutilizzabili

### 1️⃣ Like Button (con animazione draghetto automatica!)

```blade
<x-like-button 
    :item-id="$poem->id"
    item-type="poem"
    :is-liked="$poem->isLikedBy(auth()->user())"
    :likes-count="$poem->like_count"
    size="md"
/>
```

**Parametri:**
- `item-id`: ID del contenuto (required)
- `item-type`: Tipo di contenuto: `poem`, `article`, `video`, `event`, `gallery` (required)
- `is-liked`: Booleano se l'utente ha già messo like (default: `false`)
- `likes-count`: Numero di like (default: `0`)
- `size`: Dimensione: `sm`, `md`, `lg` (default: `md`)

**Tipi supportati:**
- `poem` → Poesia
- `article` → Articolo
- `video` → Video
- `event` → Evento
- `gallery` → Galleria foto

---

### 2️⃣ Comment Button (apre modal commenti)

```blade
<x-comment-button 
    :item-id="$article->id"
    item-type="article"
    :comments-count="$article->comment_count"
    size="md"
/>
```

**Parametri:**
- `item-id`: ID del contenuto (required)
- `item-type`: Tipo di contenuto (required)
- `comments-count`: Numero di commenti (default: `0`)
- `size`: Dimensione: `sm`, `md`, `lg` (default: `md`)

---

### 3️⃣ Share Button

```blade
<x-share-button 
    :item-id="$video->id"
    item-type="video"
    size="md"
/>
```

**Parametri:**
- `item-id`: ID del contenuto (optional)
- `item-type`: Tipo di contenuto (optional)
- `size`: Dimensione: `sm`, `md`, `lg` (default: `md`)

---

## 📦 Esempio Completo - Card Poesia

```blade
<div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-4">
        <img src="{{ $poem->user->avatar }}" class="w-12 h-12 rounded-full">
        <div>
            <h3 class="font-bold">{{ $poem->user->name }}</h3>
            <p class="text-sm text-neutral-500">{{ $poem->created_at->diffForHumans() }}</p>
        </div>
    </div>
    
    <!-- Content -->
    <h4 class="text-2xl font-bold mb-3">{{ $poem->title }}</h4>
    <p class="text-neutral-600 mb-4">{{ Str::limit($poem->content, 150) }}</p>
    
    <!-- Actions -->
    <div class="flex items-center gap-6 pt-4 border-t border-neutral-100">
        <x-like-button 
            :item-id="$poem->id"
            item-type="poem"
            :is-liked="$poem->isLikedBy(auth()->user())"
            :likes-count="$poem->like_count"
        />
        
        <x-comment-button 
            :item-id="$poem->id"
            item-type="poem"
            :comments-count="$poem->comment_count"
        />
        
        <x-share-button 
            :item-id="$poem->id"
            item-type="poem"
        />
    </div>
</div>
```

---

## 🎨 Personalizzazione Dimensioni

### Small (sm)
```blade
<x-like-button size="sm" ... />  <!-- Icona 16x16, testo xs -->
```

### Medium (md) - Default
```blade
<x-like-button size="md" ... />  <!-- Icona 20x20, testo sm -->
```

### Large (lg)
```blade
<x-like-button size="lg" ... />  <!-- Icona 24x24, testo base -->
```

---

## 🔧 Classi CSS Personalizzate

Puoi aggiungere classi custom ai componenti:

```blade
<x-like-button 
    :item-id="$poem->id"
    item-type="poem"
    class="my-custom-class another-class"
/>
```

---

## 🐛 Troubleshooting

### Il draghetto non appare
✅ Verifica che stai usando uno dei layout corretti (`app.blade.php` o `master.blade.php`)
✅ Controlla la console del browser per errori JavaScript
✅ Assicurati che l'API `/api/like/toggle` sia accessibile

### I like non si salvano
✅ Verifica che l'utente sia autenticato
✅ Controlla che il tipo (`item-type`) sia uno di quelli supportati
✅ Verifica che il modello abbia la relazione con `UnifiedLike`

---

## 📝 Note Tecniche

- **Alpine.js**: I componenti usano Alpine.js per la reattività
- **API Endpoint**: `/api/like/toggle` (POST, richiede autenticazione)
- **Database**: Usa il modello `UnifiedLike` (polymorphic)
- **Fallback**: Se non autenticato, reindirizza a `/login`
- **Rollback**: In caso di errore, lo stato UI viene ripristinato

---

## 🎉 Esempio di Utilizzo in Varie Pagine

### Pagina Poesie
```blade
@foreach($poems as $poem)
    <div class="poem-card">
        <!-- ... contenuto ... -->
        <x-like-button :item-id="$poem->id" item-type="poem" :is-liked="$poem->is_liked" :likes-count="$poem->like_count" />
    </div>
@endforeach
```

### Pagina Dettaglio Articolo
```blade
<x-layouts.app>
    <article>
        <h1>{{ $article->title }}</h1>
        <p>{{ $article->content }}</p>
        
        <div class="actions">
            <x-like-button :item-id="$article->id" item-type="article" :is-liked="$isLiked" :likes-count="$article->like_count" />
            <x-comment-button :item-id="$article->id" item-type="article" :comments-count="$article->comment_count" />
            <x-share-button :item-id="$article->id" item-type="article" />
        </div>
    </article>
</x-layouts.app>
```

### Grid Video
```blade
<div class="grid grid-cols-3 gap-4">
    @foreach($videos as $video)
        <div class="video-card">
            <!-- ... thumbnail ... -->
            <div class="flex gap-4">
                <x-like-button :item-id="$video->id" item-type="video" size="sm" />
                <x-comment-button :item-id="$video->id" item-type="video" size="sm" />
            </div>
        </div>
    @endforeach
</div>
```

---

## 🚀 Pronto per l'Uso!

Ora puoi usare questi componenti **ovunque** nel progetto e il draghetto con i coriandoli apparirà automaticamente! 🐉🎉

**Ogni like = Draghetto felice con coriandoli!** ✨

