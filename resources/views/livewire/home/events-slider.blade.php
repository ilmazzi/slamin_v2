<div>
    @if ($recentEvents && $recentEvents->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                {!! __('home.events_section_title') !!}
            </h2>
            <p class="text-lg text-neutral-200">
                {{ __('home.events_section_subtitle') }}
            </p>
        </div>

        {{-- Cinema Tickets - Horizontal Scroll --}}
        <div class="flex gap-6 overflow-x-auto pb-12 pt-8 scrollbar-hide"
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
            ?>
            <div class="w-80 md:w-96 flex-shrink-0 fade-scale-item"
                 x-data
                 x-intersect.once="$el.classList.add('animate-fade-in')"
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Cinema Ticket --}}
                <a href="{{ route('events.show', $event) }}" 
                   class="cinema-ticket group"
                   style="transform: rotate({{ $tilt }}deg); 
                          background: linear-gradient(135deg, {{ $selectedColors[0] }} 0%, {{ $selectedColors[1] }} 50%, {{ $selectedColors[2] }} 100%);">
                    
                    {{-- Perforated Left Edge --}}
                    <div class="ticket-perforation"></div>
                    
                    {{-- Ticket Main Content --}}
                    <div class="ticket-content">
                        
                        {{-- Ticket Header --}}
                        <div class="ticket-header">
                            <div class="ticket-admit">ADMIT ONE</div>
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
                                <div class="ticket-detail-label">ORA</div>
                                <div class="ticket-detail-value">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</div>
                            </div>
                            @endif
                            
                            @if($event->city)
                            <div class="ticket-detail-item">
                                <div class="ticket-detail-label">LUOGO</div>
                                <div class="ticket-detail-value">{{ $event->city }}</div>
                            </div>
                            @endif
                            
                            @if($event->user)
                            <div class="ticket-detail-item">
                                <div class="ticket-detail-label">ORGANIZZATO DA</div>
                                <div class="ticket-detail-value">{{ Str::limit($event->user->name, 20) }}</div>
                            </div>
                            @endif
                        </div>
                        
                        {{-- Barcode --}}
                        <div class="ticket-barcode">
                            <div class="barcode-lines">
                                @for($j = 0; $j < 40; $j++)
                                <div class="barcode-line" style="width: {{ rand(1, 3) }}px; height: {{ rand(35, 45) }}px;"></div>
                                @endfor
                            </div>
                            <div class="barcode-number">{{ str_pad($event->id, 12, '0', STR_PAD_LEFT) }}</div>
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
                </a>
            </div>
            @endforeach
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
    
    .cinema-ticket:hover {
        transform: translateY(-12px) scale(1.02) !important;
        box-shadow: 
            0 16px 32px rgba(0, 0, 0, 0.5),
            0 24px 64px rgba(0, 0, 0, 0.4),
            0 0 0 2px rgba(218, 165, 32, 0.4);
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
    
    /* Barcode */
    .ticket-barcode {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.375rem;
        margin-top: 0.5rem;
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
