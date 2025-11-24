@props(['event'])

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
    $wearOpacity = rand(4, 8) / 10; // 0.4 to 0.8
    $spot1X = rand(5, 95);
    $spot1Y = rand(5, 95);
    $spot2X = rand(5, 95);
    $spot2Y = rand(5, 95);
    $spot3X = rand(5, 95);
    $spot3Y = rand(5, 95);
    $spot4X = rand(5, 95);
    $spot4Y = rand(5, 95);
?>

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
            --spot4-x: {{ $spot4X }}%;
            --spot4-y: {{ $spot4Y }}%;">
    
    {{-- Perforated Left Edge --}}
    <div class="ticket-perforation"></div>
    
    {{-- Watermark Logo (Top Right) --}}
    <div class="ticket-watermark">
        <img src="{{ asset('assets/images/filigrana.png') }}" 
             alt="Slamin" 
             class="w-32 h-auto md:w-40">
    </div>
    
    {{-- Ticket Main Content --}}
    <div class="ticket-content">
        
        {{-- Clickable Content Area --}}
        <a href="{{ route('events.show', $event) }}" class="ticket-clickable-area">
        
        {{-- Ticket Header --}}
        <div class="ticket-header">
            <div class="ticket-admit">{{ strtoupper($event->category ?? 'Evento') }}</div>
            @if($event->start_date ?? $event->start_datetime)
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
            @if(($event->entry_fee ?? 0) > 0)
                {{ number_format($event->entry_fee, 2, ',', '.') }} €
            @else
                {{ __('events.free') }}
            @endif
        </div>
        
        {{-- Event Details Grid --}}
        <div class="ticket-details">
            @if($event->start_date ?? $event->start_datetime)
            <div class="ticket-detail-item">
                <div class="ticket-detail-label">DATA</div>
                <div class="ticket-detail-value">
                    @if($event->start_date)
                        {{ $event->start_date->locale('it')->isoFormat('D MMM YYYY') }}
                    @elseif($event->start_datetime)
                        {{ $event->start_datetime->locale('it')->isoFormat('D MMM YYYY') }}
                    @endif
                </div>
            </div>
            @endif
            
            @if($event->start_time ?? $event->start_datetime)
            <div class="ticket-detail-item">
                <div class="ticket-detail-label">ORARIO</div>
                <div class="ticket-detail-value">
                    @if($event->start_time)
                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                        @if($event->end_time)
                        - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                        @endif
                    @elseif($event->start_datetime)
                        {{ $event->start_datetime->format('H:i') }}
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
            
            @if($event->user ?? $event->organizer)
            <div class="ticket-detail-item">
                <div class="ticket-detail-label">ORGANIZZATO DA</div>
                @php
                    $organizer = $event->user ?? $event->organizer;
                @endphp
                @if($organizer)
                    <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($organizer) }}" 
                       class="ticket-detail-value hover:underline transition-colors">
                        {{ Str::limit(\App\Helpers\AvatarHelper::getDisplayName($organizer), 20) }}
                    </a>
                @else
                    <div class="ticket-detail-value">N/A</div>
                @endif
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
                @if($event->start_date ?? $event->start_datetime)
                {{ ($event->start_date ?? $event->start_datetime)->format('d/m') }}
                @endif
            </div>
            <div class="stub-serial">#{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>
</div>

