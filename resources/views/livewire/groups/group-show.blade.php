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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        {{-- Pending Requests Alert (Moderators Only) --}}
        @if($isModerator)
            @php
                $pendingRequestsCount = $group->joinRequests()->where('status', 'pending')->count();
                $pendingInvitationsCount = $group->invitations()->where('status', 'pending')->count();
            @endphp
            @if($pendingRequestsCount > 0 || $pendingInvitationsCount > 0)
                <div class="bg-amber-50 dark:bg-amber-900/20 rounded-2xl p-4 border border-amber-200 dark:border-amber-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-amber-800 dark:text-amber-200">
                                    @if($pendingRequestsCount > 0)
                                        {{ $pendingRequestsCount }} {{ $pendingRequestsCount === 1 ? 'richiesta' : 'richieste' }} di accesso
                                    @endif
                                    @if($pendingRequestsCount > 0 && $pendingInvitationsCount > 0) • @endif
                                    @if($pendingInvitationsCount > 0)
                                        {{ $pendingInvitationsCount }} {{ $pendingInvitationsCount === 1 ? 'invito pendente' : 'inviti pendenti' }}
                                    @endif
                                </p>
                                <p class="text-sm text-amber-700 dark:text-amber-300">Gestisci le richieste e gli inviti</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            @if($pendingRequestsCount > 0)
                                <a href="{{ route('groups.requests.pending', $group) }}"
                                   class="px-4 py-2 bg-amber-600 text-white rounded-xl font-semibold hover:bg-amber-700 transition-all">
                                    Richieste
                                </a>
                            @endif
                            @if($pendingInvitationsCount > 0)
                                <a href="{{ route('groups.invitations.pending', $group) }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all">
                                    Inviti
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endif

        {{-- About Section --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 md:p-8">
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">Informazioni sul Gruppo</h2>
            
            <div class="space-y-6">
                @if($group->description)
                    <div>
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Descrizione</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 whitespace-pre-line">{{ $group->description }}</p>
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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Visibilità</p>
                        <p class="text-lg font-semibold text-neutral-900 dark:text-white capitalize">{{ $group->visibility === 'public' ? 'Pubblico' : 'Privato' }}</p>
                    </div>
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Membri</p>
                        <p class="text-lg font-semibold text-neutral-900 dark:text-white">{{ $group->members()->count() }}</p>
                    </div>
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Creato</p>
                        <p class="text-lg font-semibold text-neutral-900 dark:text-white">{{ $group->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Announcements Section --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Annunci</h2>
                @if($isModerator)
                    <button wire:click="$toggle('showAnnouncementForm')"
                            class="px-4 py-2 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition-all">
                        {{ $showAnnouncementForm ? 'Annulla' : 'Nuovo Annuncio' }}
                    </button>
                @endif
            </div>

            {{-- Create Announcement Form --}}
            @if($isModerator && $showAnnouncementForm)
                <div class="bg-gradient-to-br from-primary-50 to-blue-50 dark:from-primary-900/20 dark:to-blue-900/20 rounded-2xl p-6 mb-6 border border-primary-200 dark:border-primary-800">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Crea Nuovo Annuncio</h3>
                    <form wire:submit="createAnnouncement" class="space-y-4">
                        <div>
                            <label for="announcementTitle" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Titolo
                            </label>
                            <input type="text" id="announcementTitle" wire:model="announcementTitle"
                                   class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white"
                                   placeholder="Titolo dell'annuncio..." required>
                            @error('announcementTitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="announcementContent" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                Contenuto
                            </label>
                            <textarea id="announcementContent" wire:model="announcementContent" rows="4"
                                      class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white"
                                      placeholder="Scrivi il contenuto dell'annuncio..." required></textarea>
                            @error('announcementContent') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="isPinned" wire:model="announcementIsPinned"
                                   class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500">
                            <label for="isPinned" class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Fissa in alto
                            </label>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                    class="px-6 py-2.5 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition-all">
                                Pubblica Annuncio
                            </button>
                            <button type="button" wire:click="$set('showAnnouncementForm', false)"
                                    class="px-6 py-2.5 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-xl font-semibold hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-all">
                                Annulla
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Announcements List --}}
            <div class="space-y-4">
                @forelse($announcements as $announcement)
                    <div class="p-6 rounded-xl border {{ $announcement->is_pinned ? 'bg-amber-50 dark:bg-amber-900/20 border-amber-300 dark:border-amber-700' : 'bg-neutral-50 dark:bg-neutral-800 border-neutral-200 dark:border-neutral-700' }}">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($announcement->author, 40) }}"
                                     alt="{{ $announcement->author->name }}"
                                     class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-bold text-neutral-900 dark:text-white">{{ $announcement->title }}</h3>
                                        @if($announcement->is_pinned)
                                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 3a1 1 0 011 1v5h3a1 1 0 110 2h-3v5a1 1 0 11-2 0v-5H6a1 1 0 110-2h3V4a1 1 0 011-1z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ $announcement->author->name }} • {{ $announcement->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            @if($isModerator)
                                <div class="flex gap-2">
                                    <button wire:click="togglePinAnnouncement({{ $announcement->id }})"
                                            class="text-neutral-500 hover:text-amber-600 dark:hover:text-amber-400 transition-colors"
                                            title="{{ $announcement->is_pinned ? 'Rimuovi fissaggio' : 'Fissa in alto' }}">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 3a1 1 0 011 1v5h3a1 1 0 110 2h-3v5a1 1 0 11-2 0v-5H6a1 1 0 110-2h3V4a1 1 0 011-1z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteAnnouncement({{ $announcement->id }})"
                                            wire:confirm="Sei sicuro di voler eliminare questo annuncio?"
                                            class="text-neutral-500 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <p class="text-neutral-600 dark:text-neutral-400 whitespace-pre-line">{{ $announcement->content }}</p>
                    </div>
                @empty
                    <p class="text-center text-neutral-500 dark:text-neutral-400 py-12">Nessun annuncio disponibile</p>
                @endforelse
            </div>
        </div>

        {{-- Members Section --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Membri ({{ $group->members()->count() }})</h2>
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($members as $member)
                    <a href="{{ route('user.show', ['user' => $member->user->id]) }}"
                       onclick="window.location.href = this.href; return false;"
                       class="flex items-center gap-4 p-4 rounded-xl bg-neutral-50 dark:bg-neutral-800 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($member->user, 80) }}"
                             alt="{{ $member->user->name }}"
                             class="w-12 h-12 rounded-full object-cover">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-neutral-900 dark:text-white truncate">
                                {{ $member->user->name }}
                            </h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 capitalize">
                                {{ $member->role === 'admin' ? 'Amministratore' : ($member->role === 'moderator' ? 'Moderatore' : 'Membro') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Events Section --}}
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
    </div>
</div>
