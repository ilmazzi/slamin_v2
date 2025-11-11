<div>
    @if($poems && $poems->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                {!! __('home.poetry_section_title') !!}
            </h2>
            <p class="text-lg text-neutral-600 dark:text-neutral-100 font-medium">
                {{ __('home.poetry_section_subtitle') }}
            </p>
        </div>

        {{-- Poetry Cards - Horizontal Scroll with Desktop Navigation --}}
        <div class="relative" x-data="{ 
            scroll(direction) {
                const container = this.$refs.scrollContainer;
                const scrollAmount = 400;
                container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
            }
        }">
            <!-- Left Arrow (Desktop Only) - OUTSIDE content -->
            <button @click="scroll(-1)" 
                    class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <!-- Right Arrow (Desktop Only) - OUTSIDE content -->
            <button @click="scroll(1)" 
                    class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
                <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <div x-ref="scrollContainer" class="flex gap-6 overflow-x-auto pb-12 pt-16 scrollbar-hide"
                 style="-webkit-overflow-scrolling: touch; overflow-y: visible;">
            @foreach($poems->take(3) as $i => $poem)
            <?php
                $paperRotation = rand(-2, 2); // Slight random rotation
            ?>
            <div class="w-96 md:w-[28rem] flex-shrink-0 poetry-card-container fade-scale-item" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Paper Sheet on Desk --}}
                <div class="paper-sheet-wrapper" style="transform: rotate({{ $paperRotation }}deg);">
                    
                    <div class="paper-sheet group">
                        
                        {{-- Author Avatar & Name --}}
                        <a href="{{ route('poems.show', $poem->slug) }}" class="block">
                            <div class="paper-author-info">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($poem->user, 80) }}" 
                                     alt="{{ $poem->user->name }}"
                                     class="paper-avatar">
                                <span class="paper-author-name">{{ $poem->user->name }}</span>
                            </div>
                            
                            {{-- Poem Title --}}
                            <h3 class="paper-title">
                                "{{ $poem->title ?: __('poems.untitled') }}"
                            </h3>
                            
                            {{-- Poem Content --}}
                            <div class="paper-content">
                                {{ $poem->description ?? Str::limit(strip_tags($poem->content), 180) }}
                            </div>
                            
                            {{-- Read more hint --}}
                            <div class="paper-readmore">
                                {{ __('common.read_more') }} →
                            </div>
                        </a>
                        
                        {{-- Social Actions - Inside Paper --}}
                        <div class="paper-actions-integrated" @click.stop>
                            <x-like-button 
                                :itemId="$poem->id"
                                itemType="poem"
                                :isLiked="$poem->is_liked ?? false"
                                :likesCount="$poem->like_count ?? 0"
                                size="sm" />
                            
                            <x-comment-button 
                                :itemId="$poem->id"
                                itemType="poem"
                                :commentsCount="$poem->comment_count ?? 0"
                                size="sm" />
                            
                            <x-share-button 
                                :itemId="$poem->id"
                                itemType="poem"
                                size="sm" />
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>

        {{-- CTA Button --}}
        <div class="text-center mt-12">
            <a href="{{ route('poems.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-primary-600 hover:bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-500 text-white rounded-lg font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-primary-500/50 hover:scale-105">
                {{ __('home.all_poems_button') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
    @endif
</div>
