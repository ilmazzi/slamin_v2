<div>
    @if($poems && $poems->count() > 0)
    <div class="max-w-[90rem] mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif;">
                {!! __('home.poetry_section_title') !!}
            </h2>
            <p class="text-lg text-white/90 font-medium">
                {{ __('home.poetry_section_subtitle') }}
            </p>
        </div>

        {{-- Poetry Cards - Horizontal Scroll with Desktop Navigation --}}
        <div class="relative" x-data="{ 
            scroll(direction) {
                const container = this.$refs.scrollContainer;
                const cards = container.children;
                if (cards.length === 0) return;
                
                const containerRect = container.getBoundingClientRect();
                const scrollLeft = container.scrollLeft;
                
                // Find current visible card
                let targetCard = null;
                for (let i = 0; i < cards.length; i++) {
                    const card = cards[i];
                    const cardRect = card.getBoundingClientRect();
                    const cardLeft = card.offsetLeft;
                    
                    if (direction > 0) {
                        // Scroll right: find first card that's partially or fully off-screen to the right
                        if (cardLeft > scrollLeft + containerRect.width - 100) {
                            targetCard = card;
                            break;
                        }
                    } else {
                        // Scroll left: find card to the left of current view
                        if (cardLeft < scrollLeft - 50) {
                            targetCard = card;
                        }
                    }
                }
                
                if (targetCard) {
                    targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
                }
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
            
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-white/60 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span>Scorri per vedere altro</span>
                </div>
            </div>
            
            <div x-ref="scrollContainer" class="flex gap-6 overflow-x-auto pb-12 pt-16 px-8 md:px-12 scrollbar-hide"
                 style="-webkit-overflow-scrolling: touch; overflow-y: visible;">
            @foreach($poems->take(3) as $i => $poem)
            <?php
                $paperRotation = rand(-2, 2); // Slight random rotation
            ?>
            <div class="w-80 md:w-96 flex-shrink-0 poetry-card-container fade-scale-item" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Paper Sheet on Desk --}}
                <div class="paper-sheet-wrapper" style="transform: rotate({{ $paperRotation }}deg);">
                    
                    <div class="paper-sheet group">
                        
                        {{-- Author Avatar & Name --}}
                        <div class="block cursor-pointer hover:opacity-90 transition-opacity" 
                             onclick="Livewire.dispatch('openPoemModal', { poemId: {{ $poem->id }} })">
                            <div class="paper-author-info">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($poem->user, 80) }}" 
                                     alt="{{ $poem->user->name }}"
                                     class="paper-avatar">
                                <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($poem->user) }}" 
                                   class="paper-author-name hover:underline transition-colors">
                                    {{ \App\Helpers\AvatarHelper::getDisplayName($poem->user) }}
                                </a>
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
                        </div>
                        
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

        {{-- CTA - Simple Text --}}
        <div class="text-center mt-12">
            <a href="{{ route('poems.index') }}" 
               class="inline-block text-2xl md:text-3xl font-bold text-white hover:text-primary-400 transition-colors duration-300"
               style="font-family: 'Crimson Pro', serif;">
                → {{ __('home.all_poems_button') }}
            </a>
        </div>
    </div>
    @else
    {{-- Empty State Placeholder --}}
    <div class="max-w-[90rem] mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-12 section-title-fade">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif;">
                {!! __('home.poetry_section_title') !!}
            </h2>
            <p class="text-lg text-white/90 font-medium">
                {{ __('home.poetry_section_subtitle') }}
            </p>
        </div>
        
        <div class="flex flex-col items-center justify-center py-20 px-4">
            <div class="text-center max-w-md">
                <svg class="w-24 h-24 mx-auto mb-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-2xl font-bold text-white mb-3" style="font-family: 'Crimson Pro', serif;">
                    {{ __('home.no_poems_title') }}
                </h3>
                <p class="text-white/80 mb-6">
                    {{ __('home.no_poems_subtitle') }}
                </p>
                @auth
                <a href="{{ route('poems.create') }}" 
                   class="inline-block px-6 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-primary-50 transition-colors duration-300">
                    {{ __('home.create_content') }}
                </a>
                @endauth
            </div>
        </div>
    </div>
    @endif
    
    {{-- Poem Modal Component --}}
    <livewire:poems.poem-modal />
</div>
