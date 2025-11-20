<div>
    <h1>Gestione Carousel</h1>
    
    <div>
        <input type="text" wire:model.live="search" placeholder="Cerca carousel...">
        <button wire:click="create">Crea Carousel</button>
    </div>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Titolo</th>
                    <th>Tipo</th>
                    <th>Ordine</th>
                    <th>Attivo</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carousels as $carousel)
                    <tr>
                        <td>{{ $carousel->title }}</td>
                        <td>{{ $carousel->content_type ?? 'Upload' }}</td>
                        <td>{{ $carousel->order }}</td>
                        <td>{{ $carousel->is_active ? 'Sì' : 'No' }}</td>
                        <td>
                            <button wire:click="edit({{ $carousel->id }})">Modifica</button>
                            <button wire:click="toggleActive({{ $carousel->id }})">Toggle Attivo</button>
                            <button wire:click="delete({{ $carousel->id }})" wire:confirm="Sei sicuro?">Elimina</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $carousels->links() }}
    </div>

    @if($showModal)
        <div>
            <h2>{{ $isEditing ? 'Modifica' : 'Crea' }} Carousel</h2>
            <form wire:submit="save">
                <div>
                    <label>Tipo Contenuto</label>
                    <select wire:model="content_type">
                        <option value="">Upload Tradizionale</option>
                        @foreach($this->availableContentTypes as $type => $label)
                            <option value="{{ $type }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                @if($content_type)
                    <div>
                        <label>Cerca Contenuto</label>
                        <input type="text" wire:model.live="contentSearch" placeholder="Cerca...">
                        @if(!empty($contentSearchResults))
                            <div>
                                @foreach($contentSearchResults as $result)
                                    <button type="button" wire:click="selectContent({{ $result['id'] }})">
                                        {{ $result['title'] }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <div>
                    <label>Titolo</label>
                    <input type="text" wire:model="title">
                </div>
                <div>
                    <label>Descrizione</label>
                    <textarea wire:model="description"></textarea>
                </div>
                @if($content_type && $content_id)
                    <div>
                        <label>
                            <input type="checkbox" wire:model="use_original_image"> Usa immagine originale
                        </label>
                    </div>
                @endif
                @if(!$use_original_image || !$content_type)
                    <div>
                        <label>Immagine</label>
                        <input type="file" wire:model="image">
                        @if($existing_image)
                            <p>Immagine attuale: {{ $existing_image }}</p>
                        @endif
                    </div>
                @endif
                <div>
                    <label>Link URL</label>
                    <input type="url" wire:model="link_url">
                </div>
                <div>
                    <label>Link Testo</label>
                    <input type="text" wire:model="link_text">
                </div>
                <div>
                    <label>Ordine</label>
                    <input type="number" wire:model="order">
                </div>
                <div>
                    <label>
                        <input type="checkbox" wire:model="is_active"> Attivo
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

