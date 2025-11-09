<!-- MAGAZINE VIEW - TEXT FIRST (Versi Protagonisti) -->
<div class="mb-12 relative">
    
    <!-- VERSI FLUTTUANTI IN BACKGROUND -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0" aria-hidden="true">
        @php
            // Prendi versi random da alcune poesie
            $randomVerses = \App\Models\Poem::published()
                ->inRandomOrder()
                ->limit(8)
                ->get()
                ->map(function($p) {
                    $content = strip_tags($p->content);
                    $lines = array_filter(explode("\n", $content));
                    if (empty($lines)) return null;
                    $verse = trim($lines[array_rand($lines)]);
                    return Str::limit($verse, 50);
                })
                ->filter()
                ->take(8);
        @endphp
        
        @foreach($randomVerses as $idx => $verse)
            <div class="absolute font-poem text-3xl md:text-4xl italic font-light pointer-events-none select-none"
                 style="
                    top: {{ 8 + ($idx * 14) }}%;
                    {{ $idx % 2 === 0 ? 'left' : 'right' }}: {{ 3 + ($idx * 7) }}%;
                    color: rgba(16, 185, 129, 0.25);
                    animation: float-verse-mag-{{ $idx }} {{ 20 + ($idx * 2) }}s ease-in-out infinite;
                    animation-delay: {{ $idx * 1.2 }}s;
                    z-index: 1;
                    text-shadow: 0 0 20px rgba(16, 185, 129, 0.1);
                ">
                "{{ $verse }}"
            </div>
            
            <style>
                @keyframes float-verse-mag-{{ $idx }} {
                    0%, 100% { 
                        transform: translateX(0) translateY(0) rotate({{ -6 + ($idx * 2) }}deg);
                        opacity: 0.2;
                    }
                    25% {
                        transform: translateX({{ 20 - ($idx * 3) }}px) translateY(-15px) rotate({{ -5 + ($idx * 2) }}deg);
                        opacity: 0.3;
                    }
                    50% { 
                        transform: translateX({{ 30 - ($idx * 4) }}px) translateY(-30px) rotate({{ -4 + ($idx * 2) }}deg);
                        opacity: 0.35;
                    }
                    75% {
                        transform: translateX({{ 15 - ($idx * 2) }}px) translateY(-20px) rotate({{ -5 + ($idx * 2) }}deg);
                        opacity: 0.25;
                    }
                }
            </style>
        @endforeach
    </div>
    
    <!-- CONTENT -->
    <div class="relative z-10">
        @php
            $poemsArray = $poems->items();
            $i = 0;
        @endphp
        
        @while($i < count($poemsArray))
            @php
                $pattern = $i % 5;
                $poem = $poemsArray[$i];
            @endphp
            
            {{-- Pattern 0: HERO - Solo Testo Grande --}}
            @if($pattern === 0)
                <article class="mb-12 animate-fade-in cursor-pointer group"
                        style="animation-delay: {{ $i * 0.05 }}s"
                        onclick="window.location='{{ route('poems.show', $poem->slug) }}'">
                    <div class="backdrop-blur-2xl bg-white/90 dark:bg-neutral-800/90 
                                rounded-[3rem] shadow-2xl hover:shadow-3xl
                                border-2 border-primary-100 dark:border-primary-900/50
                                p-12 md:p-16 lg:p-20
                                hover:-translate-y-2 hover:border-primary-300 dark:hover:border-primary-700
                                transition-all duration-500">
                        
                        <x-ui.badges.category 
                            :label="config('poems.categories')[$poem->category] ?? $poem->category" 
                            color="primary" 
                            class="mb-6" />
                        
                        <!-- Quote decorativa gigante -->
                        <div class="relative">
                            <div class="absolute -left-8 -top-6 text-primary-200 dark:text-primary-900/30 
                                        text-9xl font-poem leading-none">
                                ❝
                            </div>
                            <h3 class="text-4xl md:text-5xl lg:text-6xl font-bold 
                                       text-neutral-900 dark:text-white font-poem 
                                       leading-tight mb-6 relative z-10
                                       group-hover:text-primary-600 dark:group-hover:text-primary-400
                                       transition-colors">
                                {{ $poem->title ?: __('poems.untitled') }}
                            </h3>
                        </div>
                        
                        <!-- Estratto GRANDE -->
                        <p class="text-xl md:text-2xl text-neutral-600 dark:text-neutral-400 
                                  font-poem italic leading-relaxed mb-8 line-clamp-4">
                            {{ strip_tags($poem->content) ? Str::limit(strip_tags($poem->content), 280) : $poem->description }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-6 border-t border-neutral-200 dark:border-neutral-700">
                            <x-ui.user-avatar :user="$poem->user" size="lg" :showName="true" :link="false" />
                            
                            <div class="flex items-center gap-4" @click.stop>
                                <x-like-button :itemId="$poem->id" itemType="poem" :isLiked="false" :likesCount="$poem->like_count ?? 0" size="md" />
                                <x-comment-button :itemId="$poem->id" itemType="poem" :commentsCount="$poem->comment_count ?? 0" size="md" />
                            </div>
                        </div>
                    </div>
                </article>
                @php $i++; @endphp
            
            {{-- Pattern 1-2: DUE COLONNE - Testo con mini-thumbnail --}}
            @elseif($pattern === 1 && isset($poemsArray[$i + 1]))
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    @foreach([$poemsArray[$i], $poemsArray[$i + 1]] as $idx => $p)
                        <article class="backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                                       rounded-3xl shadow-xl hover:shadow-2xl
                                       border border-white/50 dark:border-neutral-700/50
                                       p-8 cursor-pointer group
                                       hover:-translate-y-1 transition-all duration-300
                                       animate-fade-in"
                                style="animation-delay: {{ ($i + $idx) * 0.05 }}s"
                                onclick="window.location='{{ route('poems.show', $p->slug) }}'">
                            
                            <!-- Mini thumbnail in corner (se esiste) -->
                            @if($p->thumbnail_url)
                                <div class="float-right ml-4 mb-4 w-24 h-24 rounded-2xl overflow-hidden 
                                            shadow-lg group-hover:scale-110 group-hover:rotate-3 
                                            transition-all duration-500">
                                    <img src="{{ $p->thumbnail_url }}" 
                                         alt="{{ $p->title ?: __('poems.untitled') }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @endif
                            
                            <x-ui.badges.category 
                                :label="config('poems.categories')[$p->category] ?? $p->category" 
                                color="primary" 
                                class="!text-xs mb-4" />
                            
                            <h3 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white 
                                       font-poem leading-tight mb-4
                                       group-hover:text-primary-600 dark:group-hover:text-primary-400
                                       transition-colors">
                                "{{ $p->title ?: __('poems.untitled') }}"
                            </h3>
                            
                            <p class="text-neutral-600 dark:text-neutral-400 
                                      font-poem italic line-clamp-3 mb-6">
                                {{ strip_tags($p->content) ? Str::limit(strip_tags($p->content), 150) : $p->description }}
                            </p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-neutral-200 dark:border-neutral-700">
                                <x-ui.user-avatar :user="$p->user" size="sm" :showName="true" :link="false" />
                                
                                <div class="flex items-center gap-3" @click.stop>
                                    <x-like-button :itemId="$p->id" itemType="poem" :isLiked="false" :likesCount="$p->like_count ?? 0" size="sm" />
                                    <x-comment-button :itemId="$p->id" itemType="poem" :commentsCount="$p->comment_count ?? 0" size="sm" />
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                @php $i += 2; @endphp
            
            {{-- Pattern 3: SINGLE - Testo Protagonista con thumbnail piccola laterale --}}
            @elseif($pattern === 3)
                <article class="md:mx-12 mb-8 backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                               rounded-3xl shadow-xl hover:shadow-2xl
                               border border-white/50 dark:border-neutral-700/50
                               overflow-hidden cursor-pointer group
                               hover:-translate-y-2 hover:rotate-1
                               transition-all duration-500
                               animate-fade-in"
                        style="animation-delay: {{ $i * 0.05 }}s"
                        onclick="window.location='{{ route('poems.show', $poem->slug) }}'">
                    
                    <div class="flex flex-col md:flex-row">
                        <!-- Content FIRST (70%) -->
                        <div class="md:w-[70%] p-10 md:p-12 flex flex-col justify-center">
                            <div class="relative">
                                <div class="absolute -left-6 -top-4 text-primary-200 dark:text-primary-900/30 
                                            text-8xl font-poem leading-none">
                                    ❝
                                </div>
                                
                                <x-ui.badges.category 
                                    :label="config('poems.categories')[$poem->category] ?? $poem->category" 
                                    color="primary" 
                                    class="mb-4 relative z-10" />
                                
                                <h3 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white 
                                           font-poem leading-tight mb-6 relative z-10
                                           group-hover:text-primary-600 dark:group-hover:text-primary-400
                                           transition-colors">
                                    {{ $poem->title ?: __('poems.untitled') }}
                                </h3>
                            </div>
                            
                            <p class="text-lg text-neutral-600 dark:text-neutral-400 
                                      font-poem italic leading-relaxed line-clamp-5 mb-6">
                                {{ strip_tags($poem->content) ? Str::limit(strip_tags($poem->content), 300) : $poem->description }}
                            </p>
                            
                            <div class="flex items-center justify-between pt-6 border-t border-neutral-200 dark:border-neutral-700">
                                <x-ui.user-avatar :user="$poem->user" size="md" :showName="true" :link="false" />
                                
                                <div class="flex items-center gap-4" @click.stop>
                                    <x-like-button :itemId="$poem->id" itemType="poem" :isLiked="false" :likesCount="$poem->like_count ?? 0" size="md" />
                                    <x-comment-button :itemId="$poem->id" itemType="poem" :commentsCount="$poem->comment_count ?? 0" size="md" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mini thumbnail laterale (30%) - Opzionale -->
                        @if($poem->thumbnail_url)
                            <div class="md:w-[30%] aspect-[3/4] relative overflow-hidden">
                                <img src="{{ $poem->thumbnail_url }}" 
                                     alt="{{ $poem->title ?: __('poems.untitled') }}"
                                     class="w-full h-full object-cover opacity-60 group-hover:opacity-80 
                                            group-hover:scale-110 transition-all duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-white/80 dark:from-neutral-800/80 to-transparent"></div>
                            </div>
                        @endif
                    </div>
                </article>
                @php $i++; @endphp
            
            {{-- Pattern 4: TESTO PURO - Nessuna immagine --}}
            @elseif($pattern === 4)
                <article class="mb-8 backdrop-blur-xl bg-gradient-to-br 
                               from-white/95 via-primary-50/30 to-white/95
                               dark:from-neutral-800/95 dark:via-primary-950/20 dark:to-neutral-800/95
                               rounded-3xl shadow-xl hover:shadow-2xl
                               border-2 border-primary-100 dark:border-primary-900/50
                               p-10 md:p-14 cursor-pointer group
                               hover:-translate-y-2 hover:border-primary-300 dark:hover:border-primary-700
                               transition-all duration-500
                               animate-fade-in
                               text-center"
                        style="animation-delay: {{ $i * 0.05 }}s"
                        onclick="window.location='{{ route('poems.show', $poem->slug) }}'">
                    
                    <!-- Badge centrata -->
                    <div class="flex justify-center mb-6">
                        <x-ui.badges.category 
                            :label="config('poems.categories')[$poem->category] ?? $poem->category" 
                            color="primary" />
                    </div>
                    
                    <!-- Titolo GRANDE centrato -->
                    <h3 class="text-4xl md:text-5xl lg:text-6xl font-bold 
                               text-neutral-900 dark:text-white font-poem 
                               leading-tight mb-8 
                               group-hover:text-primary-600 dark:group-hover:text-primary-400
                               transition-colors max-w-4xl mx-auto">
                        "{{ $poem->title ?: __('poems.untitled') }}"
                    </h3>
                    
                    <!-- Estratto poesia GRANDE -->
                    <div class="text-xl md:text-2xl text-neutral-700 dark:text-neutral-300 
                                font-poem italic leading-relaxed mb-8 
                                line-clamp-6 max-w-3xl mx-auto whitespace-pre-line">
                        {{ strip_tags($poem->content) ? Str::limit(strip_tags($poem->content), 400) : $poem->description }}
                    </div>
                    
                    <!-- Footer -->
                    <div class="flex items-center justify-center gap-8 pt-8 border-t border-neutral-200 dark:border-neutral-700 max-w-2xl mx-auto">
                        <x-ui.user-avatar :user="$poem->user" size="md" :showName="true" :link="false" />
                        
                        <div class="flex items-center gap-4" @click.stop>
                            <x-like-button :itemId="$poem->id" itemType="poem" :isLiked="false" :likesCount="$poem->like_count ?? 0" size="md" />
                            <x-comment-button :itemId="$poem->id" itemType="poem" :commentsCount="$poem->comment_count ?? 0" size="md" />
                        </div>
                    </div>
                </article>
                @php $i++; @endphp
            
            {{-- Fallback: Card normale text-first --}}
            @else
                <article class="mb-8 backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                               rounded-3xl shadow-xl hover:shadow-2xl
                               border border-white/50 dark:border-neutral-700/50
                               p-8 md:p-10 cursor-pointer group
                               hover:-translate-y-1 transition-all duration-300
                               animate-fade-in"
                        style="animation-delay: {{ $i * 0.05 }}s"
                        onclick="window.location='{{ route('poems.show', $poem->slug) }}'">
                    
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Testo (75%) -->
                        <div class="md:w-3/4">
                            <x-ui.badges.category 
                                :label="config('poems.categories')[$poem->category] ?? $poem->category" 
                                color="primary" 
                                class="mb-4" />
                            
                            <h3 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white 
                                       font-poem leading-tight mb-4
                                       group-hover:text-primary-600 dark:group-hover:text-primary-400
                                       transition-colors">
                                "{{ $poem->title ?: __('poems.untitled') }}"
                            </h3>
                            
                            <p class="text-lg text-neutral-600 dark:text-neutral-400 
                                      font-poem italic leading-relaxed line-clamp-4 mb-6">
                                {{ strip_tags($poem->content) ? Str::limit(strip_tags($poem->content), 220) : $poem->description }}
                            </p>
                            
                            <div class="flex items-center justify-between">
                                <x-ui.user-avatar :user="$poem->user" size="sm" :showName="true" :link="false" />
                                
                                <div class="flex items-center gap-3" @click.stop>
                                    <x-like-button :itemId="$poem->id" itemType="poem" :isLiked="false" :likesCount="$poem->like_count ?? 0" size="sm" />
                                    <x-comment-button :itemId="$poem->id" itemType="poem" :commentsCount="$poem->comment_count ?? 0" size="sm" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mini thumbnail (25%) - Solo se esiste -->
                        @if($poem->thumbnail_url)
                            <div class="md:w-1/4 aspect-square rounded-2xl overflow-hidden shadow-lg
                                        group-hover:scale-105 group-hover:rotate-2 transition-all duration-500">
                                <img src="{{ $poem->thumbnail_url }}" 
                                     alt="{{ $poem->title ?: __('poems.untitled') }}"
                                     class="w-full h-full object-cover opacity-70 group-hover:opacity-90 transition-opacity">
                            </div>
                        @endif
                    </div>
                </article>
                @php $i++; @endphp
            @endif
        @endwhile
    </div>
</div>
