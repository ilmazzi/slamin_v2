<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
    {{-- Hero Section --}}
    <div class="relative h-64 md:h-80 bg-gradient-to-br from-primary-600 to-primary-800 overflow-hidden">
        @if($group->image)
            <img src="{{ Storage::url($group->image) }}" alt="{{ $group->name }}"
                 class="absolute inset-0 w-full h-full object-cover opacity-40">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-end pb-8">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $group->name }}</h1>
                    @if($group->visibility === 'private')
                        <span class="px-3 py-1 bg-amber-500 text-white text-sm font-semibold rounded-lg">
                            Privato
                        </span>
                    @endif
                </div>
                <p class="text-white/90 text-lg mb-4">{{ $group->description }}</p>
                <div class="flex items-center gap-4 text-white/80 text-sm">
                    <span>{{ $group->members()->count() }} membri</span>
                    <span>•</span>
                    <span>Creato da {{ $group->creator->name }}</span>
                </div>
            </div>
            
            {{-- Actions --}}
            <div class="flex gap-3">
                @if($isAdmin)
                    <a href="{{ route('groups.edit', $group) }}" wire:navigate
                       class="px-6 py-3 bg-white text-primary-600 rounded-xl font-semibold hover:bg-primary-50 transition-all shadow-lg">
                        Modifica
                    </a>
                @endif
                
                @if($isMember)
                    <button wire:click="leaveGroup" wire:confirm="Sei sicuro di voler lasciare questo gruppo?"
                            class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-all shadow-lg">
                        Lascia Gruppo
                    </button>
                @else
                    @auth
                        <button wire:click="joinGroup"
                                class="px-6 py-3 bg-white text-primary-600 rounded-xl font-semibold hover:bg-primary-50 transition-all shadow-lg">
                            {{ $group->visibility === 'public' ? 'Unisciti' : 'Richiedi Accesso' }}
                        </button>
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Section Tabs --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-2 mb-6">
            <div class="flex gap-2 overflow-x-auto">
                <button wire:click="switchSection('about')"
                        class="px-6 py-3 rounded-xl font-semibold whitespace-nowrap transition-all {{ $activeSection === 'about' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}">
                    Informazioni
                </button>
                <button wire:click="switchSection('members')"
                        class="px-6 py-3 rounded-xl font-semibold whitespace-nowrap transition-all {{ $activeSection === 'members' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}">
                    Membri ({{ $group->members()->count() }})
                </button>
                <button wire:click="switchSection('announcements')"
                        class="px-6 py-3 rounded-xl font-semibold whitespace-nowrap transition-all {{ $activeSection === 'announcements' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}">
                    Annunci
                </button>
                <button wire:click="switchSection('events')"
                        class="px-6 py-3 rounded-xl font-semibold whitespace-nowrap transition-all {{ $activeSection === 'events' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}">
                    Eventi
                </button>
                @if($isModerator)
                    @php
                        $pendingRequests = $group->joinRequests()->where('status', 'pending')->count();
                    @endphp
                    @if($pendingRequests > 0)
                        <a href="{{ route('groups.requests.pending', $group) }}"
                           class="px-6 py-3 rounded-xl font-semibold whitespace-nowrap transition-all bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300 hover:bg-amber-200 dark:hover:bg-amber-800 flex items-center gap-2">
                            Richieste Pendenti
                            <span class="px-2 py-0.5 bg-amber-500 text-white text-xs font-bold rounded-full">{{ $pendingRequests }}</span>
                        </a>
                    @endif
                @endif
            </div>
        </div>

        {{-- Content --}}
        @if($activeSection === 'about')
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 md:p-8">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">Informazioni sul Gruppo</h2>
                
                <div class="space-y-6">
                    @if($group->description)
                        <div>
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Descrizione</h3>
                            <p class="text-neutral-600 dark:text-neutral-400">{{ $group->description }}</p>
                        </div>
                    @endif

                    {{-- Social Links --}}
                    @if($group->website || $group->social_facebook || $group->social_instagram || $group->social_youtube)
                        <div>
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-3">Link Social</h3>
                            <div class="flex flex-wrap gap-3">
                                @if($group->website)
                                    <a href="{{ $group->website }}" target="_blank"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 rounded-xl hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                        Website
                                    </a>
                                @endif
                                @if($group->social_facebook)
                                    <a href="{{ $group->social_facebook }}" target="_blank"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                        Facebook
                                    </a>
                                @endif
                                @if($group->social_instagram)
                                    <a href="{{ $group->social_instagram }}" target="_blank"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300 rounded-xl hover:bg-pink-200 dark:hover:bg-pink-800 transition-colors">
                                        Instagram
                                    </a>
                                @endif
                                @if($group->social_youtube)
                                    <a href="{{ $group->social_youtube }}" target="_blank"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-xl hover:bg-red-200 dark:hover:bg-red-800 transition-colors">
                                        YouTube
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @elseif($activeSection === 'members')
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Membri</h2>
                    @if($isModerator)
                        <div class="flex gap-2">
                            <a href="{{ route('groups.invitations.create', $group) }}"
                               class="px-4 py-2 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition-all">
                                Invita Utente
                            </a>
                            <a href="{{ route('groups.members.index', $group) }}"
                               class="px-4 py-2 bg-neutral-600 text-white rounded-xl font-semibold hover:bg-neutral-700 transition-all">
                                Gestisci Membri
                            </a>
                        </div>
                    @endif
                </div>

                @if($isModerator)
                    @php
                        $pendingInvitations = $group->invitations()->where('status', 'pending')->with(['user', 'invitedBy'])->get();
                        $pendingRequests = $group->joinRequests()->where('status', 'pending')->with('user')->get();
                    @endphp

                    {{-- Richieste Pendenti --}}
                    @if($pendingRequests->count() > 0)
                        <div class="mb-8 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-amber-900 dark:text-amber-200 flex items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    Richieste di Partecipazione ({{ $pendingRequests->count() }})
                                </h3>
                                <a href="{{ route('groups.requests.pending', $group) }}" class="text-sm text-amber-700 dark:text-amber-300 hover:underline">
                                    Vedi tutte
                                </a>
                            </div>
                            <div class="space-y-3">
                                @foreach($pendingRequests->take(3) as $request)
                                    <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 flex items-center gap-4">
                                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($request->user, 50) }}"
                                             alt="{{ $request->user->name }}"
                                             class="w-12 h-12 rounded-full object-cover">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-neutral-900 dark:text-white">{{ $request->user->name }}</h4>
                                            <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $request->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <form action="{{ route('groups.requests.accept', [$group, $request]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700">
                                                    Accetta
                                                </button>
                                            </form>
                                            <form action="{{ route('groups.requests.decline', [$group, $request]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                                                    Rifiuta
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Inviti Pendenti --}}
                    @if($pendingInvitations->count() > 0)
                        <div class="mb-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-blue-900 dark:text-blue-200 flex items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Inviti Pendenti ({{ $pendingInvitations->count() }})
                                </h3>
                                <a href="{{ route('groups.invitations.pending', $group) }}" class="text-sm text-blue-700 dark:text-blue-300 hover:underline">
                                    Vedi tutti
                                </a>
                            </div>
                            <div class="space-y-3">
                                @foreach($pendingInvitations->take(3) as $invitation)
                                    <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 flex items-center gap-4">
                                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($invitation->user, 50) }}"
                                             alt="{{ $invitation->user->name }}"
                                             class="w-12 h-12 rounded-full object-cover">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-neutral-900 dark:text-white">{{ $invitation->user->name }}</h4>
                                            <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                                Invitato da {{ $invitation->invitedBy->name }} • {{ $invitation->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <form action="{{ route('group-invitations.cancel', $invitation) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Cancellare questo invito?')"
                                                    class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                                                Cancella
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

                {{-- Lista Membri --}}
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Tutti i Membri ({{ $members->count() }})</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($members as $member)
                        <a href="{{ route('profile.show', $member->user) }}" wire:navigate
                           class="flex items-center gap-4 p-4 rounded-xl bg-neutral-50 dark:bg-neutral-800 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                            <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($member->user, 80) }}"
                                 alt="{{ $member->user->name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-neutral-900 dark:text-white truncate">
                                    {{ $member->user->name }}
                                </h3>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 capitalize">
                                    {{ $member->role }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @elseif($activeSection === 'announcements')
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 md:p-8">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">Annunci</h2>
                
                @forelse($announcements as $announcement)
                    <div class="mb-6 p-6 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white">{{ $announcement->title }}</h3>
                            @if($announcement->is_pinned)
                                <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 text-xs font-semibold rounded">
                                    Fissato
                                </span>
                            @endif
                        </div>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-3">{{ $announcement->content }}</p>
                        <div class="flex items-center gap-2 text-sm text-neutral-500 dark:text-neutral-500">
                            <span>{{ $announcement->user->name }}</span>
                            <span>•</span>
                            <span>{{ $announcement->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-neutral-500 dark:text-neutral-500 py-12">Nessun annuncio disponibile</p>
                @endforelse
            </div>
        @elseif($activeSection === 'events')
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 md:p-8">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">Eventi</h2>
                
                @forelse($events as $event)
                    <a href="{{ route('events.show', $event) }}"
                       class="block mb-4 p-6 bg-neutral-50 dark:bg-neutral-800 rounded-xl hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">{{ $event->title }}</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-2">{{ Str::limit($event->description, 150) }}</p>
                        <div class="flex items-center gap-4 text-sm text-neutral-500 dark:text-neutral-500">
                            @if($event->start_datetime)
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $event->start_datetime->format('d/m/Y H:i') }}
                                </span>
                            @endif
                            @if($event->venue_name)
                                <span>•</span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->venue_name }}
                                </span>
                            @elseif($event->is_online)
                                <span>•</span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    Online
                                </span>
                            @endif
                            @if($event->category)
                                <span>•</span>
                                <span class="px-2 py-0.5 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 rounded-full text-xs font-medium capitalize">
                                    {{ __('events.category_' . $event->category) }}
                                </span>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="text-center text-neutral-500 dark:text-neutral-500 py-12">Nessun evento disponibile</p>
                @endforelse
            </div>
        @endif
    </div>
</div>
