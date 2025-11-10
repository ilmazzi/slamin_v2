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

        {{-- Cinema Posters - Horizontal Scroll (like Dashboard) --}}
        <div class="flex gap-8 overflow-x-auto pb-12 pt-8 scrollbar-hide"
             style="-webkit-overflow-scrolling: touch;">
            @foreach($recentEvents->take(6) as $i => $event)
            <?php
                // Random spotlight intensity and tilt
                $tilt = rand(-2, 2);
                $spotlightIntensity = rand(85, 100) / 100;
            ?>
            <div class="w-80 md:w-96 flex-shrink-0 fade-scale-item"
                 x-data
                 x-intersect.once="$el.classList.add('animate-fade-in')"
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Cinema Poster Frame --}}
                <div class="cinema-poster-wrapper" style="transform: rotate({{ $tilt }}deg);">
                    
                    {{-- Spotlight Effect --}}
                    <div class="spotlight" style="opacity: {{ $spotlightIntensity }};"></div>
                    
                    <a href="{{ route('events.show', $event) }}" 
                       class="cinema-poster group">
                        
                        {{-- Poster Image --}}
                        <div class="poster-image-container">
                            @if($event->image)
                                <img src="{{ $event->image }}" 
                                     alt="{{ $event->title }}"
                                     class="poster-image">
                            @else
                                {{-- Elegant vintage poster design (no image) --}}
                                <div class="poster-vintage-design">
                                    {{-- Decorative top border --}}
                                    <div class="poster-vintage-top"></div>
                                    
                                    {{-- Main title area --}}
                                    <div class="poster-vintage-title">
                                        {{ $event->title }}
                                    </div>
                                    
                                    {{-- Decorative line --}}
                                    <div class="poster-vintage-line"></div>
                                    
                                    {{-- Event info --}}
                                    <div class="poster-vintage-info">
                                        @if($event->start_date)
                                        <div class="poster-vintage-date">
                                            {{ $event->start_date->locale('it')->isoFormat('D MMMM YYYY') }}
                                        </div>
                                        @endif
                                        
                                        @if($event->start_time)
                                        <div class="poster-vintage-time">
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                        </div>
                                        @endif
                                        
                                        @if($event->city)
                                        <div class="poster-vintage-location">
                                            {{ strtoupper($event->city) }}
                                        </div>
                                        @endif
                                    </div>
                                    
                                    {{-- Decorative bottom element --}}
                                    <div class="poster-vintage-bottom">
                                        <div class="poster-vintage-ornament">✦</div>
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Dark overlay ONLY for images --}}
                            @if($event->image)
                                <div class="poster-overlay"></div>
                            @endif
                            
                            {{-- Event Date Badge (top right) - ONLY for images --}}
                            @if($event->image && $event->start_date)
                            <div class="poster-date-badge">
                                <div class="poster-date-day">{{ $event->start_date->format('d') }}</div>
                                <div class="poster-date-month">{{ $event->start_date->locale('it')->isoFormat('MMM') }}</div>
                            </div>
                            @endif
                            
                            {{-- Event Title & Info - ONLY for images --}}
                            @if($event->image)
                            <div class="poster-content">
                                <h3 class="poster-title">{{ $event->title }}</h3>
                                
                                {{-- Event Info --}}
                                <div class="poster-info">
                                    {{-- Location --}}
                                    @if($event->city)
                                    <div class="poster-info-item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        <span>{{ $event->city }}</span>
                                    </div>
                                    @endif
                                    
                                    {{-- Time --}}
                                    @if($event->start_time)
                                    <div class="poster-info-item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                {{-- Organizer --}}
                                @if($event->user)
                                <div class="poster-organizer">
                                    <span class="poster-organizer-label">Organizzato da</span>
                                    <span class="poster-organizer-name">{{ $event->user->name }}</span>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        
                        {{-- Decorative Border Effect --}}
                        <div class="poster-border"></div>
                    </a>
                </div>
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
       CINEMA / THEATRE WALL - EVENT POSTERS
       ======================================== */
    
    /* Poster Wrapper */
    .cinema-poster-wrapper {
        position: relative;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Spotlight from above */
    .spotlight {
        position: absolute;
        top: -80px;
        left: 50%;
        transform: translateX(-50%);
        width: 180%;
        height: 120px;
        background: radial-gradient(ellipse, 
            rgba(255, 248, 220, 0.3) 0%, 
            rgba(255, 248, 220, 0.15) 30%, 
            transparent 70%
        );
        pointer-events: none;
        z-index: 10;
        transition: opacity 0.4s ease;
    }
    
    .cinema-poster-wrapper:hover .spotlight {
        opacity: 1 !important;
    }
    
    /* Cinema Poster */
    .cinema-poster {
        display: block;
        position: relative;
        background: #0a0a0a;
        padding: 0.75rem;
        box-shadow: 
            0 8px 24px rgba(0, 0, 0, 0.6),
            0 16px 48px rgba(0, 0, 0, 0.4),
            inset 0 0 0 1px rgba(218, 165, 32, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    
    .cinema-poster-wrapper:hover .cinema-poster {
        transform: translateY(-12px) scale(1.03);
        box-shadow: 
            0 16px 32px rgba(0, 0, 0, 0.7),
            0 24px 64px rgba(0, 0, 0, 0.5),
            0 0 0 2px rgba(218, 165, 32, 0.6),
            inset 0 0 0 1px rgba(218, 165, 32, 0.5);
    }
    
    :is(.dark .cinema-poster) {
        background: #050505;
    }
    
    /* Poster Image Container */
    .poster-image-container {
        position: relative;
        aspect-ratio: 2/3;
        overflow: hidden;
        background: #1a1a1a;
    }
    
    .poster-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .group:hover .poster-image {
        transform: scale(1.08);
    }
    
    /* Dark overlay for text readability */
    .poster-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(0, 0, 0, 0.95) 0%,
            rgba(0, 0, 0, 0.7) 40%,
            rgba(0, 0, 0, 0.3) 70%,
            transparent 100%
        );
    }
    
    /* Vintage Poster Design (no image) - Elegant Typography Poster */
    .poster-vintage-design {
        width: 100%;
        height: 100%;
        background: 
            /* Art Deco pattern */
            repeating-linear-gradient(
                45deg,
                transparent,
                transparent 20px,
                rgba(218, 165, 32, 0.08) 20px,
                rgba(218, 165, 32, 0.08) 40px
            ),
            /* Rich gradient */
            linear-gradient(160deg, 
                #1a1a2e 0%,
                #16213e 30%,
                #0f3460 60%,
                #16213e 100%
            );
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 2rem 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    /* Decorative top border */
    .poster-vintage-top {
        height: 4px;
        background: linear-gradient(90deg, 
            transparent 0%,
            rgba(218, 165, 32, 0.8) 20%,
            rgba(255, 215, 0, 1) 50%,
            rgba(218, 165, 32, 0.8) 80%,
            transparent 100%
        );
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(218, 165, 32, 0.3);
    }
    
    /* Title area */
    .poster-vintage-title {
        font-family: 'Crimson Pro', serif;
        font-size: 2rem;
        font-weight: 700;
        color: #ffffff;
        text-align: center;
        line-height: 1.2;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-shadow: 
            0 0 20px rgba(255, 215, 0, 0.4),
            0 2px 8px rgba(0, 0, 0, 0.6);
        margin-bottom: 1.5rem;
    }
    
    /* Decorative line */
    .poster-vintage-line {
        height: 2px;
        background: linear-gradient(90deg, 
            transparent 0%,
            rgba(255, 215, 0, 0.6) 30%,
            rgba(255, 215, 0, 0.9) 50%,
            rgba(255, 215, 0, 0.6) 70%,
            transparent 100%
        );
        margin: 1.5rem 0;
    }
    
    /* Info section */
    .poster-vintage-info {
        text-align: center;
        space-y: 0.75rem;
    }
    
    .poster-vintage-date {
        font-size: 1.125rem;
        font-weight: 600;
        color: #ffd700;
        margin-bottom: 0.5rem;
        letter-spacing: 0.05em;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    }
    
    .poster-vintage-time {
        font-size: 1.5rem;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 0.75rem;
        font-family: 'Crimson Pro', serif;
        text-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
    }
    
    .poster-vintage-location {
        font-size: 1rem;
        font-weight: 700;
        color: #daa520;
        letter-spacing: 0.15em;
        margin-top: 0.75rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    }
    
    /* Bottom decorative element */
    .poster-vintage-bottom {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .poster-vintage-ornament {
        font-size: 2rem;
        color: #ffd700;
        text-shadow: 
            0 0 20px rgba(255, 215, 0, 0.6),
            0 2px 8px rgba(0, 0, 0, 0.6);
        animation: pulse-glow 3s ease-in-out infinite;
    }
    
    @keyframes pulse-glow {
        0%, 100% { 
            opacity: 0.8;
            text-shadow: 
                0 0 20px rgba(255, 215, 0, 0.6),
                0 2px 8px rgba(0, 0, 0, 0.6);
        }
        50% { 
            opacity: 1;
            text-shadow: 
                0 0 30px rgba(255, 215, 0, 0.9),
                0 0 15px rgba(255, 215, 0, 0.6),
                0 2px 8px rgba(0, 0, 0, 0.6);
        }
    }
    
    /* Date Badge */
    .poster-date-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(218, 165, 32, 0.95);
        backdrop-filter: blur(8px);
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        text-align: center;
        border: 2px solid rgba(255, 215, 0, 0.6);
        z-index: 20;
    }
    
    .poster-date-day {
        font-size: 1.5rem;
        font-weight: 900;
        line-height: 1;
        color: #1a1a1a;
        font-family: 'Crimson Pro', serif;
    }
    
    .poster-date-month {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #2d2d2d;
        letter-spacing: 0.05em;
    }
    
    /* Content Area */
    .poster-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.5rem 1rem;
        z-index: 15;
    }
    
    /* Title */
    .poster-title {
        font-size: 1.375rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.75rem;
        line-height: 1.3;
        font-family: 'Crimson Pro', serif;
        text-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.8),
            0 4px 16px rgba(0, 0, 0, 0.6);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Info Items */
    .poster-info {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    
    .poster-info-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.875rem;
        color: #ffd700;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
    }
    
    .poster-info-item svg {
        flex-shrink: 0;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.4));
    }
    
    /* Organizer */
    .poster-organizer {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
    }
    
    .poster-organizer-label {
        font-size: 0.625rem;
        color: rgba(255, 255, 255, 0.6);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }
    
    .poster-organizer-name {
        font-size: 0.875rem;
        color: #ffffff;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
    }
    
    /* Decorative Gold Border */
    .poster-border {
        position: absolute;
        inset: 0;
        border: 3px solid transparent;
        border-image: linear-gradient(
            135deg,
            rgba(218, 165, 32, 0.8) 0%,
            rgba(255, 215, 0, 0.6) 25%,
            rgba(218, 165, 32, 0.5) 50%,
            rgba(255, 215, 0, 0.6) 75%,
            rgba(218, 165, 32, 0.8) 100%
        ) 1;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .cinema-poster:hover .poster-border {
        opacity: 1;
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
