<div>
    @if ($topGigs && $topGigs->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8"
         x-data="{
             currentPage: 0,
             itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
             totalItems: {{ $topGigs->count() }},
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
                 itemsPerPage = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
                 if (currentPage >= totalPages) currentPage = totalPages - 1;
             });
         ">
        
        <!-- Header con Navigation -->
        <div class="flex items-center justify-between mb-10">
            <div class="flex-1">
                <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                    {!! __('home.gigs_section_title') !!}
                </h2>
                <p class="text-lg text-neutral-100">
                    {{ __('home.gigs_section_subtitle') }}
                </p>
            </div>

            <!-- Slider Controls (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <button @click="prev()" 
                        :disabled="currentPage === 0"
                        :class="currentPage === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-white/20'"
                        class="w-12 h-12 rounded-full border-2 border-white/60 flex items-center justify-center text-white transition-all backdrop-blur-sm bg-black/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <span class="text-sm text-white font-medium min-w-[60px] text-center backdrop-blur-sm bg-black/20 px-3 py-1 rounded-full">
                    <span x-text="currentPage + 1"></span> / <span x-text="totalPages"></span>
                </span>
                <button @click="next()" 
                        :disabled="currentPage >= totalPages - 1"
                        :class="currentPage >= totalPages - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-white/20'"
                        class="w-12 h-12 rounded-full border-2 border-white/60 flex items-center justify-center text-white transition-all backdrop-blur-sm bg-black/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Gigs Slider Container -->
        <div class="relative overflow-x-hidden -mx-3 px-3">
            <div class="flex transition-transform duration-500 ease-out pb-8"
                 :style="`transform: translateX(-${currentPage * 100}%)`">
                @foreach($topGigs as $i => $gig)
                <?php
                    // Random tape properties per card
                    $tapeWidth = rand(110, 150);
                    $tapeRotation = rand(-4, 4);
                    $tapeOffsetX = rand(-10, 10);
                    $tapeBottomRotation = rand(-4, 4);
                    $tapeBottomOffsetX = rand(-10, 10);
                ?>
                <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')"
                     style="animation-delay: {{ $i * 0.1 }}s">
                    
                    {{-- NOTICE BOARD CARD --}}
                    <a href="{{ route('gigs.show', $gig) }}" 
                       class="group block h-full notice-card">
                        
                        {{-- Washi tape at top (fully visible) --}}
                        <div class="washi-tape washi-top" 
                             style="width: {{ $tapeWidth }}px; transform: translate(calc(-50% + {{ $tapeOffsetX }}px), 0) rotate({{ $tapeRotation }}deg);"></div>
                        
                        {{-- Paper note --}}
                        <div class="notice-paper" style="transform: rotate({{ rand(-2, 2) }}deg);">
                            
                            {{-- Header section --}}
                            <div class="notice-header-section">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="notice-category-badge">
                                        {{ __('gigs.categories.' . $gig->category) }}
                                    </span>
                                    @if($gig->is_urgent)
                                        <span class="notice-urgent-flag">!! URGENTE !!</span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Title --}}
                            <h3 class="notice-title group-hover:text-accent-700 transition-colors">
                                {{ $gig->title }}
                            </h3>
                            
                            {{-- Description --}}
                            <p class="notice-description">
                                {{ Str::limit(strip_tags($gig->description), 100) }}
                            </p>
                            
                            {{-- Details with icons --}}
                            <div class="notice-details-list">
                                @if($gig->location)
                                    <div class="notice-detail-row">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $gig->location }}</span>
                                    </div>
                                @endif
                                
                                @if($gig->deadline)
                                    <div class="notice-detail-row">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Scadenza: {{ $gig->deadline->format('d M Y') }}</span>
                                    </div>
                                @endif
                                
                                @if($gig->compensation)
                                    <div class="notice-detail-row notice-compensation-row">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ Str::limit($gig->compensation, 35) }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Footer info --}}
                            <div class="notice-footer-bar">
                                <div class="notice-author">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $gig->user ? $gig->user->name : ($gig->requester ? $gig->requester->name : 'Organizzatore') }}</span>
                                </div>
                                <div class="notice-applications-badge">
                                    {{ $gig->application_count }}@if($gig->max_applications)/{{ $gig->max_applications }}@endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Washi tape at bottom --}}
                        <div class="washi-tape washi-bottom" 
                             style="width: {{ $tapeWidth }}px; transform: translate(calc(-50% + {{ $tapeBottomOffsetX }}px), 0) rotate({{ $tapeBottomRotation }}deg);"></div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Dots Indicator (Mobile) -->
        <div class="flex md:hidden justify-center gap-2 mt-8">
            <template x-for="i in totalPages" :key="i">
                <button @click="currentPage = i - 1"
                        :class="currentPage === i - 1 ? 'bg-white w-8' : 'bg-white/40 w-3'"
                        class="h-3 rounded-full transition-all duration-300"></button>
            </template>
        </div>

        <!-- See All Button -->
        <div class="text-center mt-12">
            <a href="{{ route('gigs.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-white hover:bg-neutral-100 text-neutral-900 font-black uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105 border-4 border-neutral-900">
                <span>{{ __('home.see_all_gigs') }}</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; opacity: 0; }
        
        /* ==========================================
           NOTICE BOARD / BACHECA CARD
           ========================================== */
        
        .notice-card {
            position: relative;
            height: 100%;
            display: block;
        }
        
        .notice-paper {
            position: relative;
            height: 100%;
            background: 
                /* Paper texture */
                url("data:image/svg+xml,%3Csvg width='150' height='150' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.1' numOctaves='3' /%3E%3C/filter%3E%3Crect width='150' height='150' filter='url(%23paper)' opacity='0.08'/%3E%3C/svg%3E"),
                /* White/cream paper */
                linear-gradient(160deg, #fffef9 0%, #fffcf5 30%, #fefbef 70%, #fffef9 100%);
            padding: 1.75rem 1.5rem 1.5rem 1.5rem;
            box-shadow: 
                0 6px 18px rgba(0, 0, 0, 0.2),
                0 3px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        :is(.dark .notice-paper) {
            background: 
                url("data:image/svg+xml,%3Csvg width='150' height='150' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.1' numOctaves='3' /%3E%3C/filter%3E%3Crect width='150' height='150' filter='url(%23paper)' opacity='0.08'/%3E%3C/svg%3E"),
                linear-gradient(160deg, #3f3f3a 0%, #38382f 30%, #323229 70%, #3f3f3a 100%);
        }
        
        /* Scotch tape - FULLY VISIBLE, YELLOW, SERRATED EDGES */
        .washi-tape {
            position: absolute;
            left: 50%;
            /* Width is set inline per card (random) */
            height: 32px;
            background: 
                /* Strong glossy shine */
                linear-gradient(
                    100deg,
                    rgba(255, 255, 255, 0.85) 0%,
                    rgba(255, 255, 255, 0.5) 20%,
                    rgba(255, 255, 255, 0.15) 40%,
                    rgba(255, 255, 255, 0.08) 50%,
                    rgba(255, 255, 255, 0.15) 60%,
                    rgba(255, 255, 255, 0.5) 80%,
                    rgba(255, 255, 255, 0.85) 100%
                ),
                /* YELLOW scotch color */
                linear-gradient(180deg, 
                    rgba(255, 248, 180, 0.92) 0%, 
                    rgba(255, 245, 170, 0.88) 50%, 
                    rgba(255, 248, 180, 0.92) 100%
                );
            box-shadow: 
                /* Strong shadow for depth */
                0 3px 8px rgba(0, 0, 0, 0.35),
                0 1px 4px rgba(0, 0, 0, 0.25),
                /* Glossy highlights */
                inset 0 2px 5px rgba(255, 255, 255, 0.9),
                inset 0 -1px 3px rgba(0, 0, 0, 0.2);
            z-index: 5;
            border-top: 1px solid rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(200, 180, 100, 0.4);
            /* SERRATED EDGES (bordi seghettati) */
            clip-path: polygon(
                /* Left edge - serrated */
                0% 0%,
                2% 5%,
                0% 10%,
                2% 15%,
                0% 20%,
                2% 25%,
                0% 30%,
                2% 35%,
                0% 40%,
                2% 45%,
                0% 50%,
                2% 55%,
                0% 60%,
                2% 65%,
                0% 70%,
                2% 75%,
                0% 80%,
                2% 85%,
                0% 90%,
                2% 95%,
                0% 100%,
                /* Bottom */
                100% 100%,
                /* Right edge - serrated */
                98% 95%,
                100% 90%,
                98% 85%,
                100% 80%,
                98% 75%,
                100% 70%,
                98% 65%,
                100% 60%,
                98% 55%,
                100% 50%,
                98% 45%,
                100% 40%,
                98% 35%,
                100% 30%,
                98% 25%,
                100% 20%,
                98% 15%,
                100% 10%,
                98% 5%,
                100% 0%
            );
        }
        
        :is(.dark .washi-tape) {
            background: 
                linear-gradient(
                    100deg,
                    rgba(255, 255, 255, 0.4) 0%,
                    rgba(255, 255, 255, 0.25) 20%,
                    rgba(255, 255, 255, 0.1) 40%,
                    rgba(255, 255, 255, 0.05) 50%,
                    rgba(255, 255, 255, 0.1) 60%,
                    rgba(255, 255, 255, 0.25) 80%,
                    rgba(255, 255, 255, 0.4) 100%
                ),
                linear-gradient(180deg, 
                    rgba(220, 200, 120, 0.85) 0%, 
                    rgba(210, 190, 110, 0.8) 50%, 
                    rgba(220, 200, 120, 0.85) 100%
                );
            box-shadow: 
                0 3px 8px rgba(0, 0, 0, 0.6),
                0 1px 4px rgba(0, 0, 0, 0.5),
                inset 0 2px 5px rgba(255, 255, 255, 0.45),
                inset 0 -1px 3px rgba(0, 0, 0, 0.4);
        }
        
        .washi-top {
            top: 12px;
        }
        
        .washi-bottom {
            bottom: 12px;
        }
        
        /* Typography */
        .notice-category-badge {
            display: inline-block;
            font-size: 0.6875rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: white;
            background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .notice-urgent-flag {
            font-size: 0.625rem;
            font-weight: 900;
            color: #dc2626;
            transform: rotate(-3deg);
            animation: pulse 2s infinite;
        }
        
        .notice-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1c1917;
            margin-bottom: 0.75rem;
            line-height: 1.25;
        }
        
        :is(.dark .notice-title) {
            color: #f5f5f4;
        }
        
        .notice-description {
            font-size: 0.875rem;
            color: #57534e;
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }
        
        :is(.dark .notice-description) {
            color: #a8a29e;
        }
        
        /* Details list */
        .notice-details-list {
            background: rgba(34, 197, 94, 0.08);
            border-left: 4px solid #16a34a;
            padding: 0.875rem;
            margin-bottom: 1rem;
        }
        
        :is(.dark .notice-details-list) {
            background: rgba(34, 197, 94, 0.15);
            border-left-color: #22c55e;
        }
        
        .notice-detail-row {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: #44403c;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .notice-detail-row:last-child {
            margin-bottom: 0;
        }
        
        :is(.dark .notice-detail-row) {
            color: #d6d3d1;
        }
        
        .notice-compensation-row {
            font-weight: 700;
            color: #15803d;
        }
        
        :is(.dark .notice-compensation-row) {
            color: #4ade80;
        }
        
        /* Footer */
        .notice-footer-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.875rem;
            margin-top: 0.875rem;
            border-top: 2px dashed #d6d3d1;
            font-size: 0.75rem;
        }
        
        :is(.dark .notice-footer-bar) {
            border-top-color: #57534e;
        }
        
        .notice-author {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: #78716c;
            font-weight: 600;
        }
        
        :is(.dark .notice-author) {
            color: #a8a29e;
        }
        
        .notice-applications-badge {
            font-weight: 800;
            color: #0c4a6e;
            background: #e0f2fe;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.6875rem;
        }
        
        :is(.dark .notice-applications-badge) {
            background: #075985;
            color: #7dd3fc;
        }
        
        /* Hover effects */
        .notice-card:hover .notice-paper {
            transform: rotate(0deg) translateY(-6px);
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.25),
                0 6px 15px rgba(0, 0, 0, 0.18);
        }
        
        .notice-card:hover .washi-tape {
            box-shadow: 
                0 3px 8px rgba(0, 0, 0, 0.3),
                inset 0 1px 4px rgba(255, 255, 255, 0.7),
                inset 0 -1px 3px rgba(0, 0, 0, 0.2);
        }
    </style>
    @endif
</div>
