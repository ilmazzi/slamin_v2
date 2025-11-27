<div class="-mt-16">
@php
    $primaryRole = optional($user->roles->first())->display_name ?? optional($user->roles->first())->name ?? null;
@endphp

<div class="profile-cinematic" 
     x-data="{ scrollY: 0, scrollProgress: 0 }" 
     x-init="
         window.addEventListener('scroll', () => {
             scrollY = window.scrollY;
             scrollProgress = Math.min(scrollY / 1000, 1);
         }, { passive: true });
     ">
    
    {{-- HERO IMMERSIVO CON PARALLAX --}}
    <section class="hero-immersive">
        {{-- Background layers con parallax --}}
        <div class="parallax-bg" :style="`transform: translateY(${scrollY * 0.5}px)`">
            @if($user->banner_image_url)
                <img src="{{ $user->banner_image_url }}" alt="" class="banner-blur">
            @else
                <div class="banner-gradient"></div>
            @endif
        </div>

        {{-- Animated particles --}}
        <canvas id="particles-canvas" class="particles-layer"></canvas>

        {{-- Hero content --}}
        <div class="hero-content-wrap" :style="`opacity: ${1 - scrollProgress}`">
            <div class="hero-inner">
                {{-- Avatar con effetto 3D --}}
                <div class="avatar-3d" :style="`transform: translateY(${scrollY * 0.2}px) rotateX(${scrollProgress * 20}deg)`">
                    <div class="avatar-ring-outer"></div>
                    <div class="avatar-ring-middle"></div>
                    <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($user, 500) }}"
                         alt="{{ \App\Helpers\AvatarHelper::getDisplayName($user) }}"
                         class="avatar-img">
                    @if($user->verified_at ?? false)
                        <div class="verified-seal">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Info principale --}}
                <div class="hero-info" :style="`transform: translateY(${scrollY * 0.15}px)`">
                    @if($primaryRole)
                        <div class="role-tag">{{ $primaryRole }}</div>
                    @endif
                    <h1 class="name-title">{{ $user->name }}</h1>
                    @if($user->nickname)
                        <p class="handle">{{ $user->nickname }}</p>
                    @endif
                    @if($user->bio)
                        <p class="bio-text">{{ $user->bio }}</p>
                    @endif

                    {{-- User Languages con bandiere E LIVELLO - SPOSTATE IN ALTO --}}
                    @if($user->languages && $user->languages->count() > 0)
                        <div class="languages-compact">
                            @foreach($user->languages as $language)
                                <span class="language-flag-tag {{ $language->type }}">
                                    <span class="flag-emoji">{{ $language->language_code === 'it' ? '🇮🇹' : ($language->language_code === 'en' ? '🇬🇧' : ($language->language_code === 'fr' ? '🇫🇷' : ($language->language_code === 'es' ? '🇪🇸' : ($language->language_code === 'de' ? '🇩🇪' : '🌐')))) }}</span>
                                    <span class="language-name">{{ $language->language_name }}</span>
                                    @if($language->type === 'native')
                                        <span class="language-badge-inline native">{{ __('profile.native') }}</span>
                                    @else
                                        <span class="language-type-badge {{ $language->type }}">
                                            {{ $language->type === 'spoken' ? '🗣️' : '✍️' }}
                                            {{ __('languages.' . $language->type) }}
                                        </span>
                                        @if($language->level)
                                            <span class="language-level-inline">{{ __('profile.' . $language->level) }}</span>
                                        @endif
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @endif

                    {{-- User Badges - SPOSTATI IN ALTO PRIMA DELLE STATS --}}
                    @if($topBadges && $topBadges->count() > 0)
                        <div class="user-badges-large">
                            @foreach($topBadges as $userBadge)
                                <div class="badge-item-large" title="{{ $userBadge->badge->name }}">
                                    <img src="{{ $userBadge->badge->icon_url }}"
                                         alt="{{ $userBadge->badge->name }}"
                                         class="badge-icon-large">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Stats inline - SENZA CARD DI SFONDO, SOLO CARD SINGOLE --}}
                    <div class="stats-inline">
                        <div class="stat-item">
                            <span class="stat-num">{{ $stats['poems'] }}</span>
                            <span class="stat-lbl">{{ __('profile.stats.poems') }}</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-num">{{ $stats['articles'] }}</span>
                            <span class="stat-lbl">{{ __('profile.stats.articles') }}</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-num">{{ $stats['videos'] }}</span>
                            <span class="stat-lbl">{{ __('profile.stats.videos') }}</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-num">{{ number_format($stats['total_views']) }}</span>
                            <span class="stat-lbl">{{ __('profile.stats.views') }}</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-num">{{ $user->level ?? 1 }}</span>
                            <span class="stat-lbl">Livello</span>
                        </div>
                        <div class="stat-divider"></div>
                        <a href="{{ route('user.followers', $user) }}" class="stat-item hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                            <span class="stat-num">{{ $stats['followers'] }}</span>
                            <span class="stat-lbl">{{ __('follow.followers') }}</span>
                        </a>
                        <div class="stat-divider"></div>
                        <a href="{{ route('user.following', $user) }}" class="stat-item hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                            <span class="stat-num">{{ $stats['following'] }}</span>
                            <span class="stat-lbl">{{ __('follow.following_users') }}</span>
                        </a>
                    </div>

                    {{-- Follow Button (only if not own profile) --}}
                    @if(!$isOwnProfile)
                        <div class="mt-4 flex justify-center">
                            <livewire:components.follow-button :userId="$user->id" size="md" variant="default" />
                        </div>
                    @endif


                    {{-- Social Links --}}
                    @if($user->social_facebook || $user->social_instagram || $user->social_twitter || $user->social_youtube || $user->social_linkedin)
                        <div class="social-links">
                            @if($user->social_facebook)
                                <a href="{{ $user->social_facebook }}" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($user->social_instagram)
                                <a href="{{ $user->social_instagram }}" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($user->social_twitter)
                                <a href="{{ $user->social_twitter }}" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                </a>
                            @endif
                            @if($user->social_youtube)
                                <a href="{{ $user->social_youtube }}" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                            @if($user->social_linkedin)
                                <a href="{{ $user->social_linkedin }}" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="scroll-indicator" :style="`opacity: ${1 - scrollProgress}`">
            <div class="scroll-line"></div>
            <span>{{ __('profile.scroll_to_explore') }}</span>
        </div>
    </section>

    {{-- Action Buttons Bar (only for own profile) - STICKY --}}
    @if($isOwnProfile)
        <div class="sticky top-16 z-40 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md border-b border-neutral-200 dark:border-neutral-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        {{ __('profile.edit_profile') }}
                    </a>
                    <a href="{{ route('profile.my-media') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-neutral-700 hover:bg-neutral-800 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('profile.manage_media') }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- ABOUT SECTION --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @include('livewire.profile.tabs.about', [
            'user' => $user,
            'isOwnProfile' => $isOwnProfile,
            'topBadges' => $topBadges
        ])
    </section>

    {{-- HORIZONTAL SCROLL SECTIONS --}}
    <div class="content-sections">
        
        {{-- Poems Section --}}
        @if($poems->count() > 0)
        <section class="section-horizontal poems-section" data-section="poems">
            <div class="section-title-vertical">
                <h2>{{ __('profile.poems.title') }}</h2>
                <a href="{{ route('poems.index') }}" class="view-all-link">{{ __('common.view_all') }}</a>
            </div>
            <div class="horizontal-scroll-container">
                <div class="scroll-track">
                    @foreach($poems as $poem)
                    <div class="poem-paper" onclick="Livewire.dispatch('openPoemModal', { poemId: {{ $poem->id }} })">
                        <div class="paper-texture"></div>
                        <div class="paper-content">
                            <div class="author-stamp">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($poem->user, 60) }}" alt="">
                                <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($poem->user) }}" onclick="event.stopPropagation();">
                                    {{ \App\Helpers\AvatarHelper::getDisplayName($poem->user) }}
                                </a>
                            </div>
                            <h3>"{{ $poem->title ?: __('poems.untitled') }}"</h3>
                            <p>{{ Str::limit(strip_tags($poem->content), 150) }}</p>
                            <div class="paper-footer" @click.stop>
                                <x-like-button :itemId="$poem->id" itemType="poem" :isLiked="$poem->is_liked ?? false" :likesCount="$poem->like_count ?? 0" size="sm" />
                                <x-comment-button :itemId="$poem->id" itemType="poem" :commentsCount="$poem->comment_count ?? 0" size="sm" />
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Articles Section --}}
        @if($articles->count() > 0)
        <section class="section-horizontal articles-section" data-section="articles">
            <div class="section-title-vertical">
                <h2>{{ __('profile.articles.title') }}</h2>
                <a href="{{ route('articles.index') }}" class="view-all-link">{{ __('common.view_all') }}</a>
            </div>
            <div class="horizontal-scroll-container">
                <div class="scroll-track">
                    @foreach($articles as $article)
                    <div class="article-magazine" onclick="Livewire.dispatch('openArticleModal', { articleId: {{ $article->id }} })">
                        @if($article->featured_image_url)
                        <div class="magazine-cover" style="background-image: url('{{ $article->featured_image_url }}');"></div>
                        @endif
                        <div class="magazine-info">
                            @if($article->category)
                            <span class="magazine-category">{{ $article->category->name }}</span>
                            @endif
                            <h3>{{ $article->title }}</h3>
                            <p>{{ Str::limit($article->excerpt ?? strip_tags($article->content), 100) }}</p>
                            <div class="magazine-footer" @click.stop>
                                <x-like-button :itemId="$article->id" itemType="article" :isLiked="$article->is_liked ?? false" :likesCount="$article->like_count ?? 0" size="sm" />
                                <x-comment-button :itemId="$article->id" itemType="article" :commentsCount="$article->comment_count ?? 0" size="sm" />
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Media Section --}}
        @if($videos->count() > 0 || $photos->count() > 0)
        <section class="section-horizontal media-section" data-section="media">
            <div class="section-title-vertical">
                <h2>{{ __('profile.media.title') }}</h2>
                <a href="{{ route('media.index') }}" class="view-all-link">{{ __('common.view_all') }}</a>
            </div>
            <div class="horizontal-scroll-container">
                <div class="scroll-track">
                    @foreach($videos as $video)
                    <a href="{{ route('media.video.show', $video->uuid) }}" class="media-filmstrip">
                        @if($video->thumbnail_url)
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}">
                        @endif
                        <div class="film-overlay">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                        </div>
                        <div class="film-title">{{ $video->title }}</div>
                    </a>
                    @endforeach

                    @foreach($photos as $photo)
                    <a href="#" onclick="Livewire.dispatch('openPhotoModal', { photoId: {{ $photo->id }} }); return false;" class="media-polaroid">
                        <img src="{{ $photo->image_url ?? $photo->thumbnail_url }}" alt="{{ $photo->title ?? __('media.untitled') }}">
                        <div class="polaroid-caption">{{ $photo->title ?? __('media.untitled') }}</div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Events Section --}}
        @if($events->count() > 0)
        <section class="section-horizontal events-section" data-section="events">
            <div class="section-title-vertical">
                <h2>{{ __('profile.events.title') }}</h2>
                <a href="{{ route('events.index') }}" class="view-all-link">{{ __('common.view_all') }}</a>
            </div>
            <div class="horizontal-scroll-container">
                <div class="scroll-track">
                    @foreach($events as $event)
                    <div class="event-ticket-wrapper">
                        <x-event-ticket :event="$event" />
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('livewire:init', () => {
    // Particles animation
    const canvas = document.getElementById('particles-canvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        const particleCount = 50;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 3 + 1;
                this.speedX = Math.random() * 0.5 - 0.25;
                this.speedY = Math.random() * 0.5 - 0.25;
                this.opacity = Math.random() * 0.5 + 0.2;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x > canvas.width) this.x = 0;
                if (this.x < 0) this.x = canvas.width;
                if (this.y > canvas.height) this.y = 0;
                if (this.y < 0) this.y = canvas.height;
            }

            draw() {
                ctx.fillStyle = `rgba(74, 124, 89, ${this.opacity})`;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });
            requestAnimationFrame(animate);
        }

        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    }

    // Horizontal scroll with mouse wheel (only when hovering the container)
    document.querySelectorAll('.horizontal-scroll-container').forEach(container => {
        let isHovering = false;
        
        container.addEventListener('mouseenter', () => {
            isHovering = true;
        });
        
        container.addEventListener('mouseleave', () => {
            isHovering = false;
        });
        
        container.addEventListener('wheel', (e) => {
            if (isHovering && Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                e.preventDefault();
                container.scrollLeft += e.deltaY;
            }
        }, { passive: false });
    });
});
</script>
@endpush

{{-- Photo Modal Component --}}
@livewire('media.photo-modal')

</div>
