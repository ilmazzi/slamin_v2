<div>
    @if($poems && $poems->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-white" style="font-family: 'Crimson Pro', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                {!! __('home.poetry_section_title') !!}
            </h2>
            <p class="text-lg text-neutral-100">
                {{ __('home.poetry_section_subtitle') }}
            </p>
        </div>

        {{-- Poetry Cards Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 pt-8 pb-4">
            @foreach($poems->take(3) as $i => $poem)
            <?php
                $paperRotation = rand(-2, 2); // Slight random rotation
            ?>
            <div class="poetry-card-container" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
                
                {{-- Paper Sheet on Desk --}}
                <div class="paper-sheet-wrapper" style="transform: rotate({{ $paperRotation }}deg);">
                    
                    <a href="{{ route('poems.show', $poem->slug) }}" 
                       class="paper-sheet group">
                        
                        {{-- Author Avatar & Name --}}
                        <div class="paper-author-info">
                            @if($poem->user->profile_picture_url)
                                <img src="{{ $poem->user->profile_picture_url }}" 
                                     alt="{{ $poem->user->name }}"
                                     class="paper-avatar">
                            @else
                                <div class="paper-avatar-placeholder">
                                    {{ substr($poem->user->name, 0, 1) }}
                                </div>
                            @endif
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

        {{-- CTA Button --}}
        <div class="text-center mt-12">
            <a href="{{ route('poems.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white border-2 border-neutral-800 dark:border-neutral-300 rounded-lg font-semibold text-lg hover:bg-neutral-800 hover:text-white dark:hover:bg-white dark:hover:text-neutral-900 transition-all duration-300 shadow-lg hover:shadow-xl">
                {{ __('home.all_poems_button') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    @endif
</div>
