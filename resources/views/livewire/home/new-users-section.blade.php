<div>
    @php
    $newUsers = \App\Models\User::latest()->limit(4)->get();
    @endphp
    
    @if($newUsers && $newUsers->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 2px 2px 4px rgba(255,255,255,0.8);">
                {!! __('home.new_users_title') !!}
            </h2>
            <p class="text-lg text-neutral-800 dark:text-neutral-300 font-medium" style="text-shadow: 1px 1px 2px rgba(255,255,255,0.6);">
                {{ __('home.new_users_subtitle') }}
            </p>
        </div>

        {{-- Polaroid Wall - Native Horizontal Scroll --}}
        <div class="flex gap-6 md:gap-10 lg:gap-12 overflow-x-auto pb-4 pt-8 scrollbar-hide snap-x snap-mandatory"
             style="-webkit-overflow-scrolling: touch;">
            @foreach($newUsers as $i => $user)
            <?php
                // Random rotation for each polaroid
                $rotation = rand(-3, 3);
                $tapeRotation = rand(-8, 8);
                $tapeWidth = rand(70, 100);
                // Random tape colors - VIVID/BRIGHT
                $tapeColors = [
                    // Bright Yellow
                    ['rgba(255, 220, 0, 0.95)', 'rgba(255, 230, 50, 0.93)', 'rgba(255, 240, 100, 0.95)'],
                    // Hot Pink
                    ['rgba(255, 105, 180, 0.92)', 'rgba(255, 130, 200, 0.90)', 'rgba(255, 150, 215, 0.92)'],
                    // Electric Blue
                    ['rgba(0, 150, 255, 0.90)', 'rgba(50, 170, 255, 0.88)', 'rgba(100, 190, 255, 0.90)'],
                    // Lime Green
                    ['rgba(50, 255, 50, 0.88)', 'rgba(80, 255, 80, 0.86)', 'rgba(110, 255, 110, 0.88)'],
                    // Purple
                    ['rgba(180, 100, 255, 0.90)', 'rgba(190, 130, 255, 0.88)', 'rgba(200, 160, 255, 0.90)'],
                    // Orange
                    ['rgba(255, 140, 0, 0.92)', 'rgba(255, 160, 50, 0.90)', 'rgba(255, 180, 100, 0.92)'],
                ];
                $selectedTape = $tapeColors[array_rand($tapeColors)];
            ?>
            <div class="w-[85vw] md:w-[calc(50%-1.25rem)] lg:w-[calc(25%-2.25rem)] flex-shrink-0 polaroid-wrapper fade-scale-item snap-center" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Colorful Washi Tape on top --}}
                <div class="polaroid-tape tape-{{ $i }}" 
                     style="width: {{ $tapeWidth }}px; 
                            --tape-rotation: {{ $tapeRotation }}deg; 
                            transform: translateX(-50%) rotate({{ $tapeRotation }}deg);
                            background: 
                                linear-gradient(105deg, rgba(255, 255, 255, 0.25) 0%, transparent 30%, transparent 70%, rgba(255, 255, 255, 0.25) 100%),
                                linear-gradient(180deg, {{ $selectedTape[0] }} 0%, {{ $selectedTape[1] }} 50%, {{ $selectedTape[2] }} 100%);"></div>
                
                {{-- Polaroid Card (link will be added when profile.show route exists) --}}
                <div class="polaroid-card"
                     style="transform: rotate({{ $rotation }}deg);">
                    
                    {{-- Photo --}}
                    <div class="polaroid-photo">
                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($user, 400) }}" 
                             alt="{{ $user->name }}"
                             class="polaroid-img">
                    </div>
                    
                    {{-- Caption with MORE INFO --}}
                    <div class="polaroid-caption">
                        <div class="polaroid-name">{{ $user->name }}</div>
                        
                        {{-- Stats Grid --}}
                        <div class="polaroid-stats">
                            <div class="polaroid-stat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span>{{ $user->poems()->count() }}</span>
                            </div>
                            <div class="polaroid-stat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <span>{{ $user->articles()->count() }}</span>
                            </div>
                        </div>
                        
                        {{-- Member Since --}}
                        <div class="polaroid-date">
                            Membro da {{ $user->created_at->locale('it')->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA Button (route will be added later) --}}
        <div class="text-center mt-12">
            {{-- TODO: Add route('users.index') when available --}}
            <div class="inline-flex items-center gap-2 px-8 py-4 bg-primary-600 hover:bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-500 text-white rounded-lg font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-primary-500/50 hover:scale-105 cursor-pointer">
                {{ __('home.all_users_button') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </div>
    </div>
    @endif
</div>
