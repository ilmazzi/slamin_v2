<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900">
    
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
            <div class="scoring-alert bg-gradient-to-br from-[rgba(34,197,94,0.1)] to-[rgba(22,163,74,0.05)] dark:from-[rgba(34,197,94,0.2)] dark:to-[rgba(22,163,74,0.15)] border-[rgba(34,197,94,0.3)] dark:border-[rgba(34,197,94,0.4)] text-[#16a34a] dark:text-[#4ade80]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-24 right-6 z-50"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0 translate-x-full">
            <div class="scoring-alert bg-gradient-to-br from-[rgba(185,28,28,0.1)] to-[rgba(220,38,38,0.05)] dark:from-[rgba(139,115,85,0.2)] dark:to-[rgba(166,139,91,0.15)] border-[rgba(185,28,28,0.3)] dark:border-[rgba(139,115,85,0.4)] text-[#b91c1c] dark:text-[#8b7355]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Elegant Header with Ticket Styles --}}
    <?php 
        $selectedColors = [
            ['#fefaf3', '#fdf8f0', '#faf5ec'],
            ['#fef9f1', '#fdf7ef', '#faf4ea'],
            ['#fffbf5', '#fef9f3', '#fdf7f1']
        ][rand(0, 2)];
        $selectedColorsDark = [
            ['#1a1a1a', '#2d2d2d', '#1f1f1f'],
            ['#1f1f1f', '#2d2d2d', '#262626'],
            ['#1a1a1a', '#262626', '#1f1f1f']
        ][rand(0, 2)];
    ?>
    <div class="relative py-4 overflow-hidden bg-gradient-to-br from-[#fefaf3] via-[#fdf8f0] to-[#faf5ec] dark:from-[#1a1a1a] dark:via-[#2d2d2d] dark:to-[#1f1f1f]"
         x-data="{ 
             lightColors: {{ json_encode($selectedColors) }},
             darkColors: {{ json_encode($selectedColorsDark) }},
             get bgStyle() { 
                 return document.documentElement.classList.contains('dark') 
                     ? `linear-gradient(135deg, ${this.darkColors[0]} 0%, ${this.darkColors[1]} 50%, ${this.darkColors[2]} 100%)`
                     : `linear-gradient(135deg, ${this.lightColors[0]} 0%, ${this.lightColors[1]} 50%, ${this.lightColors[2]} 100%)`;
             }
         }"
         x-bind:style="{ background: bgStyle }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center justify-between mb-2 pb-2 border-b-2 border-dashed border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                        <div class="text-xs font-black tracking-widest uppercase text-[#b91c1c] dark:text-[#8b7355]" style="letter-spacing: 0.1em;">{{ strtoupper(__('events.scoring.rankings')) }}</div>
                        <div class="text-xs font-bold text-[#8b7355] dark:text-[#a3a3a3]" style="font-family: 'Courier New', monospace;">#{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <h1 class="text-xl md:text-2xl font-bold mb-3 text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $event->title }}</h1>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.participants') }}</div>
                            <div class="text-sm font-semibold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ $stats['total_participants'] }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.with_scores') }}</div>
                            <div class="text-sm font-semibold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ $stats['with_scores'] }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.badges_awarded') }}</div>
                            <div class="text-sm font-semibold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ $stats['badges_awarded'] }}</div>
                        </div>
                        @if($event->status === \App\Models\Event::STATUS_COMPLETED)
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.status') }}</div>
                            <div class="text-sm font-semibold text-[#16a34a] dark:text-[#4ade80]" style="font-family: 'Crimson Pro', serif;">{{ __('events.scoring.completed') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="relative py-8">
        <div class="max-w-6xl mx-auto px-6">
            
            {{-- Navigation --}}
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('events.scoring.scores', $event) }}" wire:navigate class="scoring-nav-button">
                    <i class="ph ph-pencil-line"></i>
                    {{ __('events.scoring.scores') }}
                </a>
                <a href="{{ route('events.scoring.participants', $event) }}" wire:navigate class="scoring-nav-button">
                    <i class="ph ph-users"></i>
                    {{ __('events.scoring.participants') }}
                </a>
                <a href="{{ route('events.scoring.rankings', $event) }}" wire:navigate class="scoring-nav-button scoring-nav-active">
                    <i class="ph ph-ranking"></i>
                    {{ __('events.scoring.rankings') }}
                </a>
            </div>

            {{-- Actions Section --}}
            @if($event->status !== \App\Models\Event::STATUS_COMPLETED)
            <div class="mb-6">
                <div class="scoring-card">
                    <div class="scoring-card-content">
                    {{-- Stats --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="scoring-stat-card" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%); border-color: rgba(59, 130, 246, 0.3);">
                            <div class="text-2xl font-bold mb-1" style="color: #2563eb; font-family: 'Crimson Pro', serif;">{{ $stats['with_scores'] }}/{{ $stats['total_participants'] }}</div>
                            <div class="text-xs font-bold uppercase" style="color: #8b7355; letter-spacing: 0.05em;">{{ __('events.scoring.with_scores') }}</div>
                        </div>
                        <div class="scoring-stat-card" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(22, 163, 74, 0.05) 100%); border-color: rgba(34, 197, 94, 0.3);">
                            <div class="text-2xl font-bold mb-1" style="color: #16a34a; font-family: 'Crimson Pro', serif;">{{ $stats['badges_awarded'] }}</div>
                            <div class="text-xs font-bold uppercase" style="color: #8b7355; letter-spacing: 0.05em;">{{ __('events.scoring.badges_awarded') }}</div>
                        </div>
                    </div>

                    {{-- Action Buttons Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($canCalculate)
                        <div class="scoring-action-card bg-gradient-to-br from-[rgba(234,179,8,0.1)] to-[rgba(202,138,4,0.05)] dark:from-[rgba(234,179,8,0.2)] dark:to-[rgba(202,138,4,0.15)] border-[rgba(234,179,8,0.3)] dark:border-[rgba(234,179,8,0.4)]">
                            <div class="text-3xl mb-2">🧮</div>
                            <h4 class="text-base font-bold mb-1 text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ __('events.scoring.calculate_partial_rankings') }}</h4>
                            <p class="text-xs mb-3 text-[#8b7355] dark:text-[#a3a3a3]">{{ __('events.scoring.update_rankings_without_closing_event') }}</p>
                            <button wire:click="calculatePartialRankings" class="scoring-button-secondary w-full">
                                {{ __('events.scoring.calculate_partial_rankings') }}
                            </button>
                        </div>
                    @endif

                    @if($canCalculate && $stats['with_scores'] > 0)
                        <div class="scoring-action-card bg-gradient-to-br from-[rgba(34,197,94,0.1)] to-[rgba(22,163,74,0.05)] dark:from-[rgba(34,197,94,0.2)] dark:to-[rgba(22,163,74,0.15)] border-[rgba(34,197,94,0.3)] dark:border-[rgba(34,197,94,0.4)]">
                            <div class="text-3xl mb-2">🏆</div>
                            <h4 class="text-base font-bold mb-1 text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ __('events.scoring.finalize_event') }}</h4>
                            <p class="text-xs mb-3 text-[#8b7355] dark:text-[#a3a3a3]">{{ __('events.scoring.this_action_will_complete_the_event') }}</p>
                            <button onclick="confirmFinalize()" class="scoring-button-primary w-full">
                                {{ __('events.scoring.terminate_event') }}
                            </button>
                        </div>
                    @endif
                    </div>

                    @if(!$canCalculate || $stats['with_scores'] === 0)
                        <div class="mt-6 scoring-alert scoring-alert-info">
                            <p class="text-sm flex items-center gap-2" style="font-family: 'Crimson Pro', serif;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('events.scoring.insert_scores_before_generating_rankings') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
                    @else
                    {{-- Event Completed Banner --}}
                    <div class="mb-6 scoring-alert scoring-alert-info" style="padding: 0.75rem 1rem;">
                        <p class="text-sm flex items-center gap-2" style="font-family: 'Crimson Pro', serif; margin: 0;">
                            <span>🎊</span>
                            <strong>{{ __('events.scoring.event_completed') }}</strong> - {{ __('events.scoring.final_rankings_published') }}
                        </p>
                    </div>
                    @endif

            {{-- Rankings Section --}}
            <div>
                <div class="text-xs font-black tracking-[0.3em] mb-4 uppercase text-[#b91c1c] dark:text-[#8b7355]" style="letter-spacing: 0.3em;">{{ __('events.scoring.final_rankings') }}</div>
                
                @if($rankings->count() > 0)
                    {{-- Podium for Top 3 --}}
                    @if($rankings->where('position', '<=', 3)->count() > 0)
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        @php
                            $topThree = $rankings->where('position', '<=', 3)->sortBy('position');
                            $second = $topThree->where('position', 2)->first();
                            $first = $topThree->where('position', 1)->first();
                            $third = $topThree->where('position', 3)->first();
                        @endphp
                        
                        {{-- 2nd Place --}}
                        @if($second)
                        <div class="order-2 md:order-1 text-center">
                            <div class="rounded-t-lg p-4 mb-3 h-36 flex flex-col items-center justify-end shadow bg-gradient-to-br from-[#fefaf3] via-[#fdf8f0] to-[#faf5ec] dark:from-[#1a1a1a] dark:via-[#2d2d2d] dark:to-[#1f1f1f] border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)] border-b-0">
                                <div class="text-3xl mb-1">🥈</div>
                                @if($second->participant && $second->participant->user)
                                    <img src="{{ $second->participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                         alt="{{ $second->participant->display_name }}"
                                         class="w-12 h-12 rounded-full object-cover border-2 mb-1 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                @endif
                                <div class="font-bold text-xs truncate w-full text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $second->participant->display_name ?? '-' }}</div>
                                <div class="text-lg font-bold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ number_format($second->total_score, 1) }}</div>
                            </div>
                            <div class="rounded-b-lg p-2 bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)] border-t-0">
                                <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="font-family: 'Crimson Pro', serif;">2°</div>
                                @if($second->badge)
                                    <img src="{{ $second->badge->icon_url }}" alt="{{ $second->badge->name }}" class="w-6 h-6 mx-auto object-contain">
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- 1st Place --}}
                        @if($first)
                        <div class="order-1 md:order-2 text-center">
                            <div class="rounded-t-lg p-5 mb-3 h-44 flex flex-col items-center justify-end shadow-lg bg-gradient-to-br from-[#a8d5ba] to-[#7fc49e] dark:from-[#166534] dark:to-[#15803d] border-2 border-[rgba(34,197,94,0.3)] dark:border-[rgba(34,197,94,0.5)] border-b-0">
                                <div class="text-4xl mb-2">🥇</div>
                                @if($first->participant && $first->participant->user)
                                    <img src="{{ $first->participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                         alt="{{ $first->participant->display_name }}"
                                         class="w-16 h-16 rounded-full object-cover border-2 mb-2 shadow border-[rgba(34,197,94,0.3)] dark:border-[rgba(34,197,94,0.5)]">
                                @endif
                                <div class="font-bold text-sm truncate w-full mb-1 text-[#1a1a1a] dark:text-white" style="font-family: 'Crimson Pro', serif;">{{ $first->participant->display_name ?? '-' }}</div>
                                <div class="text-2xl font-bold text-[#15803d] dark:text-[#86efac]" style="font-family: 'Crimson Pro', serif;">{{ number_format($first->total_score, 1) }}</div>
                            </div>
                            <div class="rounded-b-lg p-2 bg-gradient-to-br from-[rgba(168,213,186,0.4)] to-[rgba(127,196,158,0.3)] dark:from-[rgba(22,101,52,0.4)] dark:to-[rgba(21,128,61,0.3)] border-2 border-[rgba(34,197,94,0.3)] dark:border-[rgba(34,197,94,0.5)] border-t-0">
                                <div class="text-xs font-bold uppercase mb-1 text-[#15803d] dark:text-[#86efac]" style="font-family: 'Crimson Pro', serif;">1°</div>
                                @if($first->badge)
                                    <img src="{{ $first->badge->icon_url }}" alt="{{ $first->badge->name }}" class="w-8 h-8 mx-auto object-contain">
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- 3rd Place --}}
                        @if($third)
                        <div class="order-3 text-center">
                            <div class="rounded-t-lg p-4 mb-3 h-32 flex flex-col items-center justify-end shadow bg-gradient-to-br from-[#fefaf3] via-[#fdf8f0] to-[#faf5ec] dark:from-[#1a1a1a] dark:via-[#2d2d2d] dark:to-[#1f1f1f] border-2 border-[rgba(139,115,85,0.5)] dark:border-[rgba(139,115,85,0.6)] border-b-0">
                                <div class="text-2xl mb-1">🥉</div>
                                @if($third->participant && $third->participant->user)
                                    <img src="{{ $third->participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                         alt="{{ $third->participant->display_name }}"
                                         class="w-12 h-12 rounded-full object-cover border-2 mb-1 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                @endif
                                <div class="font-bold text-xs truncate w-full text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $third->participant->display_name ?? '-' }}</div>
                                <div class="text-lg font-bold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ number_format($third->total_score, 1) }}</div>
                            </div>
                            <div class="rounded-b-lg p-2 bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-2 border-[rgba(139,115,85,0.5)] dark:border-[rgba(139,115,85,0.6)] border-t-0">
                                <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="font-family: 'Crimson Pro', serif;">3°</div>
                                @if($third->badge)
                                    <img src="{{ $third->badge->icon_url }}" alt="{{ $third->badge->name }}" class="w-6 h-6 mx-auto object-contain">
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- Full Rankings Table --}}
                    <div class="scoring-card">
                        <div class="scoring-card-header">
                            <h2 class="scoring-card-title">
                                <i class="ph-duotone ph-ranking"></i>
                                {{ __('events.scoring.complete_rankings') }}
                            </h2>
                        </div>

                        <div class="scoring-card-content">
                            {{-- Mobile View --}}
                            <div class="block md:hidden space-y-4">
                                @foreach($rankings as $ranking)
                                    @if($ranking->position > 3)
                                    <div class="scoring-participant-card border-l-4 border-l-[rgba(139,115,85,0.3)] dark:border-l-[rgba(139,115,85,0.4)]">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)] text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">
                                                    {{ $ranking->position }}
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-2">
                                                    @if($ranking->participant && $ranking->participant->user)
                                                        <img src="{{ $ranking->participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                                             alt="{{ $ranking->participant->display_name }}"
                                                             class="w-10 h-10 rounded-full object-cover border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                                    @endif
                                                    <div class="font-bold truncate text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $ranking->participant->display_name ?? '-' }}</div>
                                                </div>
                                                <div class="flex flex-wrap gap-2">
                                                    <span class="scoring-badge bg-gradient-to-br from-[rgba(185,28,28,0.1)] to-[rgba(220,38,38,0.05)] dark:from-[rgba(139,115,85,0.2)] dark:to-[rgba(166,139,91,0.15)] border-[rgba(185,28,28,0.3)] dark:border-[rgba(139,115,85,0.4)] text-[#b91c1c] dark:text-[#8b7355]">
                                                        {{ number_format($ranking->total_score, 1) }} {{ __('events.scoring.points') }}
                                                    </span>
                                                    @if($ranking->badge)
                                                        <span class="scoring-badge {{ $ranking->badge_awarded ? 'scoring-badge-confirmed' : 'bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)] text-[#8b7355] dark:text-[#a3a3a3]' }}">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                                            </svg>
                                                            {{ $ranking->badge->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Desktop Table --}}
                            <div class="hidden md:block overflow-x-auto">
                                <table class="scoring-table">
                                    <thead>
                                        <tr>
                                            <th class="w-20">{{ __('events.scoring.position') }}</th>
                                            <th>{{ __('events.scoring.participant_name') }}</th>
                                            <th>{{ __('events.scoring.round_scores') }}</th>
                                            <th class="w-32">{{ __('events.scoring.total_score') }}</th>
                                            <th>{{ __('events.scoring.badge') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rankings as $ranking)
                                            <tr class="{{ $ranking->position <= 3 ? 'bg-gradient-to-r from-[rgba(254,250,243,0.3)] to-[rgba(253,248,240,0.3)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)]' : '' }}">
                                                <td>
                                                    <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg {{ $ranking->position <= 3 ? ($ranking->position == 1 ? 'bg-gradient-to-br from-[#a8d5ba] to-[#7fc49e] dark:from-[#166534] dark:to-[#15803d] border-2 border-[rgba(34,197,94,0.3)] dark:border-[rgba(34,197,94,0.5)] text-[#15803d] dark:text-[#86efac]' : 'bg-gradient-to-br from-[#b91c1c] to-[#dc2626] dark:from-[#8b7355] dark:to-[#a68b5b] border-2 border-[#b91c1c] dark:border-[#8b7355] text-white') : 'bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)] text-[#1a1a1a] dark:text-[#e5e5e5]' }}" style="font-family: 'Crimson Pro', serif;">
                                                        {{ $ranking->medal ?: $ranking->position }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($ranking->participant)
                                                        <div class="flex items-center gap-3">
                                                            @if($ranking->participant->user)
                                                                <img src="{{ $ranking->participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                                                     alt="{{ $ranking->participant->display_name }}"
                                                                     class="w-12 h-12 rounded-full object-cover border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                                            @else
                                                                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                                                    <svg class="w-6 h-6 text-[#8b7355] dark:text-[#a3a3a3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <div class="font-bold text-sm text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $ranking->participant->display_name }}</div>
                                                                @if($ranking->participant->isGuest())
                                                                    <span class="scoring-badge scoring-badge-pending">{{ __('events.scoring.guest') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($ranking->round_scores)
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach($ranking->round_scores as $round => $score)
                                                                <span class="scoring-badge bg-gradient-to-br from-[rgba(59,130,246,0.1)] to-[rgba(37,99,235,0.05)] dark:from-[rgba(59,130,246,0.2)] dark:to-[rgba(37,99,235,0.15)] border-[rgba(59,130,246,0.3)] dark:border-[rgba(59,130,246,0.4)] text-[#2563eb] dark:text-[#60a5fa]">
                                                                    T{{ $round }}: {{ number_format($score, 1) }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="scoring-badge bg-gradient-to-r from-[#b91c1c] to-[#dc2626] dark:from-[#8b7355] dark:to-[#a68b5b] border-[#b91c1c] dark:border-[#8b7355] text-white text-base px-4 py-2">
                                                        {{ number_format($ranking->total_score, 1) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($ranking->badge)
                                                        <div class="flex items-center gap-3">
                                                            <img src="{{ $ranking->badge->icon_url }}" 
                                                                 alt="{{ $ranking->badge->name }}"
                                                                 class="w-10 h-10 object-contain">
                                                            <div>
                                                                <div class="font-bold text-sm text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $ranking->badge->name }}</div>
                                                                @if($ranking->badge_awarded)
                                                                    <span class="scoring-badge scoring-badge-confirmed">{{ __('events.scoring.assigned') }}</span>
                                                                @else
                                                                    <span class="scoring-badge bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)] text-[#8b7355] dark:text-[#a3a3a3]">{{ __('events.scoring.to_assign') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="scoring-card">
                        <div class="scoring-card-content text-center">
                            <div class="text-5xl mb-4">📊</div>
                            <h3 class="text-lg font-bold mb-2 text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ __('gamification.no_rankings') }}</h3>
                            
                            @if($canCalculate)
                                <p class="mb-4 text-sm text-[#8b7355] dark:text-[#a3a3a3]">{{ __('events.scoring.you_have_participants_with_scores') }}</p>
                                <button wire:click="calculatePartialRankings" class="scoring-button-secondary">
                                    {{ __('events.scoring.calculate_partial_rankings') }}
                                </button>
                            @else
                                <p class="mb-4 text-sm text-[#8b7355] dark:text-[#a3a3a3]">{{ __('events.scoring.insert_scores_before_generating_rankings') }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>



    @push('scripts')
    <script>
        function confirmFinalize() {
            if (confirm('{{ __('events.scoring.confirm_finalize_event') }}\n\n{{ __('events.scoring.this_action_will_complete_the_event') }}\n- {{ __('events.scoring.calculate_final_rankings') }}\n- {{ __('events.scoring.assign_badges_to_winners') }}\n- {{ __('events.scoring.close_event') }}\n- {{ __('events.scoring.publish_results') }}\n\n{{ __('events.scoring.warning') }}: {{ __('events.scoring.you_will_not_be_able_to_modify_scores') }}')) {
                @this.call('finalizeEvent');
            }
        }
    </script>
    @endpush
</div>

