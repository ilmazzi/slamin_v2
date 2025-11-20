<div>
    <h1>Dashboard Moderazione</h1>
    
    <div>
        <h2>Statistiche</h2>
        <div>
            <p>Video - Pending: {{ $this->moderationStats['videos']['pending'] }}, Approved: {{ $this->moderationStats['videos']['approved'] }}</p>
            <p>Poesie - Pending: {{ $this->moderationStats['poems']['pending'] }}, Approved: {{ $this->moderationStats['poems']['approved'] }}</p>
            <p>Eventi - Pending: {{ $this->moderationStats['events']['pending'] }}, Approved: {{ $this->moderationStats['events']['approved'] }}</p>
            <p>Articoli - Pending: {{ $this->moderationStats['articles']['pending'] }}, Approved: {{ $this->moderationStats['articles']['approved'] }}</p>
            <p>Report - Pending: {{ $this->moderationStats['reports']['pending'] }}</p>
        </div>
    </div>

    <div>
        <h2>Contenuti in Attesa</h2>
        <div>
            <h3>Video</h3>
            @foreach($this->pendingContent['videos'] as $video)
                <p>{{ $video->title ?? 'N/A' }} - {{ $video->user->name ?? 'N/A' }}</p>
                <button wire:click="openNoteModal('videos', {{ $video->id }})">Gestisci</button>
            @endforeach
        </div>
        <!-- Altri tipi contenuto... -->
    </div>

    <div>
        <h2>Contenuti</h2>
        <select wire:model.live="type">
            <option value="all">Tutti</option>
            <option value="videos">Video</option>
            <option value="poems">Poesie</option>
            <option value="events">Eventi</option>
            <option value="articles">Articoli</option>
        </select>
        <select wire:model.live="status">
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>

        @if($this->type === 'all')
            @foreach($this->contents as $content)
                <div>
                    <p>{{ $content->title ?? 'N/A' }} - Tipo: {{ $content->type }}</p>
                    <button wire:click="approveContent('{{ $content->type }}', {{ $content->id }})">Approva</button>
                    <button wire:click="rejectContent('{{ $content->type }}', {{ $content->id }})">Rifiuta</button>
                </div>
            @endforeach
        @else
            @foreach($this->contents as $content)
                <div>
                    <p>{{ $content->title ?? 'N/A' }}</p>
                    <button wire:click="approveContent('{{ $this->type }}', {{ $content->id }})">Approva</button>
                    <button wire:click="rejectContent('{{ $this->type }}', {{ $content->id }})">Rifiuta</button>
                </div>
            @endforeach
            {{ $this->contents->links() }}
        @endif
    </div>

    @if($showNoteModal)
        <div>
            <h2>Note Moderazione</h2>
            <textarea wire:model="moderationNotes"></textarea>
            <button wire:click="approveContent('{{ $selectedContentType }}', {{ $selectedContentId }})">Approva</button>
            <button wire:click="rejectContent('{{ $selectedContentType }}', {{ $selectedContentId }})">Rifiuta</button>
            <button wire:click="closeNoteModal">Chiudi</button>
        </div>
    @endif

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>

