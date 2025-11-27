{{-- About Tab con animazioni e badge visibili --}}
<div class="space-y-6" 
     x-data="{ mounted: false }"
     x-init="mounted = true">
    
    {{-- About Card con animazione --}}
    <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
         x-show="mounted"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-3" style="font-family: 'Crimson Pro', serif;">
            <span class="text-3xl transform transition-transform duration-300 hover:rotate-12">👤</span>
            {{ __('profile.about.title') }}
        </h2>
        @if($user->bio)
            <p class="text-neutral-700 dark:text-neutral-300 leading-relaxed text-lg">{{ $user->bio }}</p>
        @else
            <p class="text-neutral-500 dark:text-neutral-400 italic">{{ __('profile.about.no_bio') }}</p>
        @endif
    </div>

    {{-- Info Grid con animazioni --}}
    <div class="grid sm:grid-cols-2 gap-4">
        @if($user->location)
        <div class="group bg-white dark:bg-neutral-800 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
             x-show="mounted"
             x-transition:enter="transition ease-out duration-500 delay-100"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">{{ __('profile.about.location') }}</div>
                    <div class="font-semibold text-neutral-900 dark:text-white text-lg">{{ $user->location }}</div>
                </div>
            </div>
        </div>
        @endif

        @if($user->website)
        <div class="group bg-white dark:bg-neutral-800 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
             x-show="mounted"
             x-transition:enter="transition ease-out duration-500 delay-150"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">{{ __('profile.about.website') }}</div>
                    <a href="{{ $user->website }}" target="_blank" rel="noopener" class="font-semibold text-primary-600 dark:text-primary-400 hover:underline text-lg block transform transition-transform duration-300 hover:translate-x-1">
                        {{ Str::limit($user->website, 30) }}
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($user->birth_date && ($isOwnProfile || $user->show_birth_date))
        <div class="group bg-white dark:bg-neutral-800 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
             x-show="mounted"
             x-transition:enter="transition ease-out duration-500 delay-200"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">{{ __('profile.about.birth_date') }}</div>
                    <div class="font-semibold text-neutral-900 dark:text-white text-lg">{{ $user->birth_date->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
        @endif

        @if($user->phone && ($isOwnProfile || $user->show_phone))
        <div class="group bg-white dark:bg-neutral-800 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
             x-show="mounted"
             x-transition:enter="transition ease-out duration-500 delay-250"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">{{ __('profile.about.phone') }}</div>
                    <div class="font-semibold text-neutral-900 dark:text-white text-lg">{{ $user->phone }}</div>
                </div>
            </div>
        </div>
        @endif

        @if($user->email && ($isOwnProfile || $user->show_email))
        <div class="group bg-white dark:bg-neutral-800 rounded-xl p-4 border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1"
             x-show="mounted"
             x-transition:enter="transition ease-out duration-500 delay-300"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-500 to-rose-500 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">Email</div>
                    <a href="mailto:{{ $user->email }}" class="font-semibold text-primary-600 dark:text-primary-400 hover:underline text-lg block transform transition-transform duration-300 hover:translate-x-1">
                        {{ $user->email }}
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Social Links con animazioni --}}
    @if($user->social_facebook || $user->social_instagram || $user->social_twitter || $user->social_youtube || $user->social_linkedin)
    <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-xl transition-all duration-500"
         x-show="mounted"
         x-transition:enter="transition ease-out duration-500 delay-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
            <span class="text-2xl">🔗</span>
            {{ __('profile.about.social_links') }}
        </h3>
        <div class="flex flex-wrap gap-3">
            @if($user->social_facebook)
            <a href="{{ $user->social_facebook }}" target="_blank" rel="noopener" 
               class="group flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 hover:scale-110 hover:shadow-lg transform">
                <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                <span class="text-sm font-semibold">Facebook</span>
            </a>
            @endif
            @if($user->social_instagram)
            <a href="{{ $user->social_instagram }}" target="_blank" rel="noopener" 
               class="group flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-lg transition-all duration-300 hover:scale-110 hover:shadow-lg transform">
                <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
                <span class="text-sm font-semibold">Instagram</span>
            </a>
            @endif
            @if($user->social_twitter)
            <a href="{{ $user->social_twitter }}" target="_blank" rel="noopener" 
               class="group flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-all duration-300 hover:scale-110 hover:shadow-lg transform">
                <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
                <span class="text-sm font-semibold">Twitter</span>
            </a>
            @endif
            @if($user->social_youtube)
            <a href="{{ $user->social_youtube }}" target="_blank" rel="noopener" 
               class="group flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-300 hover:scale-110 hover:shadow-lg transform">
                <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                <span class="text-sm font-semibold">YouTube</span>
            </a>
            @endif
            @if($user->social_linkedin)
            <a href="{{ $user->social_linkedin }}" target="_blank" rel="noopener" 
               class="group flex items-center gap-2 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg transition-all duration-300 hover:scale-110 hover:shadow-lg transform">
                <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                <span class="text-sm font-semibold">LinkedIn</span>
            </a>
            @endif
        </div>
    </div>
    @endif

    {{-- Badges con animazioni e design accattivante --}}
    @if($topBadges->count() > 0)
    <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-xl transition-all duration-500"
         x-show="mounted"
         x-transition:enter="transition ease-out duration-500 delay-400"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
            <span class="text-2xl transform transition-transform duration-300 hover:rotate-12">🏆</span>
            {{ __('profile.about.badges') }}
        </h3>
        <div class="flex flex-wrap gap-4">
            @foreach($topBadges as $i => $userBadge)
                @if($userBadge->badge)
                <div class="group relative overflow-hidden bg-gradient-to-br from-amber-400 via-yellow-400 to-orange-400 dark:from-amber-600 dark:via-yellow-600 dark:to-orange-600 rounded-xl p-4 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:scale-105 transform"
                     style="animation-delay: {{ $i * 0.1 }}s;"
                     x-intersect.once="$el.classList.add('animate-fade-in-up')">
                    {{-- Shine effect --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    
                    <div class="relative z-10 flex items-center gap-3">
                        @if($userBadge->badge->icon)
                            <div class="text-4xl transform transition-transform duration-300 group-hover:scale-125 group-hover:rotate-12">{{ $userBadge->badge->icon }}</div>
                        @else
                            <div class="w-12 h-12 rounded-full bg-white/30 dark:bg-white/20 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-125 group-hover:rotate-12">
                                <span class="text-2xl">🏆</span>
                            </div>
                        @endif
                        <div>
                            <div class="font-bold text-white text-lg drop-shadow-lg">{{ $userBadge->badge->name }}</div>
                            @if($userBadge->badge->description)
                            <div class="text-white/90 text-sm mt-1">{{ $userBadge->badge->description }}</div>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Glow effect --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-300/50 to-orange-300/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-xl blur-xl"></div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
</div>
