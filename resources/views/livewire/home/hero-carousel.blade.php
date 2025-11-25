<div>
    @php
    $carouselSlides = $carousels ?? collect();
    @endphp
    
    @if ($carouselSlides->count() > 0)
    <section class="relative py-12 md:py-16 bg-white dark:bg-neutral-900 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
             x-data="{
                 currentSlide: 0,
                 slides: {{ $carouselSlides->count() }},
                 autoplayInterval: null
             }"
             x-init="
                 if (slides > 1) {
                     autoplayInterval = setInterval(() => {
                         currentSlide = (currentSlide + 1) % slides;
                     }, 6000);
                 }
             "
             @mouseenter="if (autoplayInterval) clearInterval(autoplayInterval)"
             @mouseleave="if (slides > 1) autoplayInterval = setInterval(() => { currentSlide = (currentSlide + 1) % slides; }, 6000)">
            
            <div class="relative">
                {{-- Slides Container --}}
                <div class="relative h-[400px] md:h-[500px] lg:h-[600px] rounded-2xl overflow-hidden shadow-2xl">
                    @foreach($carouselSlides as $index => $carousel)
                    <div class="absolute inset-0 transition-all duration-700 ease-in-out"
                         :class="currentSlide === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                        
                        {{-- Background Image/Video --}}
                        <div class="absolute inset-0">
                            @if($carousel->video_path && $carousel->videoUrl)
                                <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                    <source src="{{ $carousel->videoUrl }}" type="video/mp4">
                                </video>
                            @elseif($carousel->image_url || $carousel->content_image_url)
                                <img src="{{ $carousel->image_url ?? $carousel->content_image_url }}" 
                                     alt="{{ $carousel->display_title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800"></div>
                            @endif
                            
                            {{-- Overlay Gradient --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-neutral-900/80 via-neutral-900/60 to-transparent"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/90 via-transparent to-transparent"></div>
                        </div>
                        
                        {{-- Content Overlay --}}
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-2xl"
                                     x-show="currentSlide === {{ $index }}"
                                     x-transition:enter="transition ease-out duration-700 delay-200"
                                     x-transition:enter-start="opacity-0 translate-x-8"
                                     x-transition:enter-end="opacity-100 translate-x-0">
                                    
                                    @if($carousel->display_title)
                                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 md:mb-6 leading-tight" style="font-family: 'Crimson Pro', serif;">
                                        {!! $carousel->display_title !!}
                                    </h2>
                                    @endif
                                    
                                    @if($carousel->display_description)
                                    <p class="text-lg md:text-xl lg:text-2xl text-white/90 mb-6 md:mb-8 leading-relaxed">
                                        {{ \Illuminate\Support\Str::limit($carousel->display_description, 200) }}
                                    </p>
                                    @endif
                                    
                                    @if($carousel->content_type && $carousel->content_id)
                                        @if($carousel->content_type === 'poem')
                                        <button onclick="Livewire.dispatch('openPoemModal', { poemId: {{ $carousel->content_id }} })" 
                                                class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            <span>{{ $carousel->link_text ?: __('common.discover_more') }}</span>
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                        @elseif($carousel->content_type === 'article')
                                        <button onclick="Livewire.dispatch('openArticleModal', { articleId: {{ $carousel->content_id }} })" 
                                                class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            <span>{{ $carousel->link_text ?: __('common.discover_more') }}</span>
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                        @elseif($carousel->display_url)
                                        <a href="{{ $carousel->display_url }}" 
                                           class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                            <span>{{ $carousel->link_text ?: __('common.discover_more') }}</span>
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                        @endif
                                    @elseif($carousel->display_url)
                                    <a href="{{ $carousel->display_url }}" 
                                       class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <span>{{ $carousel->link_text ?: __('common.discover_more') }}</span>
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                {{-- Navigation Arrows --}}
                @if($carouselSlides->count() > 1)
                <button @click="currentSlide = (currentSlide - 1 + slides) % slides"
                        class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 bg-white/10 backdrop-blur-md border border-white/30 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <button @click="currentSlide = (currentSlide + 1) % slides"
                        class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 bg-white/10 backdrop-blur-md border border-white/30 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                @endif
                
                {{-- Dots Indicator --}}
                @if($carouselSlides->count() > 1)
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2">
                    @foreach($carouselSlides as $index => $carousel)
                        <button @click="currentSlide = {{ $index }}"
                                class="transition-all duration-300"
                                :class="currentSlide === {{ $index }} ? 'w-8 h-2 bg-white rounded-full' : 'w-2 h-2 bg-white/40 rounded-full hover:bg-white/60'">
                        </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif
</div>
