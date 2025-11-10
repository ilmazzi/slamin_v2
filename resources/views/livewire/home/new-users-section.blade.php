<div>
    @php
    $newUsers = \App\Models\User::latest()->limit(4)->get();
    @endphp
    
    @if($newUsers && $newUsers->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8"
         x-data="{
             currentPage: 0,
             itemsPerPage: window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 768 ? 2 : 1),
             totalItems: {{ $newUsers->count() }},
             get totalPages() {
                 return Math.ceil(this.totalItems / this.itemsPerPage);
             },
             next() {
                 if (this.currentPage < this.totalPages - 1) {
                     this.currentPage++;
                 }
             },
             prev() {
                 if (this.currentPage > 0) {
                     this.currentPage--;
                 }
             }
         }"
         x-init="
             window.addEventListener('resize', () => {
                 itemsPerPage = window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 768 ? 2 : 1);
                 if (currentPage >= totalPages) currentPage = totalPages - 1;
             });
         ">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-10 section-title-fade">
            <div class="flex-1">
                <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 2px 2px 4px rgba(255,255,255,0.8);">
                    {!! __('home.new_users_title') !!}
                </h2>
                <p class="text-lg text-neutral-800 dark:text-neutral-300 font-medium" style="text-shadow: 1px 1px 2px rgba(255,255,255,0.6);">
                    {{ __('home.new_users_subtitle') }}
                </p>
            </div>

            <!-- Slider Controls (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <button @click="prev()" 
                        :disabled="currentPage === 0"
                        :class="currentPage === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-neutral-200 dark:hover:bg-neutral-700'"
                        class="p-3 rounded-full bg-neutral-100/80 dark:bg-neutral-800/80 backdrop-blur-sm text-neutral-800 dark:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="next()" 
                        :disabled="currentPage === totalPages - 1"
                        :class="currentPage === totalPages - 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-neutral-200 dark:hover:bg-neutral-700'"
                        class="p-3 rounded-full bg-neutral-100/80 dark:bg-neutral-800/80 backdrop-blur-sm text-neutral-800 dark:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Polaroid Slider --}}
        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out pt-8 pb-4"
                 :style="`transform: translateX(-${currentPage * 100}%)`">
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
            <div class="w-full md:w-1/2 lg:w-1/4 flex-shrink-0 polaroid-wrapper fade-scale-item px-3 md:px-5 lg:px-6" 
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
        </div>

        <!-- Page Indicators (Mobile) -->
        <div class="flex md:hidden justify-center items-center gap-2 mt-8">
            <template x-for="i in totalPages" :key="i">
                <button @click="currentPage = i - 1"
                        :class="currentPage === i - 1 ? 'bg-neutral-800 dark:bg-white w-8' : 'bg-neutral-300 dark:bg-neutral-600 w-2'"
                        class="h-2 rounded-full transition-all duration-300">
                </button>
            </template>
        </div>

        {{-- CTA Button (route will be added later) --}}
        <div class="text-center mt-12">
            <div class="inline-flex items-center gap-2 px-8 py-4 bg-primary-600 hover:bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-500 text-white rounded-lg font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-primary-500/50 hover:scale-105 cursor-pointer">
                {{ __('home.all_users_button') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </div>
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
        
        /* Washi Tape on top - COLORFUL WITH SERRATED EDGES */
        .polaroid-tape {
            position: absolute;
            top: 8px;
            left: 50%;
            /* Width and background colors set inline (random) */
            height: 28px;
            box-shadow: 
                0 3px 8px rgba(0, 0, 0, 0.35),
                0 1px 4px rgba(0, 0, 0, 0.25),
                inset 0 2px 5px rgba(255, 255, 255, 0.9),
                inset 0 -1px 3px rgba(0, 0, 0, 0.2);
            z-index: 10;
            border-top: 1px solid rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            /* SERRATED EDGES */
            clip-path: polygon(
                0% 0%, 2% 5%, 0% 10%, 2% 15%, 0% 20%, 2% 25%, 0% 30%, 2% 35%, 
                0% 40%, 2% 45%, 0% 50%, 2% 55%, 0% 60%, 2% 65%, 0% 70%, 2% 75%, 
                0% 80%, 2% 85%, 0% 90%, 2% 95%, 0% 100%,
                100% 100%,
                98% 95%, 100% 90%, 98% 85%, 100% 80%, 98% 75%, 100% 70%, 98% 65%, 
                100% 60%, 98% 55%, 100% 50%, 98% 45%, 100% 40%, 98% 35%, 100% 30%, 
                98% 25%, 100% 20%, 98% 15%, 100% 10%, 98% 5%, 100% 0%
            );
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
            cursor: pointer;
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
            top: -4px;
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
