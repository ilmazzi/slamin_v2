<div>
    @if ($recentEvents && $recentEvents->count() > 0)
    <div class="max-w-[90rem] mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif;">
                {!! __('home.events_section_title') !!}
            </h2>
            <p class="text-lg text-neutral-200 font-medium">
                {{ __('home.events_section_subtitle') }}
            </p>
        </div>

        {{-- Cinema Tickets - Horizontal Scroll with Desktop Navigation --}}
        <div class="relative" x-data="{ 
            scroll(direction) {
                const container = this.$refs.scrollContainer;
                const cards = container.children;
                if (cards.length === 0) return;
                
                const containerRect = container.getBoundingClientRect();
                const scrollLeft = container.scrollLeft;
                
                // Find current visible card
                let targetCard = null;
                for (let i = 0; i < cards.length; i++) {
                    const card = cards[i];
                    const cardRect = card.getBoundingClientRect();
                    const cardLeft = card.offsetLeft;
                    
                    if (direction > 0) {
                        // Scroll right: find first card that's partially or fully off-screen to the right
                        if (cardLeft > scrollLeft + containerRect.width - 100) {
                            targetCard = card;
                            break;
                        }
                    } else {
                        // Scroll left: find card to the left of current view
                        if (cardLeft < scrollLeft - 50) {
                            targetCard = card;
                        }
                    }
                }
                
                if (targetCard) {
                    targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
                }
            }
        }">
            <!-- Left Arrow (Desktop Only) - OUTSIDE content -->
            <button @click="scroll(-1)" 
                    class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <!-- Right Arrow (Desktop Only) - OUTSIDE content -->
            <button @click="scroll(1)" 
                    class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-neutral-300 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span>Scorri per vedere altro</span>
                </div>
            </div>
            
        <div x-ref="scrollContainer" class="flex gap-6 overflow-x-auto pb-16 pt-12 px-8 md:px-12 scrollbar-hide"
             style="-webkit-overflow-scrolling: touch;">
            @foreach($recentEvents->take(6) as $i => $event)
            <?php
                // Random ticket tilt
                $tilt = rand(-3, 3);
                // Random ticket color (vintage paper tones)
                $ticketColors = [
                    ['#fef7e6', '#fdf3d7', '#fcf0cc'], // Cream
                    ['#fff5e1', '#fff0d4', '#ffecc7'], // Peach cream
                    ['#f5f5dc', '#f0f0d0', '#ebebc4'], // Beige
                    ['#fffaf0', '#fff5e6', '#fff0dc'], // Floral white
                ];
                $selectedColors = $ticketColors[array_rand($ticketColors)];
                // Random stamp position
                $stampRotation = rand(-8, 8);
                $stampOffsetX = rand(-15, 15);
                $stampOffsetY = rand(-10, 10);
                
                // Random wear/damage effects
                $wearOpacity = rand(2, 5) / 10; // 0.2 to 0.5
                $spot1X = rand(10, 90);
                $spot1Y = rand(10, 90);
                $spot2X = rand(10, 90);
                $spot2Y = rand(10, 90);
                $spot3X = rand(10, 90);
                $spot3Y = rand(10, 90);
                $creaseRotation = rand(-45, 45);
            ?>
            <div class="w-80 md:w-96 flex-shrink-0 fade-scale-item"
                 x-data
                 x-intersect.once="$el.classList.add('animate-fade-in')"
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Cinema Ticket --}}
                <div class="cinema-ticket group ticket-worn"
                     style="transform: rotate({{ $tilt }}deg); 
                            background: linear-gradient(135deg, {{ $selectedColors[0] }} 0%, {{ $selectedColors[1] }} 50%, {{ $selectedColors[2] }} 100%);
                            --wear-opacity: {{ $wearOpacity }};
                            --spot1-x: {{ $spot1X }}%;
                            --spot1-y: {{ $spot1Y }}%;
                            --spot2-x: {{ $spot2X }}%;
                            --spot2-y: {{ $spot2Y }}%;
                            --spot3-x: {{ $spot3X }}%;
                            --spot3-y: {{ $spot3Y }}%;
                            --crease-rotation: {{ $creaseRotation }}deg;">
                    
                    {{-- Perforated Left Edge --}}
                    <div class="ticket-perforation"></div>
                    
                    {{-- Ticket Main Content --}}
                    <div class="ticket-content">
                        
                        {{-- Clickable Content Area --}}
                        <a href="{{ route('events.show', $event) }}" class="ticket-clickable-area">
                        
                        {{-- Ticket Header --}}
                        <div class="ticket-header">
                            <div class="ticket-admit">{{ strtoupper($event->category ?? 'Evento') }}</div>
                            @if($event->start_date)
                            <div class="ticket-serial">#{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
                            @endif
                        </div>
                        
                        {{-- Event Image (if available) --}}
                        @if($event->image_url)
                        <div class="ticket-image">
                            <img src="{{ $event->image_url }}" 
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                        @endif
                        
                        {{-- Event Title --}}
                        <h3 class="ticket-title">{{ $event->title }}</h3>
                        
                        {{-- Price Badge (Random Position) --}}
                        <div class="ticket-price"
                             style="transform: rotate({{ $stampRotation }}deg) translateX({{ $stampOffsetX }}px) translateY({{ $stampOffsetY }}px);">
                            @if($event->entry_fee && $event->entry_fee > 0)
                                {{ number_format($event->entry_fee, 2, ',', '.') }} €
                            @else
                                {{ __('events.free') }}
                            @endif
                        </div>
                        
                        {{-- Event Details Grid --}}
                        <div class="ticket-details">
                            @if($event->start_date)
                            <div class="ticket-detail-item">
                                <div class="ticket-detail-label">DATA</div>
                                <div class="ticket-detail-value">{{ $event->start_date->locale('it')->isoFormat('D MMM YYYY') }}</div>
                            </div>
                            @endif
                            
                            @if($event->start_time)
                            <div class="ticket-detail-item">
                                <div class="ticket-detail-label">ORARIO</div>
                                <div class="ticket-detail-value">
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                    @if($event->end_time)
                                    - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                    @endif
                                </div>
                            </div>
                            @endif
                            
                            @if($event->city)
                            <div class="ticket-detail-item">
                                <div class="ticket-detail-label">LUOGO</div>
                                <div class="ticket-detail-value ticket-location">
                                    <svg class="location-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span>{{ $event->city }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($event->user)
                            <div class="ticket-detail-item">
                                <div class="ticket-detail-label">ORGANIZZATO DA</div>
                                <div class="ticket-detail-value">{{ Str::limit($event->user->name, 20) }}</div>
                            </div>
                            @endif
                        </div>
                        
                        {{-- Interactive Barcode --}}
                        <div class="ticket-barcode-wrapper" x-data="{ showDetails: false }">
                            <div class="ticket-barcode" 
                                 @mouseenter="showDetails = true" 
                                 @mouseleave="showDetails = false">
                                <div class="barcode-lines">
                                    @for($j = 0; $j < 40; $j++)
                                    <div class="barcode-line" style="width: {{ rand(1, 3) }}px; height: {{ rand(35, 45) }}px;"></div>
                                    @endfor
                                </div>
                                <div class="barcode-number">{{ str_pad($event->id, 12, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            
                            {{-- Barcode Details Tooltip --}}
                            <div class="barcode-tooltip" 
                                 x-show="showDetails"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 style="display: none;">
                                <div class="tooltip-title">{{ __('events.event_details') }}</div>
                                @if($event->description)
                                <div class="tooltip-description">{{ Str::limit(strip_tags($event->description), 120) }}</div>
                                @endif
                                @if($event->venue_name)
                                <div class="tooltip-row">
                                    <span class="tooltip-label">{{ __('events.venue') }}:</span>
                                    <span class="tooltip-value">{{ $event->venue_name }}</span>
                                </div>
                                @endif
                                @if($event->max_participants)
                                <div class="tooltip-row">
                                    <span class="tooltip-label">{{ __('events.max_participants') }}:</span>
                                    <span class="tooltip-value">{{ $event->max_participants }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        </a>
                        
                        {{-- Social Actions (outside link) --}}
                        <div class="ticket-social">
                            <x-like-button 
                                :itemId="$event->id"
                                itemType="event"
                                :isLiked="$event->is_liked ?? false"
                                :likesCount="$event->like_count ?? 0"
                                size="sm" />
                            
                            <x-comment-button 
                                :itemId="$event->id"
                                itemType="event"
                                :commentsCount="$event->comment_count ?? 0"
                                size="sm" />
                            
                            <x-share-button 
                                :itemId="$event->id"
                                itemType="event"
                                size="sm" />
                        </div>
                    </div>
                    
                    {{-- Stub Section (tear-off part) --}}
                    <div class="ticket-stub">
                        <div class="stub-perforation"></div>
                        <div class="stub-content">
                            <div class="stub-date">
                                @if($event->start_date)
                                {{ $event->start_date->format('d/m') }}
                                @endif
                            </div>
                            <div class="stub-serial">#{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-12">
            <x-ui.buttons.primary :href="route('events.index')" size="md" icon="M9 5l7 7-7 7">
                {{ __('home.all_events_button') }}
            </x-ui.buttons.primary>
        </div>
    </div>
    
    <style>
    /* ========================================
       CINEMA TICKETS - REALISTIC DESIGN
       ======================================== */
    
    /* Cinema Ticket */
    .cinema-ticket {
        display: flex;
        background: #fef7e6;
        border-radius: 8px;
        box-shadow: 
            0 8px 24px rgba(0, 0, 0, 0.4),
            0 16px 48px rgba(0, 0, 0, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    /* Worn/Vintage Effect - Random per ticket */
    .ticket-worn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            /* Paper texture/grain */
            url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' /%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23noise)' opacity='0.15'/%3E%3C/svg%3E"),
            /* Fingerprint 1 - Partial whorl pattern with breaks */
            url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='rgba(139,115,85,0.3)' stroke-width='0.9' stroke-linecap='round'%3E%3Cpath d='M30,50 Q35,35 50,30 Q65,35 70,50' /%3E%3Cpath d='M28,55 Q32,38 50,32 Q68,38 72,55' /%3E%3Cpath d='M26,58 Q30,40 50,35 Q70,42 74,60' /%3E%3Cpath d='M35,65 Q40,48 50,42 Q62,50 68,68' /%3E%3Cpath d='M38,70 Q42,52 50,46 Q58,54 65,72' /%3E%3Cpath d='M45,25 Q48,20 52,20' /%3E%3Cpath d='M25,48 Q28,45 32,45' /%3E%3C/g%3E%3C/svg%3E") var(--spot1-x) var(--spot1-y) / 55px 70px no-repeat,
            /* Fingerprint 2 - Partial loop pattern */
            url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='rgba(139,115,85,0.22)' stroke-width='0.8' stroke-linecap='round'%3E%3Cpath d='M40,30 Q30,40 30,55 Q30,70 45,75' /%3E%3Cpath d='M45,28 Q33,38 33,55 Q33,68 48,73' /%3E%3Cpath d='M50,27 Q36,36 36,55 Q36,66 52,71' /%3E%3Cpath d='M55,28 Q40,35 40,55 Q40,64 56,70' /%3E%3Cpath d='M35,45 Q32,50 33,58' /%3E%3C/g%3E%3C/svg%3E") var(--spot2-x) var(--spot2-y) / 45px 60px no-repeat,
            /* Fingerprint 3 - Partial arch pattern, very faded */
            url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='rgba(139,115,85,0.15)' stroke-width='0.7' stroke-linecap='round'%3E%3Cpath d='M20,60 Q50,35 80,60' /%3E%3Cpath d='M22,65 Q50,38 78,65' /%3E%3Cpath d='M25,68 Q50,42 75,68' /%3E%3Cpath d='M28,72 Q50,46 72,72' /%3E%3Cpath d='M32,75 Q50,50 68,75' /%3E%3C/g%3E%3C/svg%3E") var(--spot3-x) var(--spot3-y) / 40px 50px no-repeat;
        pointer-events: none;
        z-index: 1;
        opacity: calc(var(--wear-opacity) + 0.3);
    }
    
    /* Crease/Fold effect */
    .ticket-worn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: -10%;
        right: -10%;
        height: 1px;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(139, 115, 85, calc(var(--wear-opacity) * 0.6)) 20%,
            rgba(139, 115, 85, calc(var(--wear-opacity) * 0.4)) 50%,
            rgba(139, 115, 85, calc(var(--wear-opacity) * 0.6)) 80%,
            transparent 100%
        );
        transform: rotate(var(--crease-rotation)) translateY(-50%);
        box-shadow: 
            0 1px 2px rgba(139, 115, 85, calc(var(--wear-opacity) * 0.3)),
            0 -1px 2px rgba(139, 115, 85, calc(var(--wear-opacity) * 0.3));
        pointer-events: none;
        z-index: 1;
    }
    
    /* Make sure content is above wear effects */
    .ticket-content {
        position: relative;
        z-index: 2;
    }
    
    .cinema-ticket:hover {
        transform: translateY(-12px) scale(1.02) !important;
        box-shadow: 
            0 16px 32px rgba(0, 0, 0, 0.5),
            0 24px 64px rgba(0, 0, 0, 0.4),
            0 0 0 2px rgba(218, 165, 32, 0.4);
    }
    
    /* Clickable area (link) */
    .ticket-clickable-area {
        display: block;
        color: inherit;
        text-decoration: none;
    }
    
    /* Perforated Left Edge */
    .ticket-perforation {
        width: 24px;
        background: linear-gradient(135deg, 
            rgba(139, 115, 85, 0.15) 0%,
            rgba(160, 140, 110, 0.1) 100%
        );
        position: relative;
        flex-shrink: 0;
    }
    
    .ticket-perforation::before {
        content: '';
        position: absolute;
        top: -5px;
        bottom: -5px;
        right: 0;
        width: 12px;
        background: 
            radial-gradient(circle at 0 8px, transparent 4px, currentColor 4px) 0 0 / 12px 16px repeat-y;
        color: inherit;
    }
    
    /* Main Content Area */
    .ticket-content {
        flex: 1;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    /* Header */
    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 0.75rem;
        border-bottom: 2px dashed rgba(139, 115, 85, 0.3);
    }
    
    .ticket-admit {
        font-size: 0.75rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        color: #b91c1c;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    .ticket-serial {
        font-size: 0.65rem;
        font-weight: 700;
        color: #8b7355;
        font-family: 'Courier New', monospace;
    }
    
    /* Event Image */
    .ticket-image {
        width: 100%;
        height: 140px;
        border-radius: 4px;
        overflow: hidden;
        border: 2px solid rgba(139, 115, 85, 0.2);
        margin: 0.5rem 0;
    }
    
    /* Title */
    .ticket-title {
        font-family: 'Crimson Pro', serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.3;
        text-align: center;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0.5rem 0;
    }
    
    /* Details Grid */
    .ticket-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        padding: 1rem 0;
        border-top: 1px dashed rgba(139, 115, 85, 0.25);
        border-bottom: 1px dashed rgba(139, 115, 85, 0.25);
    }
    
    .ticket-detail-item {
        text-align: center;
    }
    
    .ticket-detail-label {
        font-size: 0.625rem;
        font-weight: 700;
        color: #8b7355;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }
    
    .ticket-detail-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: #2d2d2d;
        font-family: 'Crimson Pro', serif;
    }
    
    .ticket-location {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
    }
    
    .location-icon {
        width: 14px;
        height: 14px;
        color: #8b7355;
        flex-shrink: 0;
    }
    
    /* Price - Stamp with Special Elite Font (Authentic Stamp Font) */
    .ticket-price {
        text-align: center;
        font-size: 0.75rem;
        font-weight: 400;
        color: #b91c1c;
        font-family: 'Special Elite', 'Courier New', monospace;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.25rem 0.625rem;
        margin: 0.5rem auto;
        width: fit-content;
        border: 2px solid #b91c1c;
        border-radius: 3px;
        opacity: 0.75;
        position: relative;
        /* Minimal effects - font does the work! */
        box-shadow: 
            0 1px 3px rgba(185, 28, 28, 0.15),
            inset 0 0 6px rgba(185, 28, 28, 0.04);
        background: 
            /* Light texture for ink absorption */
            radial-gradient(ellipse at 30% 40%, rgba(185, 28, 28, 0.03) 0%, transparent 60%),
            radial-gradient(ellipse at 70% 70%, rgba(185, 28, 28, 0.025) 0%, transparent 50%);
        pointer-events: none;
    }
    
    /* Subtle irregular border */
    .ticket-price::before {
        content: '';
        position: absolute;
        inset: -1px;
        border: 1px solid rgba(185, 28, 28, 0.12);
        border-radius: 2px;
        pointer-events: none;
    }
    
    /* Barcode Wrapper */
    .ticket-barcode-wrapper {
        position: relative;
        margin-top: 0.5rem;
    }
    
    /* Barcode */
    .ticket-barcode {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.375rem;
        cursor: help;
        transition: all 0.3s ease;
    }
    
    .ticket-barcode:hover {
        transform: scale(1.05);
    }
    
    .barcode-lines {
        display: flex;
        align-items: flex-end;
        gap: 1px;
        height: 45px;
        padding: 0 1rem;
    }
    
    .barcode-line {
        background: #000;
        align-self: flex-end;
    }
    
    .barcode-number {
        font-size: 0.625rem;
        font-weight: 600;
        color: #666;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.1em;
    }
    
    /* Barcode Tooltip - Vintage Paper Style */
    .barcode-tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, 
            #fef9f0 0%,
            #fdf5e6 50%,
            #fcf1dc 100%
        );
        color: #2d2d2d;
        padding: 1rem 1.25rem;
        border-radius: 6px;
        border: 2px solid rgba(139, 115, 85, 0.3);
        box-shadow: 
            0 8px 20px rgba(0, 0, 0, 0.3),
            0 4px 12px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.5);
        z-index: 50;
        min-width: 260px;
        max-width: 300px;
    }
    
    .barcode-tooltip::before {
        content: '';
        position: absolute;
        inset: 4px;
        border: 1px solid rgba(139, 115, 85, 0.15);
        border-radius: 4px;
        pointer-events: none;
    }
    
    .barcode-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 8px solid transparent;
        border-top-color: #fdf5e6;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }
    
    .tooltip-title {
        font-size: 0.75rem;
        font-weight: 900;
        color: #b91c1c;
        margin-bottom: 0.625rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        text-align: center;
        border-bottom: 2px solid rgba(185, 28, 28, 0.2);
        padding-bottom: 0.5rem;
    }
    
    .tooltip-description {
        font-size: 0.75rem;
        line-height: 1.5;
        color: #4a4035;
        margin-bottom: 0.75rem;
        font-style: italic;
        text-align: center;
    }
    
    .tooltip-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.6875rem;
        padding: 0.5rem 0;
        border-top: 1px dashed rgba(139, 115, 85, 0.2);
    }
    
    .tooltip-label {
        color: #8b7355;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        font-size: 0.625rem;
    }
    
    .tooltip-value {
        color: #2d2d2d;
        font-weight: 600;
        font-family: 'Crimson Pro', serif;
    }
    
    /* Social Actions */
    .ticket-social {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        padding-top: 1rem;
        margin-top: 0.75rem;
        border-top: 1px dashed rgba(139, 115, 85, 0.25);
    }
    
    /* Stub (tear-off section) */
    .ticket-stub {
        width: 80px;
        background: linear-gradient(180deg, 
            rgba(139, 115, 85, 0.08) 0%,
            rgba(160, 140, 110, 0.05) 100%
        );
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border-left: 2px dashed rgba(139, 115, 85, 0.3);
        flex-shrink: 0;
    }
    
    .stub-perforation {
        position: absolute;
        top: -5px;
        bottom: -5px;
        left: -6px;
        width: 12px;
        background: 
            radial-gradient(circle at 12px 8px, transparent 4px, currentColor 4px) 0 0 / 12px 16px repeat-y;
    }
    
    .stub-content {
        writing-mode: vertical-rl;
        text-align: center;
        transform: rotate(180deg);
        padding: 1rem 0.5rem;
    }
    
    .stub-date {
        font-size: 1.25rem;
        font-weight: 900;
        color: #2d2d2d;
        font-family: 'Crimson Pro', serif;
        margin-bottom: 0.75rem;
    }
    
    .stub-serial {
        font-size: 0.625rem;
        font-weight: 700;
        color: #8b7355;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.05em;
    }
    
    /* Fade-in animation */
    @keyframes fade-in { 
        from { opacity: 0; transform: scale(0.95); } 
        to { opacity: 1; transform: scale(1); } 
    }
    .animate-fade-in { 
        animation: fade-in 0.5s ease-out forwards; 
        opacity: 0; 
    }
    </style>
    @endif
</div>
