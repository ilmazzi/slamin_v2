<div>
    <h1>Log Sistema</h1>
    
    <div>
        <button wire:click="$set('type', 'activity')">Activity Logs</button>
        <button wire:click="$set('type', 'errors')">Error Logs</button>
    </div>

    <div>
        <select wire:model.live="hours">
            <option value="24">Ultime 24 ore</option>
            <option value="168">Ultima settimana</option>
            <option value="720">Ultimo mese</option>
        </select>
        @if($type === 'activity')
            <select wire:model.live="level">
                <option value="all">Tutti i livelli</option>
                <option value="info">Info</option>
                <option value="warning">Warning</option>
                <option value="error">Error</option>
                <option value="critical">Critical</option>
            </select>
            <select wire:model.live="category">
                <option value="all">Tutte le categorie</option>
                @foreach($this->categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
        @endif
    </div>

    <div>
        <h2>Statistiche</h2>
        <p>Totali: {{ $this->stats['total'] ?? 0 }}</p>
        @if($type === 'activity')
            <p>Info: {{ $this->stats['info'] ?? 0 }}</p>
            <p>Warning: {{ $this->stats['warning'] ?? 0 }}</p>
            <p>Error: {{ $this->stats['error'] ?? 0 }}</p>
        @endif
    </div>

    <div>
        @if($type === 'activity')
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Livello</th>
                        <th>Categoria</th>
                        <th>Utente</th>
                        <th>Descrizione</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $log->level }}</td>
                            <td>{{ $log->category }}</td>
                            <td>{{ $log->user->name ?? 'N/A' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($log->description ?? 'N/A', 50) }}</td>
                            <td>
                                <button wire:click="showLog({{ $log->id }})">Dettagli</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $logs->links() }}
        @else
            <p>Error logs da implementare</p>
        @endif
    </div>

    @if($showLogModal && $selectedLog)
        <div>
            <h2>Dettagli Log</h2>
            <p><strong>Data:</strong> {{ $selectedLog->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Livello:</strong> {{ $selectedLog->level }}</p>
            <p><strong>Categoria:</strong> {{ $selectedLog->category }}</p>
            <p><strong>Utente:</strong> {{ $selectedLog->user->name ?? 'N/A' }}</p>
            <p><strong>Descrizione:</strong> {{ $selectedLog->description }}</p>
            @if($selectedLog->details)
                <p><strong>Dettagli:</strong> {{ json_encode($selectedLog->details) }}</p>
            @endif
            <button wire:click="closeLogModal">Chiudi</button>
        </div>
    @endif

    <div>
        <button wire:click="clearLogs" wire:confirm="Sei sicuro di voler cancellare i log?">Cancella Log</button>
    </div>
</div>
