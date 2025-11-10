<div>
    @if($poems && $poems->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8"
         x-data="{
             currentPage: 0,
             itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
             totalItems: {{ $poems->take(3)->count() }},
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
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-10 section-title-fade">
            <div class="flex-1">
                <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                    {!! __('home.poetry_section_title') !!}
                </h2>
                <p class="text-lg text-neutral-100">
                    {{ __('home.poetry_section_subtitle') }}
                </p>
            </div>

            <!-- Slider Controls (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <button @click="prev()" 
                        :disabled="currentPage === 0"
                        :class="currentPage === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-white/20'"
                        class="p-3 rounded-full bg-white/10 backdrop-blur-sm text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="next()" 
                        :disabled="currentPage === totalPages - 1"
                        :class="currentPage === totalPages - 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-white/20'"
                        class="p-3 rounded-full bg-white/10 backdrop-blur-sm text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Poetry Cards Slider --}}
        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out gap-8 md:gap-10 pt-8 pb-4"
                 :style="`transform: translateX(-${currentPage * 100}%)`">
            @foreach($poems->take(3) as $i => $poem)
            <?php
                $paperRotation = rand(-2, 2); // Slight random rotation
            ?>
            <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 poetry-card-container fade-scale-item" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Paper Sheet on Desk --}}
                <div class="paper-sheet-wrapper" style="transform: rotate({{ $paperRotation }}deg);">
                    
                    <a href="{{ route('poems.show', $poem->slug) }}" 
                       class="paper-sheet group">
                        
                        {{-- Author Avatar & Name --}}
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
                    
                    {{-- Social Actions --}}
                    <div class="paper-actions" @click.stop>
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
            @endforeach
            </div>
        </div>

        <!-- Page Indicators (Mobile) -->
        <div class="flex md:hidden justify-center items-center gap-2 mt-8">
            <template x-for="i in totalPages" :key="i">
                <button @click="currentPage = i - 1"
                        :class="currentPage === i - 1 ? 'bg-white w-8' : 'bg-white/30 w-2'"
                        class="h-2 rounded-full transition-all duration-300">
                </button>
            </template>
        </div>

        {{-- CTA Button --}}
        <div class="text-center mt-12">
            <a href="{{ route('poems.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-primary-600 hover:bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-500 text-white rounded-lg font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-primary-500/50 hover:scale-105">
                {{ __('home.all_poems_button') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    @endif
</div>
