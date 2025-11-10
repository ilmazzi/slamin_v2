<div class="h-full">
    <article 
        onclick="window.location='{{ route('poems.show', $poem->slug) }}'"
        class="group cursor-pointer h-full flex flex-col">
        
        <!-- HEADER (senza effetto carta) -->
        <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-xl rounded-t-2xl p-4 border border-neutral-200/50 dark:border-neutral-700/50 group-hover:-translate-y-2 transition-all duration-500">
            <!-- Header con autore e immagine piccola -->
            <div class="flex items-start gap-4">
                <!-- Avatar + Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <x-ui.user-avatar 
                            :user="$poem->user" 
                            size="sm" 
                            :link="false"
                            class="ring-2 ring-primary-200 dark:ring-primary-800" />
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-xs text-neutral-900 dark:text-neutral-100 truncate">
                                {{ $poem->user->name }}
                            </p>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400">
                                {{ $poem->published_at?->diffForHumans() ?? $poem->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Category badge -->
                    <x-ui.badges.category 
                        :label="config('poems.categories')[$poem->category] ?? $poem->category" 
                        color="primary" 
                        class="!text-xs !px-2 !py-0.5" />
                </div>
                
                <!-- Immagine PICCOLA -->
                @if($poem->thumbnail_url)
                <div class="w-20 h-20 rounded-lg overflow-hidden shadow-lg border-2 border-primary-200 dark:border-primary-700 flex-shrink-0">
                    <img src="{{ $poem->thumbnail_url }}" 
                         alt="{{ $poem->title ?: __('poems.untitled') }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                @endif
                
                <!-- Featured Star -->
                @if($poem->is_featured)
                    <div class="absolute top-2 right-2 px-2 py-1 rounded-full 
                                backdrop-blur-md bg-yellow-500/90 text-white text-xs font-bold
                                flex items-center gap-1 shadow-lg animate-pulse z-50">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-xs">★</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- CONTENUTO POESIA (con effetto carta vintage) -->
        <div class="relative vintage-paper-sheet-card overflow-visible p-6 flex-1 group-hover:-translate-y-2 transition-all duration-500"
             style="transform: perspective(1000px) rotateX(0.5deg); border-radius: 0 0 12px 12px;">
            
            <!-- Angolo piegato -->
            <div class="vintage-corner-card"></div>
            
            <!-- Texture + Macchie -->
            <div class="vintage-texture-card"></div>
            <div class="vintage-stains-card"></div>
            
            <!-- Contenuto -->
            <div class="relative z-10 flex flex-col h-full">
                
                <!-- Titolo -->
            <h3 class="text-lg font-bold mb-3 text-neutral-900 dark:text-neutral-100 
                       group-hover:text-primary-600 dark:group-hover:text-primary-400 
                       transition-colors font-poem leading-tight line-clamp-2">
                "{{ $poem->title ?: __('poems.untitled') }}"
            </h3>
            
            <!-- Excerpt -->
            <p class="text-neutral-700 dark:text-neutral-300 italic line-clamp-3 text-sm mb-4 font-poem leading-relaxed flex-1">
                {{ $poem->description ?? Str::limit(strip_tags($poem->content), 100) }}
            </p>
            
            <!-- Tags -->
            @if($poem->tags && count($poem->tags) > 0)
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach(array_slice($poem->tags, 0, 3) as $tag)
                        <span class="px-2 py-0.5 text-xs rounded-full 
                                     bg-neutral-100 dark:bg-neutral-700/50
                                     text-neutral-700 dark:text-neutral-300
                                     border border-neutral-300 dark:border-neutral-600
                                     font-medium">
                            #{{ $tag }}
                        </span>
                    @endforeach
                    @if(count($poem->tags) > 3)
                        <span class="px-2 py-0.5 text-xs rounded-full 
                                     bg-neutral-200 dark:bg-neutral-600/50 
                                     text-neutral-800 dark:text-neutral-400
                                     border border-neutral-300 dark:border-neutral-600">
                            +{{ count($poem->tags) - 3 }}
                        </span>
                    @endif
                </div>
            @endif
            
            <!-- Social Actions -->
            @if($showActions)
                <!-- Divisore Calligrafico -->
                <div class="flex items-center justify-center my-4">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-neutral-400/30 to-neutral-400/15 dark:via-neutral-500/30 dark:to-neutral-500/15"></div>
                    <div class="px-4 text-neutral-500/50 dark:text-neutral-400/50 text-xl">❦</div>
                    <div class="flex-1 h-px bg-gradient-to-l from-transparent via-neutral-400/30 to-neutral-400/15 dark:via-neutral-500/30 dark:to-neutral-500/15"></div>
                </div>
                
                <div class="flex items-center gap-4" @click.stop>
                    <x-like-button 
                        :itemId="$poem->id"
                        itemType="poem"
                        :isLiked="false"
                        :likesCount="$poem->like_count ?? 0"
                        size="sm" 
                        class="hover:scale-110 transition-transform" />
                    
                    <x-comment-button 
                        :itemId="$poem->id"
                        itemType="poem"
                        :commentsCount="$poem->comment_count ?? 0"
                        size="sm"
                        class="hover:scale-110 transition-transform" />
                    
                    <div class="flex items-center gap-1 text-sm text-neutral-600 dark:text-neutral-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span class="font-medium text-xs">{{ number_format($poem->view_count ?? 0) }}</span>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </article>
    
    <style>
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</div>
