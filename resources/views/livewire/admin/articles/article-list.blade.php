<div>
    <h1>Gestione Articoli</h1>
    
    <div>
        <input type="text" wire:model.live="search" placeholder="Cerca articolo...">
        <select wire:model.live="category">
            <option value="all">Tutte le categorie</option>
            @foreach($this->categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <select wire:model.live="status">
            <option value="all">Tutti</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
        </select>
        <button wire:click="create">Crea Articolo</button>
    </div>

    <div>
        <table>
            <thead>
                <tr>
                    <th wire:click="sortByColumn('title')">Titolo</th>
                    <th>Categoria</th>
                    <th>Autore</th>
                    <th>Stato</th>
                    <th>Moderazione</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->title['it'] ?? 'N/A' }}</td>
                        <td>{{ $article->category->name ?? 'N/A' }}</td>
                        <td>{{ $article->user->name ?? 'N/A' }}</td>
                        <td>{{ $article->status }}</td>
                        <td>{{ $article->moderation_status }}</td>
                        <td>
                            <button wire:click="edit({{ $article->id }})">Modifica</button>
                            <button wire:click="delete({{ $article->id }})" wire:confirm="Sei sicuro?">Elimina</button>
                            @if($article->moderation_status === 'pending')
                                <button wire:click="approve({{ $article->id }})">Approva</button>
                                <button wire:click="reject({{ $article->id }})">Rifiuta</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $articles->links() }}
    </div>

    @if($showModal)
        <div>
            <h2>{{ $isEditing ? 'Modifica' : 'Crea' }} Articolo</h2>
            <form wire:submit="save">
                <div>
                    <label>Titolo (IT)</label>
                    <input type="text" wire:model="title.it">
                </div>
                <div>
                    <label>Contenuto (IT)</label>
                    <textarea wire:model="content.it"></textarea>
                </div>
                <div>
                    <label>Excerpt (IT)</label>
                    <textarea wire:model="excerpt.it"></textarea>
                </div>
                <div>
                    <label>Categoria</label>
                    <select wire:model="category_id">
                        <option value="">Nessuna</option>
                        @foreach($this->categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Immagine Featured</label>
                    <input type="file" wire:model="featured_image">
                    @if($existing_featured_image)
                        <p>Immagine attuale: {{ $existing_featured_image }}</p>
                    @endif
                </div>
                <div>
                    <label>Stato</label>
                    <select wire:model="articleStatus">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                <div>
                    <label>
                        <input type="checkbox" wire:model="featured"> Featured
                    </label>
                </div>
                <button type="submit">Salva</button>
                <button type="button" wire:click="closeModal">Annulla</button>
            </form>
        </div>
    @endif

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>

