<div class="event-show-page min-h-screen bg-neutral-50 dark:bg-neutral-900">
    
    {{-- Success Toast --}}
    @if(session('success'))
        <div class="fixed top-24 right-6 z-50"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0 translate-x-full">
            <div class="bg-gradient-to-r from-red-600 to-amber-600 px-6 py-3 shadow-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-bold text-white">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- HERO CON TICKET ORIZZONTALE --}}
    <div class="relative py-8 md:py-20 lg:py-32 overflow-hidden bg-neutral-900 dark:bg-black -mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Large Horizontal Ticket --}}
            <?php 
                $tilt = rand(-2, 2);
                $selectedColors = [
                    ['#fefaf3', '#fdf8f0', '#faf5ec'],
                    ['#fef9f1', '#fdf7ef', '#faf4ea'],
                    ['#fffbf5', '#fef9f3', '#fdf7f1']
                ][rand(0, 2)];
            ?>
            <div class="event-show-ticket-wrapper">
                <div class="event-show-ticket" style="transform: rotate({{ $tilt }}deg); background: linear-gradient(135deg, {{ $selectedColors[0] }} 0%, {{ $selectedColors[1] }} 50%, {{ $selectedColors[2] }} 100%);">
                    {{-- Perforated Top Edge --}}
                    <div class="event-ticket-perforation-top"></div>
                    
                    {{-- Ticket Content --}}
                    <div class="event-ticket-content-horizontal">
                        {{-- Left: Image --}}
                        @if($event->image_url)
                        <div class="event-ticket-image-horizontal">
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                        </div>
                        @endif
                        
                        {{-- Right: Info --}}
                        <div class="event-ticket-info-horizontal">
                            {{-- Header --}}
                            <div class="event-ticket-header-horizontal">
                                <div class="event-ticket-category">{{ strtoupper(\App\Models\Event::getCategories()[$event->category] ?? $event->category) }}</div>
                                <div class="event-ticket-serial">#{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            
                            {{-- Title --}}
                            <h1 class="event-ticket-title-horizontal">{{ $event->title }}</h1>
                            
                            {{-- Info Grid --}}
                            <div class="event-ticket-info-grid">
                                <div class="event-ticket-info-item">
                                    <div class="event-ticket-info-label">Tipo</div>
                                    <div class="event-ticket-info-value {{ $event->is_public ? 'text-red-700' : 'text-neutral-600' }}">
                                        {{ $event->is_public ? 'Pubblico' : 'Privato' }}
                                    </div>
                                </div>
                                
                                <div class="event-ticket-info-item">
                                    <div class="event-ticket-info-label">Costo</div>
                                    <div class="event-ticket-info-value text-red-700 font-bold">
                                        @if(($event->entry_fee ?? 0) > 0)
                                            {{ number_format($event->entry_fee, 2, ',', '.') }} €
                                        @else
                                            {{ __('events.free') }}
                                        @endif
                                    </div>
                                </div>
                                
                                @if($event->start_datetime)
                                <div class="event-ticket-info-item">
                                    <div class="event-ticket-info-label">Data</div>
                                    <div class="event-ticket-info-value">
                                        {{ $event->start_datetime->locale('it')->isoFormat('D MMM YYYY') }}
                                    </div>
                                </div>
                                @endif
                                
                                @if($event->start_datetime)
                                <div class="event-ticket-info-item">
                                    <div class="event-ticket-info-label">Ora</div>
                                    <div class="event-ticket-info-value">
                                        {{ $event->start_datetime->format('H:i') }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            {{-- Barcode --}}
                            <div class="event-ticket-barcode-horizontal">
                                <div class="event-barcode-lines">
                                    @for($j = 0; $j < 50; $j++)
                                    <div style="width: {{ rand(1, 3) }}px; height: {{ rand(40, 50) }}px; background: #000;"></div>
                                    @endfor
                                </div>
                                <div class="event-barcode-number">{{ str_pad($event->id, 12, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Perforated Bottom Edge --}}
                    <div class="event-ticket-perforation-bottom"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="relative py-16">
        <div class="max-w-6xl mx-auto px-6">
            
            {{-- Special Badges --}}
            <div class="flex flex-wrap gap-4 mb-12">
                @if($event->is_recurring)
                    <div class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-red-600 to-amber-600 text-white">
                        <svg class="w-6 h-6 animate-spin" style="animation-duration: 3s" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <div>
                            <div class="font-black uppercase text-sm">Ricorrente</div>
                            <div class="text-sm opacity-90">{{ ucfirst($event->recurrence_type) }}@if($event->recurrence_count) × {{ $event->recurrence_count }}@endif</div>
                        </div>
                    </div>
                @endif
                @if($event->is_availability_based)
                    <div class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-amber-600 to-red-600 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-black uppercase text-sm">Basato su Disponibilità</span>
                    </div>
                @endif
            </div>

            {{-- Grid Layout --}}
            <div class="grid lg:grid-cols-3 gap-12">
                
                {{-- Main Content (2/3) --}}
                <div class="lg:col-span-2 space-y-12">
                    
                    @if($event->description)
                        <div>
                            <div class="text-red-600 dark:text-red-400 text-xs font-black tracking-[0.3em] mb-4 uppercase">Descrizione</div>
                            <p class="text-neutral-900 dark:text-neutral-100 text-xl leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                        </div>
                    @endif

                    @if($event->requirements)
                        <div>
                            <div class="text-amber-600 dark:text-amber-400 text-xs font-black tracking-[0.3em] mb-4 uppercase">Requisiti</div>
                            <p class="text-neutral-900 dark:text-neutral-100 text-xl leading-relaxed whitespace-pre-line">{{ $event->requirements }}</p>
                        </div>
                    @endif

                    @if($event->promotional_video)
                        <div>
                            <div class="text-red-600 dark:text-red-400 text-xs font-black tracking-[0.3em] mb-4 uppercase">Video</div>
                            <div class="aspect-video bg-neutral-900">
                                <iframe src="{{ $event->promotional_video }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif

                    {{-- Groups --}}
                    {{-- @if($event->groups && $event->groups->count() > 0)
                        <div>
                            <div class="text-accent-600 dark:text-accent-400 text-xs font-black tracking-[0.3em] mb-6 uppercase">Gruppi Collegati</div>
                            <div class="space-y-4">
                                @foreach($event->groups as $group)
                                    <div class="border-l-4 border-amber-500/30 hover:border-amber-500 pl-6 transition-colors">
                                        <div class="text-neutral-900 dark:text-white text-2xl font-black mb-1">{{ $group->name }}</div>
                                        @if($group->description)
                                            <div class="text-neutral-600 dark:text-neutral-400">{{ Str::limit($group->description, 120) }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif --}}

                    {{-- Festival Events (if this is a festival) --}}
                    @if($event->category === 'festival')
                        @php
                            $festivalEvents = \App\Models\Event::where('festival_id', $event->id)->get();
                        @endphp
                        @if($festivalEvents->count() > 0)
                            <div>
                                <div class="text-red-600 dark:text-red-400 text-xs font-black tracking-[0.3em] mb-6 uppercase">Eventi del Festival ({{ $festivalEvents->count() }})</div>
                                <div class="space-y-4">
                                    @foreach($festivalEvents as $festEvent)
                                        <a href="{{ route('events.show', $festEvent) }}" 
                                           class="block border-l-4 border-red-500/30 hover:border-red-500 pl-6 transition-colors group">
                                            <div class="text-neutral-900 dark:text-white text-xl font-black mb-1 group-hover:text-red-600 dark:group-hover:text-red-400">
                                                {{ $festEvent->title }}
                                            </div>
                                            @if($festEvent->start_datetime)
                                                <div class="text-sm text-neutral-600 dark:text-neutral-400 font-bold">
                                                    {{ \Carbon\Carbon::parse($festEvent->start_datetime)->format('d M Y - H:i') }}
                                                </div>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif

                    {{-- Part of Festival (if this event is linked to a festival) --}}
                    @if($event->festival_id)
                        @php
                            $festival = \App\Models\Event::find($event->festival_id);
                        @endphp
                        @if($festival)
                            <div>
                                <div class="text-amber-600 dark:text-amber-400 text-xs font-black tracking-[0.3em] mb-4 uppercase">Fa Parte del Festival</div>
                                <a href="{{ route('events.show', $festival) }}" 
                                   class="block border-l-4 border-amber-500/50 hover:border-amber-500 pl-6 transition-colors group">
                                    <div class="text-neutral-900 dark:text-white text-3xl font-black mb-2 group-hover:text-amber-600 dark:group-hover:text-amber-400">
                                        {{ $festival->title }}
                                    </div>
                                    @if($festival->start_datetime && $festival->end_datetime)
                                        <div class="text-neutral-600 dark:text-neutral-400 font-bold">
                                            {{ \Carbon\Carbon::parse($festival->start_datetime)->format('d M Y') }} - 
                                            {{ \Carbon\Carbon::parse($festival->end_datetime)->format('d M Y') }}
                                        </div>
                                    @endif
                                </a>
                            </div>
                        @endif
                    @endif

                    {{-- Availability Options --}}
                    @if($event->is_availability_based && $event->availabilityOptions && $event->availabilityOptions->count() > 0)
                        <div>
                            <div class="text-amber-600 dark:text-amber-400 text-xs font-black tracking-[0.3em] mb-6 uppercase">Date Disponibili</div>
                            <div class="space-y-4">
                                @foreach($event->availabilityOptions as $index => $option)
                                    <div class="flex items-baseline gap-4 pl-6 border-l-2 border-amber-500/30 hover:border-amber-500 transition-colors">
                                        <span class="text-amber-600 dark:text-amber-400 font-black text-lg">{{ $index + 1 }}.</span>
                                        <div>
                                            <div class="text-neutral-900 dark:text-white font-black text-xl">{{ \Carbon\Carbon::parse($option->datetime)->format('d M Y - H:i') }}</div>
                                            @if($option->description)
                                                <div class="text-neutral-600 dark:text-neutral-400 italic">{{ $option->description }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($event->availability_deadline)
                                <div class="mt-6 px-4 py-2 bg-red-500/10 border-l-4 border-red-500 inline-block">
                                    <span class="text-red-700 dark:text-red-400 font-bold text-sm">Scadenza: {{ \Carbon\Carbon::parse($event->availability_deadline)->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Gig Positions --}}
                    @if($event->gig_positions && count($event->gig_positions) > 0)
                        <div>
                            <div class="text-amber-600 dark:text-amber-400 text-xs font-black tracking-[0.3em] mb-6 uppercase">Posizioni ({{ count($event->gig_positions) }})</div>
                            <div class="space-y-6">
                                @foreach($event->gig_positions as $position)
                                    <div class="border-l-4 border-amber-500/30 hover:border-amber-500 pl-6 transition-colors">
                                        <div class="text-neutral-900 dark:text-white text-2xl font-black mb-2">{{ ucfirst($position['type'] ?? 'Posizione') }}</div>
                                        <div class="text-neutral-600 dark:text-neutral-400 font-bold mb-3">Quantità: {{ $position['quantity'] ?? 1 }}</div>
                                        <div class="space-y-2 text-neutral-700 dark:text-neutral-300">
                                            @if(!empty($position['language']))
                                                <div>▸ Lingua: <strong class="text-neutral-900 dark:text-white">{{ ucfirst($position['language']) }}</strong></div>
                                            @endif
                                            @if(!empty($position['has_cachet']) && $position['has_cachet'])
                                                <div>▸ Cachet: <strong class="text-red-600 dark:text-red-400">{{ $position['cachet_amount'] ?? 0 }} {{ $position['cachet_currency'] ?? 'EUR' }}</strong></div>
                                            @endif
                                            @if(!empty($position['has_travel']) && $position['has_travel'])
                                                <div>▸ Spese viaggio: <strong class="text-amber-600 dark:text-amber-400">Max {{ $position['travel_max'] ?? 0 }} {{ $position['travel_currency'] ?? 'EUR' }}</strong></div>
                                            @endif
                                            @if(!empty($position['has_accommodation']) && $position['has_accommodation'])
                                                <div>▸ Vitto/Alloggio: <strong class="text-amber-600 dark:text-amber-400">{{ $position['accommodation_details'] ?? 'Incluso' }}</strong></div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Invitations --}}
                    @php
                        $performers = $event->invitations->where('role', 'performer') ?? collect();
                        $organizers = $event->invitations->where('role', 'organizer') ?? collect();
                        $audience = $event->invitations->where('role', 'audience') ?? collect();
                    @endphp

                    @if($performers->count() > 0)
                        <div>
                            <div class="text-red-600 dark:text-red-400 text-xs font-black tracking-[0.3em] mb-6 uppercase">Artisti ({{ $performers->count() }})</div>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($performers as $invitation)
                                    <div class="hover:translate-x-2 transition-transform">
                                        <x-ui.user-avatar 
                                            :user="$invitation->invitedUser" 
                                            size="md" 
                                            :showName="true" 
                                            :showStatus="true"
                                            :status="$invitation->status"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($organizers->count() > 0)
                        <div>
                            <div class="text-amber-600 dark:text-amber-400 text-xs font-black tracking-[0.3em] mb-6 uppercase">Organizzatori ({{ $organizers->count() }})</div>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($organizers as $invitation)
                                    <div class="hover:translate-x-2 transition-transform">
                                        <x-ui.user-avatar 
                                            :user="$invitation->invitedUser" 
                                            size="md" 
                                            :showName="true" 
                                            :showStatus="true"
                                            :status="$invitation->status"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($audience->count() > 0)
                        <div>
                            <div class="text-red-600 dark:text-red-400 text-xs font-black tracking-[0.3em] mb-4 uppercase">Pubblico ({{ $audience->count() }})</div>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($audience->take(12) as $invitation)
                                    <div class="hover:translate-x-2 transition-transform">
                                        <x-ui.user-avatar 
                                            :user="$invitation->invitedUser" 
                                            size="sm" 
                                            :link="true"
                                            :showName="true"
                                        />
                                    </div>
                                @endforeach
                            </div>
                            @if($audience->count() > 12)
                                <div class="mt-4 text-neutral-600 dark:text-neutral-400 text-sm font-semibold">
                                    +{{ $audience->count() - 12 }} altri invitati
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Sidebar (1/3) --}}
                <div class="lg:col-span-1 space-y-8">
                    
                    {{-- Organizer --}}
                    @if($event->organizer)
                        <div class="border-l-4 border-red-500 pl-4">
                            <div class="text-neutral-500 dark:text-neutral-400 text-xs font-black tracking-wide mb-3 uppercase">Organizzatore</div>
                            <x-ui.user-avatar 
                                :user="$event->organizer" 
                                size="sm" 
                                :showName="true" 
                                :showNickname="true" 
                            />
                        </div>
                    @endif

                    {{-- Date/Time --}}
                    @if($event->start_datetime || $event->end_datetime)
                        <div class="border-l-4 border-amber-500 pl-4">
                            <div class="text-neutral-500 dark:text-neutral-400 text-xs font-black tracking-wide mb-3 uppercase">Data & Ora</div>
                            <div class="space-y-3">
                                @if($event->start_datetime)
                                    <div>
                                        <div class="text-xs text-neutral-500 font-bold mb-1">INIZIO</div>
                                        <div class="text-neutral-900 dark:text-white font-black text-lg">{{ \Carbon\Carbon::parse($event->start_datetime)->format('d/m/Y H:i') }}</div>
                                    </div>
                                @endif
                                @if($event->end_datetime)
                                    <div>
                                        <div class="text-xs text-neutral-500 font-bold mb-1">FINE</div>
                                        <div class="text-neutral-900 dark:text-white font-black text-lg">{{ \Carbon\Carbon::parse($event->end_datetime)->format('d/m/Y H:i') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Location --}}
                    <div class="border-l-4 border-red-500 pl-4">
                        <div class="text-neutral-500 dark:text-neutral-400 text-xs font-black tracking-wide mb-3 uppercase">{{ $event->is_online ? 'Online' : 'Luogo' }}</div>
                        @if($event->is_online)
                            <a href="{{ $event->online_url }}" target="_blank" class="text-amber-600 dark:text-amber-400 font-bold hover:underline break-all">
                                {{ $event->online_url }}
                            </a>
                        @else
                            <div class="space-y-1 text-neutral-900 dark:text-white">
                                @if($event->venue_name)
                                    <div class="font-black text-lg">{{ $event->venue_name }}</div>
                                @endif
                                @if($event->venue_address)
                                    <div class="text-neutral-700 dark:text-neutral-300">{{ $event->venue_address }}</div>
                                @endif
                                @if($event->city)
                                    <div class="text-neutral-600 dark:text-neutral-400">{{ $event->postcode }} {{ $event->city }}</div>
                                @endif
                            </div>

                            {{-- Mini Map --}}
                            @if($event->latitude && $event->longitude)
                                <div class="mt-4">
                                    <div id="eventShowMap" 
                                         class="w-full h-48 rounded-xl overflow-hidden shadow-lg border-2 border-red-200 dark:border-red-800"
                                         data-lat="{{ $event->latitude }}"
                                         data-lng="{{ $event->longitude }}"
                                         data-name="{{ $event->venue_name ?? $event->title }}">
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Settings --}}
                    <div class="border-t-2 border-neutral-300 dark:border-neutral-700 pt-6">
                        <div class="text-neutral-500 dark:text-neutral-400 text-xs font-black tracking-wide mb-4 uppercase">Info</div>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between border-b border-neutral-200 dark:border-neutral-800 pb-2">
                                <span class="text-neutral-600 dark:text-neutral-400 font-bold uppercase">Capacity</span>
                                <span class="text-neutral-900 dark:text-white font-black">{{ $event->max_participants ?: '∞' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-neutral-200 dark:border-neutral-800 pb-2">
                                <span class="text-neutral-600 dark:text-neutral-400 font-bold uppercase">Requests</span>
                                <span class="font-black {{ $event->allow_requests ? 'text-red-600 dark:text-red-400' : 'text-neutral-500' }}">{{ $event->allow_requests ? 'OPEN' : 'CLOSED' }}</span>
                            </div>
                            @if($event->registration_deadline)
                                <div class="flex justify-between border-b border-neutral-200 dark:border-neutral-800 pb-2">
                                    <span class="text-neutral-600 dark:text-neutral-400 font-bold uppercase">Deadline</span>
                                    <span class="text-amber-600 dark:text-amber-400 font-black">{{ \Carbon\Carbon::parse($event->registration_deadline)->format('d/m') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-16 flex flex-wrap gap-4 items-center">
                <a href="{{ route('events.index') }}" wire:navigate
                   class="inline-flex items-center gap-2 text-neutral-900 dark:text-white text-lg font-black hover:text-red-600 dark:hover:text-red-400 transition-colors group">
                    <svg class="w-6 h-6 group-hover:-translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    TORNA AGLI EVENTI
                </a>

                {{-- Wishlist Button --}}
                <livewire:components.wishlist-button :event="$event" />

                @auth
                    @if(auth()->user()->id === $event->organizer_id || auth()->user()->canOrganizeEvents())
                        <a href="{{ route('events.edit', $event) }}" wire:navigate
                           class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-black uppercase tracking-wide transition-all hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            MODIFICA EVENTO
                        </a>
                        
                        <a href="{{ route('events.manage', $event) }}" wire:navigate
                           class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-black uppercase tracking-wide transition-all hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            GESTISCI
                        </a>
                        
                        @if($event->category === \App\Models\Event::CATEGORY_POETRY_SLAM)
                            <a href="{{ route('events.scoring.scores', $event) }}" wire:navigate
                               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-black uppercase tracking-wide transition-all hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                {{ __('events.scoring.scores') }}
                            </a>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Horizontal Ticket Styles */
        .event-show-ticket-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem 0;
        }
        
        .event-show-ticket {
            width: 100%;
            max-width: 1000px;
            border-radius: 12px;
            box-shadow: 
                0 12px 32px rgba(0, 0, 0, 0.4),
                0 24px 64px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .event-ticket-perforation-top,
        .event-ticket-perforation-bottom {
            height: 12px;
            background: linear-gradient(90deg, 
                transparent 0%,
                rgba(139, 115, 85, 0.1) 50%,
                transparent 100%
            );
            position: relative;
        }
        
        @media (min-width: 768px) {
            .event-ticket-perforation-top,
            .event-ticket-perforation-bottom {
                height: 20px;
            }
        }
        
        .event-ticket-perforation-top::before,
        .event-ticket-perforation-bottom::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: 
                radial-gradient(circle at 0 50%, transparent 3px, currentColor 3px) 0 0 / 16px 2px repeat-x;
            color: rgba(139, 115, 85, 0.3);
            transform: translateY(-50%);
        }
        
        .event-ticket-content-horizontal {
            display: flex;
            flex-direction: column;
            gap: 0;
            min-height: auto;
        }
        
        @media (min-width: 768px) {
            .event-ticket-content-horizontal {
                flex-direction: row;
                min-height: 300px;
            }
        }
        
        .event-ticket-image-horizontal {
            width: 100%;
            height: 200px;
            flex-shrink: 0;
            border-right: none;
            border-bottom: 2px dashed rgba(139, 115, 85, 0.3);
            overflow: hidden;
        }
        
        @media (min-width: 768px) {
            .event-ticket-image-horizontal {
                width: 40%;
                min-width: 300px;
                height: auto;
                border-right: 2px dashed rgba(139, 115, 85, 0.3);
                border-bottom: none;
            }
        }
        
        .event-ticket-info-horizontal {
            flex: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        @media (min-width: 768px) {
            .event-ticket-info-horizontal {
                padding: 2rem;
            }
        }
        
        .event-ticket-header-horizontal {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.75rem;
            border-bottom: 2px dashed rgba(139, 115, 85, 0.3);
            margin-bottom: 0.75rem;
        }
        
        @media (min-width: 768px) {
            .event-ticket-header-horizontal {
                padding-bottom: 1rem;
                margin-bottom: 1rem;
            }
        }
        
        .event-ticket-category {
            font-size: 0.65rem;
            font-weight: 900;
            letter-spacing: 0.1em;
            color: #b91c1c;
            text-transform: uppercase;
        }
        
        @media (min-width: 768px) {
            .event-ticket-category {
                font-size: 0.75rem;
            }
        }
        
        .event-ticket-serial {
            font-size: 0.6rem;
            font-weight: 700;
            color: #8b7355;
            font-family: 'Courier New', monospace;
        }
        
        @media (min-width: 768px) {
            .event-ticket-serial {
                font-size: 0.65rem;
            }
        }
        
        .event-ticket-title-horizontal {
            font-family: 'Crimson Pro', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.3;
            margin-bottom: 1rem;
        }
        
        @media (min-width: 768px) {
            .event-ticket-title-horizontal {
                font-size: 2rem;
                margin-bottom: 1.5rem;
            }
        }
        
        .event-ticket-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        
        @media (min-width: 768px) {
            .event-ticket-info-grid {
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
        }
        
        .event-ticket-info-item {
            text-align: left;
        }
        
        .event-ticket-info-label {
            font-size: 0.6rem;
            font-weight: 700;
            color: #8b7355;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }
        
        @media (min-width: 768px) {
            .event-ticket-info-label {
                font-size: 0.625rem;
            }
        }
        
        .event-ticket-info-value {
            font-size: 0.875rem;
            font-weight: 600;
            color: #2d2d2d;
            font-family: 'Crimson Pro', serif;
        }
        
        @media (min-width: 768px) {
            .event-ticket-info-value {
                font-size: 1rem;
            }
        }
        
        .event-ticket-barcode-horizontal {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            padding-top: 0.75rem;
            border-top: 1px dashed rgba(139, 115, 85, 0.25);
        }
        
        @media (min-width: 768px) {
            .event-ticket-barcode-horizontal {
                padding-top: 1rem;
            }
        }
        
        .event-barcode-lines {
            display: flex;
            align-items: flex-end;
            gap: 1px;
            height: 40px;
            padding: 0 0.5rem;
        }
        
        @media (min-width: 768px) {
            .event-barcode-lines {
                height: 50px;
                padding: 0 1rem;
            }
        }
        
        .event-barcode-number {
            font-size: 0.6rem;
            font-weight: 600;
            color: #666;
            font-family: 'Courier New', monospace;
            letter-spacing: 0.1em;
        }
        
        @media (min-width: 768px) {
            .event-barcode-number {
                font-size: 0.625rem;
            }
        }
        
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }
        
        .animate-blob { animation: blob 8s ease-in-out infinite; }
        .animate-blob-slow { animation: blob 12s ease-in-out infinite; }
        .animate-blob-slower { animation: blob 16s ease-in-out infinite; }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapContainer = document.getElementById('eventShowMap');
        
        if (mapContainer) {
            const lat = parseFloat(mapContainer.dataset.lat);
            const lng = parseFloat(mapContainer.dataset.lng);
            const name = mapContainer.dataset.name;
            
            // Initialize map
            const eventMap = L.map('eventShowMap', {
                scrollWheelZoom: false,
                dragging: true,
                zoomControl: true
            }).setView([lat, lng], 15);
            
            // Add Voyager tile layer
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '© OpenStreetMap, © CartoDB',
                maxZoom: 19
            }).addTo(eventMap);
            
            // Add marker
            const marker = L.marker([lat, lng], {
                icon: L.divIcon({
                    html: `<div style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); width: 32px; height: 32px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4); border: 3px solid white;"></div>`,
                    className: 'custom-event-marker',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32]
                })
            }).addTo(eventMap);
            
            // Add popup
            marker.bindPopup(`<strong>${name}</strong>`).openPopup();
            
            console.log('✅ Event show map initialized at:', lat, lng);
        }
    });
    </script>
    @endpush
</div>
