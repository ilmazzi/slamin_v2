<div>
    <h1>Dashboard Admin</h1>
    
    <div>
        <h2>Statistiche Generali</h2>
        <div>
            <p>Utenti Totali: {{ number_format($this->generalStats['total_users']) }}</p>
            <p>Eventi Totali: {{ number_format($this->generalStats['total_events']) }}</p>
            <p>Gig Totali: {{ number_format($this->generalStats['total_gigs']) }}</p>
            <p>Video Totali: {{ number_format($this->generalStats['total_videos']) }}</p>
            <p>Poesie Totali: {{ number_format($this->generalStats['total_poems']) }}</p>
        </div>
    </div>

    <div>
        <h2>Statistiche Utenti</h2>
        <div>
            <p>Nuovi Oggi: {{ $this->userStats['new_today'] }}</p>
            <p>Nuovi Questa Settimana: {{ $this->userStats['new_this_week'] }}</p>
            <p>Nuovi Questo Mese: {{ $this->userStats['new_this_month'] }}</p>
            <p>Utenti Attivi: {{ $this->userStats['active_users'] }}</p>
        </div>
    </div>

    <div>
        <h2>Statistiche Eventi</h2>
        <div>
            <p>Eventi Oggi: {{ $this->eventStats['events_today'] }}</p>
            <p>Eventi in Arrivo: {{ $this->eventStats['upcoming_events'] }}</p>
            <p>Gig Attivi: {{ $this->eventStats['active_gigs'] }}</p>
        </div>
    </div>

    <div>
        <h2>Attività Recente</h2>
        <div>
            <h3>Utenti Recenti</h3>
            @foreach($this->recentActivity['recent_users'] as $user)
                <p>{{ $user->name }} - {{ $user->created_at->diffForHumans() }}</p>
            @endforeach
        </div>
        
        <div>
            <h3>Eventi Recenti</h3>
            @foreach($this->recentActivity['recent_events'] as $event)
                <p>{{ $event->title }} - {{ $event->created_at->diffForHumans() }}</p>
            @endforeach
        </div>
    </div>
</div>

