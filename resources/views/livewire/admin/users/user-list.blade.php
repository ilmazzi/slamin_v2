<div>
    <h1>Gestione Utenti</h1>
    
    <div>
        <input type="text" wire:model.live="search" placeholder="Cerca utente...">
        <select wire:model.live="status">
            <option value="all">Tutti</option>
            <option value="active">Attivi</option>
            <option value="inactive">Non Attivi</option>
        </select>
    </div>

    <div>
        <h2>Statistiche</h2>
        <p>Totali: {{ $this->stats['total'] }}</p>
        <p>Attivi: {{ $this->stats['active'] }}</p>
        <p>Non Attivi: {{ $this->stats['inactive'] }}</p>
    </div>

    <div>
        <table>
            <thead>
                <tr>
                    <th wire:click="sortByColumn('name')">Nome</th>
                    <th wire:click="sortByColumn('email')">Email</th>
                    <th>Ruoli</th>
                    <th>Stato</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                        <td>{{ $user->status ?? 'N/A' }}</td>
                        <td>
                            <button wire:click="openEditModal({{ $user->id }})">Modifica</button>
                            <button wire:click="deleteUser({{ $user->id }})" wire:confirm="Sei sicuro?">Elimina</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>

    @if($showEditModal)
        <div>
            <h2>{{ $isEditing ? 'Modifica' : 'Crea' }} Utente</h2>
            <form wire:submit="updateUser">
                <div>
                    <label>Nome</label>
                    <input type="text" wire:model="name">
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" wire:model="email">
                </div>
                <div>
                    <label>Nickname</label>
                    <input type="text" wire:model="nickname">
                </div>
                <div>
                    <label>Stato</label>
                    <select wire:model="userStatus">
                        <option value="active">Attivo</option>
                        <option value="inactive">Non Attivo</option>
                    </select>
                </div>
                <button type="submit">Salva</button>
                <button type="button" wire:click="closeEditModal">Annulla</button>
            </form>
        </div>
    @endif

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif

    @if (session()->has('error'))
        <div>{{ session('error') }}</div>
    @endif
</div>

