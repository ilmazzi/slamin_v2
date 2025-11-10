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
                <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                    {!! __('home.gigs_section_title') !!}
                </h2>
                <p class="text-lg text-neutral-600 dark:text-neutral-400">
                    {{ __('home.gigs_section_subtitle') }}
                </p>
            </div>

            <!-- Slider Controls (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <button @click="prev()" 
                        :disabled="currentPage === 0"
                        :class="currentPage === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-accent-100 dark:hover:bg-accent-900'"
                        class="w-12 h-12 rounded-full border-2 border-accent-600 dark:border-accent-500 flex items-center justify-center text-accent-600 dark:text-accent-400 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <span class="text-sm text-neutral-600 dark:text-neutral-400 font-medium min-w-[60px] text-center">
                    <span x-text="currentPage + 1"></span> / <span x-text="totalPages"></span>
                </span>
                <button @click="next()" 
                        :disabled="currentPage >= totalPages - 1"
                        :class="currentPage >= totalPages - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-accent-100 dark:hover:bg-accent-900'"
                        class="w-12 h-12 rounded-full border-2 border-accent-600 dark:border-accent-500 flex items-center justify-center text-accent-600 dark:text-accent-400 transition-all">
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
                <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')"
                     style="animation-delay: {{ $i * 0.1 }}s">
                    
                    {{-- Alternating styles: poster (even) / notice board (odd) --}}
                    @if($i % 2 == 0)
                        {{-- ====================================
                             POSTER TEATRALE VINTAGE
                             ==================================== --}}
                        <a href="{{ route('gigs.show', $gig) }}" 
                           class="group block h-full theater-poster">
                            
                            {{-- Decorative pins --}}
                            <div class="poster-pin poster-pin-tl"></div>
                            <div class="poster-pin poster-pin-tr"></div>
                            
                            <div class="poster-content">
                                {{-- Decorative top border --}}
                                <div class="poster-border-top"></div>
                                
                                {{-- Status badges --}}
                                @if($gig->is_urgent || $gig->is_featured)
                                <div class="flex justify-center gap-2 mb-4">
                                    @if($gig->is_urgent)
                                        <span class="poster-badge poster-badge-urgent">URGENTE!</span>
                                    @endif
                                    @if($gig->is_featured)
                                        <span class="poster-badge poster-badge-featured">★ IN EVIDENZA</span>
                                    @endif
                                </div>
                                @endif
                                
                                {{-- Headline --}}
                                <h3 class="poster-headline">
                                    CERCASI
                                </h3>
                                
                                {{-- Position type --}}
                                <div class="poster-position">
                                    {{ __('gigs.categories.' . $gig->category) }}
                                </div>
                                
                                {{-- Event/project name --}}
                                <div class="poster-subtitle">
                                    {{ $gig->title }}
                                </div>
                                
                                {{-- Info sections --}}
                                <div class="poster-info">
                                    @if($gig->location)
                                        <div class="poster-info-row">
                                            <span class="poster-label">LUOGO:</span>
                                            <span>{{ $gig->location }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($gig->deadline)
                                        <div class="poster-info-row">
                                            <span class="poster-label">ENTRO:</span>
                                            <span>{{ $gig->deadline->format('d M Y') }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($gig->compensation)
                                        <div class="poster-info-row poster-info-compensation">
                                            <span class="poster-label">COMPENSO:</span>
                                            <span>{{ Str::limit($gig->compensation, 40) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- CTA --}}
                                <div class="poster-cta">
                                    CANDIDATI ORA!
                                </div>
                                
                                {{-- Decorative bottom border --}}
                                <div class="poster-border-bottom"></div>
                            </div>
                        </a>
                    @else
                        {{-- ====================================
                             NOTICE BOARD / BACHECA
                             ==================================== --}}
                        <a href="{{ route('gigs.show', $gig) }}" 
                           class="group block h-full notice-board-card">
                            
                            {{-- Tape strips --}}
                            <div class="tape-strip tape-top"></div>
                            <div class="tape-strip tape-bottom"></div>
                            
                            <div class="notice-content">
                                {{-- Header with handwritten style --}}
                                <div class="notice-header">
                                    <span class="notice-category">{{ __('gigs.categories.' . $gig->category) }}</span>
                                    @if($gig->is_urgent)
                                        <span class="notice-urgent">!! URGENTE !!</span>
                                    @endif
                                </div>
                                
                                {{-- Title --}}
                                <h3 class="notice-title">
                                    {{ $gig->title }}
                                </h3>
                                
                                {{-- Description --}}
                                <p class="notice-description">
                                    {{ Str::limit(strip_tags($gig->description), 120) }}
                                </p>
                                
                                {{-- Details list --}}
                                <div class="notice-details">
                                    @if($gig->location)
                                        <div class="notice-detail-item">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>{{ $gig->location }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($gig->deadline)
                                        <div class="notice-detail-item">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Scadenza: {{ $gig->deadline->format('d M Y') }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($gig->compensation)
                                        <div class="notice-detail-item notice-compensation">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>{{ Str::limit($gig->compensation, 35) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- Footer --}}
                                <div class="notice-footer">
                                    <span class="notice-contact">Info: {{ $gig->user ? $gig->user->name : 'Organizzatore' }}</span>
                                    <span class="notice-applications">{{ $gig->application_count }} candidature</span>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Dots Indicator (Mobile) -->
        <div class="flex md:hidden justify-center gap-2 mt-8">
            <template x-for="i in totalPages" :key="i">
                <button @click="currentPage = i - 1"
                        :class="currentPage === i - 1 ? 'bg-accent-600 dark:bg-accent-500 w-8' : 'bg-neutral-300 dark:bg-neutral-600 w-3'"
                        class="h-3 rounded-full transition-all duration-300"></button>
            </template>
        </div>

        <!-- See All Button -->
        <div class="text-center mt-12">
            <a href="{{ route('gigs.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-accent-700 hover:to-accent-800 text-white font-black uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105">
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
           POSTER TEATRALE VINTAGE
           ========================================== */
        
        .theater-poster {
            position: relative;
            background: 
                /* Paper texture */
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23noise)' opacity='0.08'/%3E%3C/svg%3E"),
                /* Gradient warm vintage */
                linear-gradient(165deg, #fef8f0 0%, #f9f1e6 50%, #fef8f0 100%);
            border: 6px solid #2d2620;
            box-shadow: 
                0 6px 20px rgba(0, 0, 0, 0.15),
                0 3px 8px rgba(0, 0, 0, 0.1),
                inset 0 0 40px rgba(139, 115, 85, 0.05);
            transition: all 0.4s ease;
        }
        
        :is(.dark .theater-poster) {
            background: 
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23noise)' opacity='0.08'/%3E%3C/svg%3E"),
                linear-gradient(165deg, #3d3830 0%, #322e26 50%, #3d3830 100%);
            border-color: #1a1715;
        }
        
        .poster-content {
            padding: 2rem 1.5rem;
            text-align: center;
        }
        
        /* Decorative pins at top */
        .poster-pin {
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: radial-gradient(circle, #8b4513 0%, #654321 70%, #3d2817 100%);
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.3),
                inset 0 1px 2px rgba(255, 255, 255, 0.2),
                inset 0 -1px 2px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }
        
        .poster-pin-tl {
            top: 12px;
            left: 12px;
        }
        
        .poster-pin-tr {
            top: 12px;
            right: 12px;
        }
        
        /* Decorative borders */
        .poster-border-top,
        .poster-border-bottom {
            height: 3px;
            background: repeating-linear-gradient(
                90deg,
                #2d2620 0px,
                #2d2620 8px,
                transparent 8px,
                transparent 12px
            );
            margin: 0 -1.5rem 1.5rem -1.5rem;
        }
        
        .poster-border-bottom {
            margin: 1.5rem -1.5rem 0 -1.5rem;
        }
        
        /* Typography */
        .poster-headline {
            font-family: 'Crimson Pro', serif;
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: 0.1em;
            color: #1a1410;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            line-height: 1;
        }
        
        :is(.dark .poster-headline) {
            color: #f5f0e8;
        }
        
        .poster-position {
            font-family: 'Crimson Pro', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #c2410c;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }
        
        :is(.dark .poster-position) {
            color: #fb923c;
        }
        
        .poster-subtitle {
            font-size: 0.875rem;
            font-weight: 600;
            color: #57534e;
            margin-bottom: 1.5rem;
            line-height: 1.4;
        }
        
        :is(.dark .poster-subtitle) {
            color: #a8a29e;
        }
        
        .poster-info {
            text-align: left;
            space-y: 0.75rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.5);
            border: 2px dashed #78716c;
            margin-bottom: 1.5rem;
        }
        
        :is(.dark .poster-info) {
            background: rgba(0, 0, 0, 0.2);
            border-color: #57534e;
        }
        
        .poster-info-row {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.8125rem;
            margin-bottom: 0.5rem;
            color: #292524;
        }
        
        :is(.dark .poster-info-row) {
            color: #d6d3d1;
        }
        
        .poster-info-compensation {
            font-weight: 700;
            color: #15803d;
        }
        
        :is(.dark .poster-info-compensation) {
            color: #4ade80;
        }
        
        .poster-label {
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            min-width: 70px;
        }
        
        .poster-cta {
            font-family: 'Crimson Pro', serif;
            font-size: 1.25rem;
            font-weight: 900;
            padding: 0.75rem;
            background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .poster-badge {
            font-size: 0.625rem;
            font-weight: 900;
            padding: 0.25rem 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border: 2px solid;
            transform: rotate(-2deg);
        }
        
        .poster-badge-urgent {
            background: #dc2626;
            color: white;
            border-color: #991b1b;
            animation: pulse 2s infinite;
        }
        
        .poster-badge-featured {
            background: #2563eb;
            color: white;
            border-color: #1e40af;
        }
        
        /* Hover */
        .theater-poster:hover {
            transform: translateY(-8px) rotate(1deg);
            box-shadow: 
                0 12px 30px rgba(0, 0, 0, 0.2),
                0 6px 15px rgba(0, 0, 0, 0.15);
        }
        
        /* ==========================================
           NOTICE BOARD / BACHECA
           ========================================== */
        
        .notice-board-card {
            position: relative;
            background: 
                /* Paper texture */
                url("data:image/svg+xml,%3Csvg width='150' height='150' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.2' numOctaves='3' /%3E%3C/filter%3E%3Crect width='150' height='150' filter='url(%23paper)' opacity='0.06'/%3E%3C/svg%3E"),
                /* White/cream paper */
                linear-gradient(180deg, #fffef9 0%, #fefcf3 100%);
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.1),
                0 2px 6px rgba(0, 0, 0, 0.06);
            transition: all 0.4s ease;
            transform: rotate(-0.5deg);
        }
        
        :is(.dark .notice-board-card) {
            background: 
                url("data:image/svg+xml,%3Csvg width='150' height='150' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.2' numOctaves='3' /%3E%3C/filter%3E%3Crect width='150' height='150' filter='url(%23paper)' opacity='0.06'/%3E%3C/svg%3E"),
                linear-gradient(180deg, #3f3f3a 0%, #35352f 100%);
        }
        
        /* Tape strips */
        .tape-strip {
            position: absolute;
            left: 50%;
            transform: translateX(-50%) rotate(-1deg);
            width: 80px;
            height: 25px;
            background: 
                linear-gradient(180deg, 
                    rgba(255, 250, 220, 0.85) 0%, 
                    rgba(250, 245, 215, 0.75) 50%, 
                    rgba(255, 250, 220, 0.85) 100%
                );
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.15),
                inset 0 1px 2px rgba(255, 255, 255, 0.5),
                inset 0 -1px 2px rgba(0, 0, 0, 0.1);
            z-index: 5;
        }
        
        :is(.dark .tape-strip) {
            background: 
                linear-gradient(180deg, 
                    rgba(80, 75, 60, 0.85) 0%, 
                    rgba(70, 65, 50, 0.75) 50%, 
                    rgba(80, 75, 60, 0.85) 100%
                );
        }
        
        .tape-top {
            top: -12px;
        }
        
        .tape-bottom {
            bottom: -12px;
            transform: translateX(-50%) rotate(2deg);
        }
        
        .notice-content {
            padding: 2rem 1.5rem;
        }
        
        .notice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e7e5e4;
        }
        
        :is(.dark .notice-header) {
            border-bottom-color: #44403c;
        }
        
        .notice-category {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #0c4a6e;
            background: #bae6fd;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
        }
        
        :is(.dark .notice-category) {
            background: #164e63;
            color: #7dd3fc;
        }
        
        .notice-urgent {
            font-size: 0.625rem;
            font-weight: 900;
            color: #dc2626;
            animation: pulse 2s infinite;
        }
        
        .notice-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1c1917;
            margin-bottom: 0.75rem;
            line-height: 1.3;
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
        
        .notice-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(250, 250, 249, 0.5);
            border-left: 3px solid #16a34a;
        }
        
        :is(.dark .notice-details) {
            background: rgba(0, 0, 0, 0.2);
            border-left-color: #22c55e;
        }
        
        .notice-detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: #44403c;
        }
        
        :is(.dark .notice-detail-item) {
            color: #d6d3d1;
        }
        
        .notice-compensation {
            font-weight: 700;
            color: #15803d;
        }
        
        :is(.dark .notice-compensation) {
            color: #4ade80;
        }
        
        .notice-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px dashed #d6d3d1;
            font-size: 0.75rem;
        }
        
        :is(.dark .notice-footer) {
            border-top-color: #57534e;
        }
        
        .notice-contact {
            color: #78716c;
            font-weight: 600;
        }
        
        :is(.dark .notice-contact) {
            color: #a8a29e;
        }
        
        .notice-applications {
            font-weight: 700;
            color: #0c4a6e;
            background: #e0f2fe;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }
        
        :is(.dark .notice-applications) {
            background: #164e63;
            color: #7dd3fc;
        }
        
        /* Hover */
        .notice-board-card:hover {
            transform: rotate(0deg) translateY(-6px);
            box-shadow: 
                0 10px 25px rgba(0, 0, 0, 0.15),
                0 5px 12px rgba(0, 0, 0, 0.1);
        }
        
        .notice-board-card:hover .tape-strip {
            box-shadow: 
                0 3px 6px rgba(0, 0, 0, 0.2),
                inset 0 1px 2px rgba(255, 255, 255, 0.6),
                inset 0 -1px 2px rgba(0, 0, 0, 0.15);
        }
    </style>
    @endif
</div>
