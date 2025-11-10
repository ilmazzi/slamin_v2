<div>
    @php
    $newUsers = \App\Models\User::latest()->limit(6)->get();
    @endphp
    
    @if($newUsers && $newUsers->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                {!! __('home.new_users_title') !!}
            </h2>
            <p class="text-lg text-neutral-200">
                {{ __('home.new_users_subtitle') }}
            </p>
        </div>

        {{-- Polaroid Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 md:gap-10 pt-8 pb-4">
            @foreach($newUsers as $i => $user)
            <?php
                // Random rotation for each polaroid
                $rotation = rand(-4, 4);
                $tapeRotation = rand(-8, 8);
                $tapeColor = ['rgba(255, 230, 100, 0.9)', 'rgba(200, 200, 200, 0.85)', 'rgba(255, 200, 100, 0.88)'][rand(0, 2)];
            ?>
            <div class="polaroid-wrapper" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Tape on top --}}
                <div class="polaroid-tape" 
                     style="background: {{ $tapeColor }}; transform: rotate({{ $tapeRotation }}deg);"></div>
                
                {{-- Polaroid Card --}}
                <a href="{{ route('profile.show', $user) }}" 
                   class="polaroid-card"
                   style="transform: rotate({{ $rotation }}deg);">
                    
                    {{-- Photo --}}
                    <div class="polaroid-photo">
                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($user, 200) }}" 
                             alt="{{ $user->name }}"
                             class="polaroid-img">
                    </div>
                    
                    {{-- Caption (handwritten style) --}}
                    <div class="polaroid-caption">
                        <div class="polaroid-name">{{ Str::limit($user->name, 20) }}</div>
                        <div class="polaroid-info">
                            {{ $user->poems()->count() }} {{ $user->poems()->count() === 1 ? 'poesia' : 'poesie' }}
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{-- CTA Button --}}
        <div class="text-center mt-12">
            <a href="{{ route('users.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-primary-600 hover:bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-500 text-white rounded-lg font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-primary-500/50 hover:scale-105">
                {{ __('Scopri la Community') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.6s ease-out forwards; opacity: 0; }
        
        /* ============================================
           POLAROID WALL
           ============================================ */
        
        .polaroid-wrapper {
            position: relative;
            padding-top: 20px;
        }
        
        /* Tape on top (random colors) */
        .polaroid-tape {
            position: absolute;
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 18px;
            z-index: 10;
            opacity: 0.85;
            box-shadow: 
                0 1px 2px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Polaroid Card */
        .polaroid-card {
            display: block;
            background: #ffffff;
            padding: 12px 12px 14px 12px;
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.12),
                0 8px 16px rgba(0, 0, 0, 0.08),
                0 12px 24px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            position: relative;
        }
        
        :is(.dark .polaroid-card) {
            background: #f8f8f8;
        }
        
        /* Hover effect - lift polaroid + tape */
        .polaroid-wrapper:hover .polaroid-card {
            transform: translateY(-12px) scale(1.05) !important;
            box-shadow: 
                0 16px 28px rgba(0, 0, 0, 0.18),
                0 24px 40px rgba(0, 0, 0, 0.12),
                0 32px 56px rgba(0, 0, 0, 0.08);
        }
        
        .polaroid-wrapper:hover .polaroid-tape {
            transform: translateX(-50%) translateY(-12px);
        }
        
        /* Photo area - square */
        .polaroid-photo {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            background: #f0f0f0;
            margin-bottom: 12px;
        }
        
        .polaroid-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .polaroid-wrapper:hover .polaroid-img {
            transform: scale(1.08);
        }
        
        /* Caption area - white space below photo */
        .polaroid-caption {
            text-align: center;
            padding: 0.5rem 0.25rem;
        }
        
        .polaroid-name {
            font-family: 'Crimson Pro', serif;
            font-size: 0.875rem;
            font-weight: 600;
            color: #2d2d2d;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }
        
        .polaroid-info {
            font-family: 'Crimson Pro', serif;
            font-size: 0.75rem;
            color: #666;
            font-style: italic;
        }
    </style>
    @endif
</div>
