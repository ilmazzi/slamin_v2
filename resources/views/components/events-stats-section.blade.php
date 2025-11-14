@props(['statistics'])

<div class="events-stats-section" 
     x-data="{ scrollY: 0 }"
     @scroll.window="scrollY = window.scrollY">
    <div class="max-w-[95rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="events-stats-grid">
            @foreach([
                ['label' => 'total_events', 'value' => $statistics['total_events'], 'icon' => 'calendar', 'gradient' => 'from-primary-400 to-primary-600', 'delay' => 0],
                ['label' => 'public_events', 'value' => $statistics['public_events'], 'icon' => 'globe', 'gradient' => 'from-accent-400 to-accent-600', 'delay' => 100],
                ['label' => 'upcoming_events', 'value' => $statistics['upcoming_events'], 'icon' => 'clock', 'gradient' => 'from-primary-500 to-accent-500', 'delay' => 200],
                ['label' => 'venues_count', 'value' => $statistics['venues_count'], 'icon' => 'map-pin', 'gradient' => 'from-accent-500 to-primary-600', 'delay' => 300]
            ] as $stat)
            <div class="events-stat-card"
                 x-data="{ count: 0, target: {{ $stat['value'] }}, visible: false }"
                 x-init="setTimeout(() => { visible = true; let duration = 2000; let increment = target / (duration / 16); let timer = setInterval(() => { count += increment; if (count >= target) { count = target; clearInterval(timer); } }, 16); }, {{ $stat['delay'] }})"
                 x-show="visible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-50 -translate-y-10"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 :style="`transform: translateY(${scrollY * 0.03}px)`">
                
                <div class="events-stat-content">
                    <div class="events-stat-icon" style="background: linear-gradient(135deg, var(--tw-gradient-stops)); --tw-gradient-from: {{ str_replace('from-', '', $stat['gradient']) }}; --tw-gradient-to: {{ str_replace('to-', '', $stat['gradient']) }};">
                        @if($stat['icon'] === 'calendar')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @elseif($stat['icon'] === 'globe')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @elseif($stat['icon'] === 'clock')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @elseif($stat['icon'] === 'map-pin')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        @endif
                    </div>
                    
                    <div class="events-stat-number">
                        <span class="events-stat-value bg-gradient-to-br {{ $stat['gradient'] }} bg-clip-text text-transparent"
                              x-text="Math.floor(count).toLocaleString()">0</span>
                    </div>
                    
                    <div class="events-stat-label">
                        {{ __('events.' . $stat['label']) }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

