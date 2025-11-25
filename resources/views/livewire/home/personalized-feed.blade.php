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
                        <!-- Poem Card -->
                        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                            <!-- Author Header -->
                            <div class="p-6 flex items-center justify-between border-b border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item['author']['avatar'] }}" alt="{{ $item['author']['name'] }}" 
                                         class="w-12 h-12 rounded-full object-cover ring-2 ring-primary-200">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-semibold text-neutral-900 dark:text-white">{{ $item['author']['name'] }}</h3>
                                            @if($item['author']['verified'])
                                                <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $item['created_at'] }}</p>
                                    </div>
                                </div>
                                <button class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300" title="{{ __('common.more_options') }}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Poem Content -->
                            <div class="p-6">
                                <h4 class="text-2xl font-bold text-neutral-900 dark:text-white mb-3 group-hover:text-primary-600 transition-colors">
                                    {{ $item['title'] }}
                                </h4>
                                <p class="text-neutral-600 dark:text-neutral-300 leading-relaxed italic">
                                    "{{ $item['excerpt'] }}"
                                </p>
                            </div>

                            @if(isset($item['image']) && $item['image'])
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @endif

                             <!-- Actions -->
                            <div class="p-6 border-t border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center gap-6">
                                    <x-like-button 
                                        :item-id="$item['id']"
                                        :item-type="$item['type']"
                                        :is-liked="$item['is_liked']"
                                        :likes-count="$item['likes_count']"
                                    />
                                    
                                    <x-comment-button 
                                        :item-id="$item['id']"
                                        :item-type="$item['type']"
                                        :comments-count="$item['comments_count']"
                                    />
                                    
                                    <x-share-button 
                                        :item-id="$item['id']"
                                        :item-type="$item['type']"
                                    />
                                </div>
                            </div>
                        </div>

                    @elseif($item['type'] === 'article')
                        <!-- Article Card -->
                        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                            @if(isset($item['image']) && $item['image'])
                                <div class="aspect-video overflow-hidden relative">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 bg-accent text-white text-xs font-semibold rounded-full shadow-lg">
                                            📝 {{ __('feed.article_badge') ?? 'Articolo' }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <!-- Author Info -->
                            <div class="p-6 flex items-center justify-between border-b border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item['author']['avatar'] }}" alt="{{ $item['author']['name'] }}" 
                                         class="w-12 h-12 rounded-full object-cover ring-2 ring-accent/20">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-bold text-neutral-900 dark:text-white">{{ $item['author']['name'] }}</h3>
                                            @if($item['author']['verified'])
                                                <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $item['created_at'] }}</p>
                                    </div>
                                </div>
                                <button class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300" title="{{ __('common.more_options') }}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Article Content -->
                            <div class="p-6">
                                <h4 class="text-2xl font-bold text-neutral-900 dark:text-white mb-3 group-hover:text-accent transition-colors">
                                    {{ $item['title'] }}
                                </h4>
                                <p class="text-neutral-600 dark:text-neutral-300 leading-relaxed">
                                    {{ $item['excerpt'] }}
                                </p>
                            </div>

                             <!-- Actions -->
                            <div class="p-6 border-t border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center gap-6">
                                    <x-like-button 
                                        :item-id="$item['id']"
                                        :item-type="$item['type']"
                                        :is-liked="$item['is_liked']"
                                        :likes-count="$item['likes_count']"
                                    />
                                    
                                    <x-comment-button 
                                        :item-id="$item['id']"
                                        :item-type="$item['type']"
                                        :comments-count="$item['comments_count']"
                                    />
                                    
                                    <x-share-button 
                                        :item-id="$item['id']"
                                        :item-type="$item['type']"
                                    />
                                </div>
                            </div>
                        </div>

                    @elseif($item['type'] === 'event')
                        <!-- Event Card -->
                        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                            <div class="relative">
                                <div class="aspect-[21/9] overflow-hidden">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="absolute top-4 left-4">
                                    <span class="px-4 py-2 bg-primary-600 text-white text-sm font-semibold rounded-full shadow-lg">
                                        📅 {{ __('feed.event_badge') }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="text-2xl font-bold text-neutral-900 dark:text-white mb-3 group-hover:text-primary-600 transition-colors">
                                    {{ $item['title'] }}
                                </h4>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center gap-3 text-neutral-600 dark:text-neutral-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ $item['date'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-neutral-600 dark:text-neutral-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span>{{ $item['location'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-neutral-600 dark:text-neutral-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span>{{ $item['participants_count'] }} {{ __('feed.participants') }}</span>
                                    </div>
                                </div>
                                <button wire:click="attendEvent({{ $item['id'] }})" 
                                        class="w-full px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ __('feed.attend_event') }}
                                </button>
                            </div>
                        </div>

                    @elseif($item['type'] === 'video')
                        <!-- Video Card -->
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
                            <div class="relative aspect-video overflow-hidden bg-neutral-900 group cursor-pointer">
                                <img src="{{ $item['thumbnail'] }}" alt="{{ $item['title'] }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                    <div class="w-16 h-16 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-2xl">
                                        <svg class="w-8 h-8 text-primary-600 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="absolute bottom-4 right-4 px-3 py-1 bg-black/80 backdrop-blur-sm text-white text-sm font-semibold rounded-lg">
                                    {{ $item['duration'] }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ $item['title'] }}</h4>
                                <div class="flex items-center gap-6">
                                    <x-like-button 
                                        :item-id="$item['id']"
                                        :item-type="$item['type']"
                                        :is-liked="$item['is_liked']"
                                        :likes-count="$item['likes_count']"
                                    />
                                    
                                    <!-- Views -->
                                    <div class="flex items-center gap-2 text-neutral-500 dark:text-neutral-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span class="font-medium text-sm">{{ $item['views_count'] }}</span>
                                    </div>
                                    
                                    <x-share-button 
                                        :item-id="$item['id']"
                                        :item-type="$item['type']"
                                    />
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
</div>

