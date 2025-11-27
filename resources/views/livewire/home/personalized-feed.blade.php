<div class="py-16 bg-gradient-to-br from-neutral-50 via-white to-primary-50/30 dark:from-neutral-900 dark:via-neutral-900 dark:to-primary-900/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 dark:text-white">
                {!! __('feed.title') !!}
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400 mt-2">
                {{ __('feed.subtitle') }}
            </p>
        </div>

        <!-- Feed Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Feed (Left 2/3) -->
            <div class="lg:col-span-2 space-y-6">
                @foreach($feedItems as $index => $item)
                    @if($item['type'] === 'poem')
                        <!-- Poem Card - Paper Sheet Style (Homepage Match) -->
                        <?php $paperRotation = rand(-2, 2); ?>
                        <div class="poetry-card-container mb-6">
                            <div class="paper-sheet-wrapper" style="transform: rotate({{ $paperRotation }}deg);">
                                <div class="paper-sheet group cursor-pointer" 
                                     onclick="Livewire.dispatch('openPoemModal', { poemId: {{ $item['id'] }} })">
                                    <!-- Author Avatar & Name -->
                                    <div class="paper-author-info">
                                        <img src="{{ $item['author']['avatar'] }}" 
                                             alt="{{ $item['author']['name'] }}"
                                             class="paper-avatar">
                                        <span class="paper-author-name">
                                            {{ $item['author']['name'] }}
                                        </span>
                                    </div>
                                    
                                    <!-- Poem Title -->
                                    <h3 class="paper-title">
                                        "{{ $item['title'] }}"
                                    </h3>
                                    
                                    <!-- Poem Content -->
                                    <div class="paper-content">
                                        {{ $item['excerpt'] }}
                                    </div>
                                    
                                    <!-- Read more hint -->
                                    <div class="paper-readmore">
                                        {{ __('common.read_more') }} →
                                    </div>
                                    
                                    <!-- Social Actions - Inside Paper -->
                                    <div class="paper-actions-integrated" @click.stop>
                                        <x-like-button 
                                            :itemId="$item['id']"
                                            itemType="poem"
                                            :isLiked="$item['is_liked']"
                                            :likesCount="$item['likes_count']"
                                            size="sm" />
                                        
                                        <x-comment-button 
                                            :itemId="$item['id']"
                                            itemType="poem"
                                            :commentsCount="$item['comments_count']"
                                            size="sm" />
                                        
                                        <x-share-button 
                                            :itemId="$item['id']"
                                            itemType="poem"
                                            size="sm" />
                                        
                                        <x-report-button 
                                            :itemId="$item['id']"
                                            itemType="poem"
                                            size="sm" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif($item['type'] === 'article')
                        <!-- Article Card - Magazine Cover Style (Homepage Match) -->
                        <?php
                            $rotation = rand(-3, 3);
                            $pinColor = ['#e53e3e', '#3182ce', '#38a169', '#d69e2e', '#805ad5'][rand(0, 4)];
                            $pinRotation = rand(-15, 15);
                        ?>
                        <article class="magazine-article-wrapper mb-6">
                            <!-- Thumbtack/Puntina -->
                            <div class="thumbtack" 
                                 style="background: {{ $pinColor }}; transform: rotate({{ $pinRotation }}deg);">
                                <div class="thumbtack-needle"></div>
                            </div>
                            
                            <!-- Magazine Cover -->
                            <div class="magazine-cover" style="transform: rotate({{ $rotation }}deg);">
                                <div onclick="Livewire.dispatch('openArticleModal', { articleId: {{ $item['id'] }} })" 
                                     class="magazine-inner group cursor-pointer">
                                    <!-- Magazine Header -->
                                    <div class="magazine-header">
                                        <div class="magazine-logo">{{ strtoupper(config('app.name')) }}</div>
                                        <div class="magazine-issue">Vol. {{ date('Y') }} · N.{{ str_pad($item['id'], 2, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                    
                                    <!-- Category Badge -->
                                    <div class="magazine-category">
                                        Cultura
                                    </div>
                                    
                                    <!-- Featured Image -->
                                    @if(isset($item['image']) && $item['image'])
                                    <div class="magazine-image">
                                        <img src="{{ $item['image'] }}" 
                                             alt="{{ $item['title'] }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    </div>
                                    @endif
                                    
                                    <!-- Article Title -->
                                    <h3 class="magazine-title">
                                        {{ $item['title'] }}
                                    </h3>
                                    
                                    <!-- Excerpt -->
                                    <p class="magazine-excerpt">
                                        {{ $item['excerpt'] }}
                                    </p>
                                    
                                    <!-- Author Info with Avatar -->
                                    <div class="magazine-author">
                                        <img src="{{ $item['author']['avatar'] }}" 
                                             alt="{{ $item['author']['name'] }}"
                                             class="magazine-avatar">
                                        <div class="magazine-author-info">
                                            <span class="magazine-author-name">
                                                {{ $item['author']['name'] }}
                                            </span>
                                            <div class="magazine-author-date">{{ $item['created_at'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Social Actions -->
                                <div class="magazine-actions" @click.stop>
                                    <x-like-button 
                                        :itemId="$item['id']"
                                        itemType="article"
                                        :isLiked="$item['is_liked']"
                                        :likesCount="$item['likes_count']"
                                        size="sm" />
                                    
                                    <x-comment-button 
                                        :itemId="$item['id']"
                                        itemType="article"
                                        :commentsCount="$item['comments_count']"
                                        size="sm" />
                                    
                                    <x-share-button 
                                        :itemId="$item['id']"
                                        itemType="article"
                                        size="sm" />
                                    
                                    <x-report-button 
                                        :itemId="$item['id']"
                                        itemType="article"
                                        size="sm" />
                                </div>
                            </div>
                        </article>

                    @elseif($item['type'] === 'event')
                        <!-- Event Card - Cinema Ticket Style (Homepage Match) -->
                        <?php
                            $tilt = rand(-3, 3);
                            $ticketColors = [
                                ['#fef7e6', '#fdf3d7', '#fcf0cc'],
                                ['#fff5e1', '#fff0d4', '#ffecc7'],
                                ['#f5f5dc', '#f0f0d0', '#ebebc4'],
                            ];
                            $selectedColors = $ticketColors[array_rand($ticketColors)];
                            $stampRotation = rand(-8, 8);
                        ?>
                        <div class="mb-6">
                            <a href="{{ route('events.show', $item['id']) }}" 
                               class="cinema-ticket group cursor-pointer block"
                               style="transform: rotate({{ $tilt }}deg); 
                                      background: linear-gradient(135deg, {{ $selectedColors[0] }} 0%, {{ $selectedColors[1] }} 50%, {{ $selectedColors[2] }} 100%);">
                                
                                <!-- Perforated Left Edge -->
                                <div class="ticket-perforation"></div>
                                
                                <!-- Watermark Logo -->
                                <div class="ticket-watermark">
                                    <img src="{{ asset('assets/images/filigrana.png') }}" 
                                         alt="Slamin" 
                                         class="w-32 h-auto md:w-40">
                                </div>
                                
                                <!-- Ticket Main Content -->
                                <div class="ticket-content">
                                    <!-- Ticket Header -->
                                    <div class="ticket-header">
                                        <div class="ticket-admit">EVENTO</div>
                                        <div class="ticket-serial">#{{ str_pad($item['id'], 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                    
                                    <!-- Event Image (if available) -->
                                    @if(isset($item['image']) && $item['image'])
                                    <div class="ticket-image">
                                        <img src="{{ $item['image'] }}" 
                                             alt="{{ $item['title'] }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                    @endif
                                    
                                    <!-- Event Title -->
                                    <h3 class="ticket-title">{{ $item['title'] }}</h3>
                                    
                                    <!-- Price Badge -->
                                    <div class="ticket-price" style="transform: rotate({{ $stampRotation }}deg);">
                                        GRATIS
                                    </div>
                                    
                                    <!-- Event Details Grid -->
                                    <div class="ticket-details">
                                        <div class="ticket-detail-item">
                                            <div class="ticket-detail-label">DATA</div>
                                            <div class="ticket-detail-value">{{ $item['date'] }}</div>
                                        </div>
                                        
                                        <div class="ticket-detail-item">
                                            <div class="ticket-detail-label">LUOGO</div>
                                            <div class="ticket-detail-value ticket-location">
                                                <svg class="location-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                <span>{{ $item['location'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    @elseif($item['type'] === 'video')
                        <!-- Video Card - Film Strip Style (Homepage Match) -->
                        <?php $tilt = rand(-1, 1); ?>
                        <div class="mb-6">
                            <div class="film-strip-container cursor-pointer" 
                                 onclick="Livewire.dispatch('openVideoModal', { videoId: {{ $item['id'] }} })"
                                 style="transform: rotate({{ $tilt }}deg);">
                                <!-- Film Perforations Left -->
                                <div class="film-perforation film-perforation-left">
                                    @for($h = 0; $h < 8; $h++)
                                    <div class="perforation-hole"></div>
                                    @endfor
                                </div>
                                
                                <!-- Film Perforations Right -->
                                <div class="film-perforation film-perforation-right">
                                    @for($h = 0; $h < 8; $h++)
                                    <div class="perforation-hole"></div>
                                    @endfor
                                </div>
                                
                                <!-- Film Edge Codes -->
                                <div class="film-edge-code-top">{{ strtoupper(config('app.name')) }}</div>
                                <div class="film-edge-code-bottom">ISO 400</div>
                                
                                <!-- Film Frame -->
                                <div class="film-frame">
                                    <!-- Frame Numbers -->
                                    <div class="film-frame-number film-frame-number-tl">///{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="film-frame-number film-frame-number-tr">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}A</div>
                                
                                    <!-- Video Container -->
                                    <div class="relative aspect-video overflow-hidden bg-black cursor-pointer group">
                                        <!-- Video Thumbnail -->
                                        <img src="{{ $item['thumbnail'] }}" 
                                             alt="{{ $item['title'] }}" 
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        
                                        <!-- Dark Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/40"></div>
                                        
                                        <!-- Play Button -->
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-14 h-14 md:w-16 md:h-16 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-all duration-300">
                                                <svg class="w-6 h-6 md:w-7 md:h-7 text-primary-600 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Title -->
                                        <div class="absolute top-0 left-0 right-0 pt-4 px-4">
                                            <h3 class="text-sm md:text-lg font-bold text-white drop-shadow-lg line-clamp-2" 
                                                style="font-family: 'Crimson Pro', serif;">
                                                {{ $item['title'] }}
                                            </h3>
                                        </div>
                                        
                                        <!-- Duration Badge -->
                                        <div class="absolute bottom-4 right-4 px-2 py-1 bg-black/80 text-white text-xs font-semibold rounded">
                                            {{ $item['duration'] }}
                                        </div>
                                    </div>
                                    
                                    <!-- User & Social Stats -->
                                    <div class="mt-3 px-3 pb-3 space-y-2">
                                        <!-- User Info -->
                                        <div class="flex items-center gap-2">
                                            <img src="{{ $item['author']['avatar'] }}" 
                                                 alt="{{ $item['author']['name'] }}"
                                                 class="w-7 h-7 md:w-8 md:h-8 rounded-full object-cover ring-1 ring-white/30">
                                            <p class="font-semibold text-xs md:text-sm text-white/90">{{ $item['author']['name'] }}</p>
                                        </div>
                                        
                                    <!-- Social Buttons -->
                                    <div class="flex items-center gap-4 text-white/90" @click.stop>
                                            <!-- Views -->
                                            <div class="inline-flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <span class="text-xs md:text-sm">{{ $item['views_count'] }}</span>
                                            </div>
                                            
                                            <!-- Like -->
                                            <x-like-button 
                                                :itemId="$item['id']"
                                                itemType="video"
                                                :isLiked="$item['is_liked']"
                                                :likesCount="$item['likes_count']"
                                                size="sm"
                                                class="[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6" />
                                            
                                            <!-- Share -->
                                            <x-share-button 
                                                :itemId="$item['id']"
                                                itemType="video"
                                                size="sm"
                                                class="[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-5 [&_svg]:h-5 md:[&_svg]:w-6 md:[&_svg]:h-6" />
                                            
                                            <!-- Report -->
                                            <x-report-button 
                                                :itemId="$item['id']"
                                                itemType="video"
                                                size="sm" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif($item['type'] === 'gallery')
                        <!-- Gallery Card -->
                        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                            <div class="p-6 flex items-center justify-between border-b border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item['author']['avatar'] }}" alt="{{ $item['author']['name'] }}" 
                                         class="w-12 h-12 rounded-full object-cover ring-2 ring-primary-200">
                                    <div>
                                        <h3 class="font-semibold text-neutral-900 dark:text-white">{{ $item['author']['name'] }}</h3>
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $item['created_at'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ $item['title'] }}</h4>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach($item['images'] as $idx => $image)
                                        <div class="aspect-square overflow-hidden rounded-xl {{ $idx === 2 ? 'relative' : '' }}">
                                            <img src="{{ $image }}" alt="Photo {{ $idx + 1 }}" 
                                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-300 cursor-pointer">
                                            @if($idx === 2 && $item['photos_count'] > 3)
                                                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center cursor-pointer hover:bg-black/50 transition-colors">
                                                    <span class="text-white text-2xl font-bold">+{{ $item['photos_count'] - 3 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex items-center justify-between mt-4 pt-4 border-t border-neutral-100 dark:border-neutral-700">
                                    <span class="text-sm text-neutral-600 dark:text-neutral-400">
                                        {{ $item['photos_count'] }} {{ __('feed.photos') }}
                                    </span>
                                    <div class="flex items-center gap-4">
                                        <!-- Gallery likes temporaneamente disabilitati finché non avremo un modello Gallery -->
                                        <div class="flex items-center gap-2 text-neutral-400">
                                            <img src="{{ asset('assets/icon/new/like.svg') }}" 
                                                 alt="Like" 
                                                 class="w-5 h-5 opacity-50"
                                                 style="filter: brightness(0) saturate(100%) invert(60%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(89%) contrast(86%);">
                                            <span class="font-medium text-sm">{{ $item['likes_count'] }}</span>
                                        </div>
                                        
                                        <x-share-button 
                                            :item-id="$item['id']"
                                            :item-type="$item['type']"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Sidebar (Right 1/3) -->
            <div class="space-y-6">
                
                <!-- Trending Topics - GLOBALE -->
                <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="text-lg font-bold mb-4">🔥 {{ __('feed.trending') }}</h3>
                    <div class="space-y-3">
                        @forelse($trendingTopics as $topic)
                        <div class="flex items-center justify-between hover:bg-white/10 -mx-2 px-2 py-2 rounded-lg transition-colors cursor-pointer">
                            <span class="text-sm font-medium">{{ $topic['tag'] }}</span>
                            <span class="text-xs bg-white/20 px-2.5 py-1 rounded-full font-semibold">
                                {{ $topic['count'] > 1000 ? number_format($topic['count'] / 1000, 1) . 'K' : $topic['count'] }}
                            </span>
                        </div>
                        @empty
                        <div class="text-sm text-white/70 italic">
                            {{ __('feed.no_trending_yet') }}
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">
                        ⚡ {{ __('feed.quick_actions') }}
                    </h3>
                    <div class="space-y-2">
                        @can('create.poem')
                        <a href="{{ route('poems.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-neutral-900 dark:text-white">{{ __('feed.write_poem') }}</span>
                        </a>
                        @endcan
                        @can('upload.video')
                        <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-neutral-900 dark:text-white">{{ __('feed.upload_video') }}</span>
                        </a>
                        @endcan
                        @can('create.event')
                        <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors group">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-neutral-900 dark:text-white">{{ __('feed.create_event') }}</span>
                        </a>
                        @endcan
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    {{-- Modals for content --}}
    <livewire:poems.poem-modal />
    <livewire:articles.article-modal />
    <livewire:media.video-modal />
</div>
