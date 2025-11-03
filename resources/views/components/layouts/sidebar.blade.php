<div x-data="{ 
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        mobileOpen: false 
     }"
     @toggle-sidebar.window="mobileOpen = !mobileOpen"
     x-init="$watch('collapsed', value => { 
         localStorage.setItem('sidebarCollapsed', value);
         $dispatch('sidebar-changed', { collapsed: value });
     })">

<!-- Desktop Sidebar - Hidden on Mobile -->
<aside class="hidden lg:fixed lg:block left-0 top-16 bottom-0 bg-white dark:bg-neutral-900 border-r border-neutral-200 dark:border-neutral-800 transition-all duration-300 z-40"
       :class="collapsed ? 'w-20' : 'w-64'"
    
    <!-- Sidebar Content -->
    <div class="flex flex-col h-full">
        <!-- User Info (Top) -->
        @auth
        <div class="p-4 border-b border-neutral-200 dark:border-neutral-800"
             :class="collapsed && 'px-2'">
            <div class="flex items-center gap-3"
                 :class="collapsed && 'justify-center'">
                <img src="{{ auth()->user()->profile_photo_url }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-200 flex-shrink-0">
                <div x-show="!collapsed" x-transition class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-neutral-900 dark:text-white truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-neutral-500 truncate">
                        {{ auth()->user()->nickname ?? auth()->user()->email }}
                    </p>
                </div>
            </div>
        </div>
        @endauth

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
            <ul class="space-y-1">
                <!-- Home -->
                <li>
                    <a href="{{ route('home') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group"
                       :class="collapsed && 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span x-show="!collapsed" x-transition class="text-sm font-medium">Home</span>
                    </a>
                </li>

                <!-- Eventi -->
                <li>
                    <a href="{{ route('events.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group"
                       :class="collapsed && 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span x-show="!collapsed" x-transition class="text-sm font-medium">Eventi</span>
                    </a>
                </li>

                @auth
                <!-- Gigs -->
                <li>
                    <a href="#" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group"
                       :class="collapsed && 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span x-show="!collapsed" x-transition class="text-sm font-medium">Gigs</span>
                    </a>
                </li>
                @endauth

                <!-- Media -->
                <li>
                    <a href="#" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group"
                       :class="collapsed && 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span x-show="!collapsed" x-transition class="text-sm font-medium">Media</span>
                    </a>
                </li>

                <!-- Poesie -->
                <li>
                    <a href="{{ route('poems.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group"
                       :class="collapsed && 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span x-show="!collapsed" x-transition class="text-sm font-medium">Poesie</span>
                    </a>
                </li>

                <!-- Articoli -->
                <li>
                    <a href="{{ route('articles.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group"
                       :class="collapsed && 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span x-show="!collapsed" x-transition class="text-sm font-medium">Articoli</span>
                    </a>
                </li>

                <!-- Galleria -->
                <li>
                    <a href="{{ route('gallery.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group"
                       :class="collapsed && 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span x-show="!collapsed" x-transition class="text-sm font-medium">Galleria</span>
                    </a>
                </li>

                @auth
                <!-- Gruppi -->
                <li>
                    <a href="#" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group"
                       :class="collapsed && 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span x-show="!collapsed" x-transition class="text-sm font-medium">Gruppi</span>
                    </a>
                </li>

                <!-- Forum -->
                <li>
                    <a href="#" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group"
                       :class="collapsed && 'justify-center'">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span x-show="!collapsed" x-transition class="text-sm font-medium">Forum</span>
                    </a>
                </li>
                @endauth
            </ul>
        </nav>

        <!-- Bottom Actions -->
        <div class="p-3 border-t border-neutral-200 dark:border-neutral-800">
            <!-- Collapse Toggle -->
            <button @click="collapsed = !collapsed"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400 transition-all"
                    :class="collapsed && 'justify-center'">
                <svg class="w-5 h-5 transition-transform" :class="collapsed && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
                <span x-show="!collapsed" x-transition class="text-sm font-medium">Comprimi</span>
            </button>
        </div>
    </div>
</aside>

<!-- Mobile Overlay -->
<div x-show="mobileOpen" 
     x-cloak
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="mobileOpen = false"
     class="lg:hidden fixed inset-0 top-16 bg-black/50 z-30">
</div>

<!-- Mobile Sidebar -->
<aside x-show="mobileOpen"
       x-cloak
       x-transition:enter="transition ease-in-out duration-300"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in-out duration-300"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="lg:hidden fixed left-0 top-16 bottom-0 w-64 bg-white dark:bg-neutral-900 border-r border-neutral-200 dark:border-neutral-800 z-40 overflow-hidden">
    
    <!-- Mobile Sidebar Content -->
    <div class="flex flex-col h-full">
        <!-- User Info (Top) -->
        @auth
        <div class="p-4 border-b border-neutral-200 dark:border-neutral-800">
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->profile_photo_url }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-200 flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-neutral-900 dark:text-white truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-neutral-500 truncate">
                        {{ auth()->user()->nickname ?? auth()->user()->email }}
                    </p>
                </div>
            </div>
        </div>
        @endauth

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
            <ul class="space-y-1">
                <!-- Home -->
                <li>
                    <a href="{{ route('home') }}" 
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="text-sm font-medium">Home</span>
                    </a>
                </li>

                <!-- Eventi -->
                <li>
                    <a href="{{ route('events.index') }}" 
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium">Eventi</span>
                    </a>
                </li>

                @auth
                <!-- Gigs -->
                <li>
                    <a href="#" 
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium">Gigs</span>
                    </a>
                </li>
                @endauth

                <!-- Media -->
                <li>
                    <a href="#" 
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium">Media</span>
                    </a>
                </li>

                <!-- Poesie -->
                <li>
                    <a href="{{ route('poems.index') }}" 
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span class="text-sm font-medium">Poesie</span>
                    </a>
                </li>

                <!-- Articoli -->
                <li>
                    <a href="{{ route('articles.index') }}" 
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span class="text-sm font-medium">Articoli</span>
                    </a>
                </li>

                <!-- Galleria -->
                <li>
                    <a href="{{ route('gallery.index') }}" 
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium">Galleria</span>
                    </a>
                </li>

                @auth
                <!-- Gruppi -->
                <li>
                    <a href="#" 
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="text-sm font-medium">Gruppi</span>
                    </a>
                </li>

                <!-- Forum -->
                <li>
                    <a href="#" 
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-neutral-700 dark:text-neutral-300 hover:text-primary-600 transition-all group">
                        <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="text-sm font-medium">Forum</span>
                    </a>
                </li>
                @endauth
            </ul>
        </nav>

        <!-- Bottom Actions Mobile -->
        <div class="p-3 border-t border-neutral-200 dark:border-neutral-800">
            <button @click="mobileOpen = false"
                    class="w-full flex items-center justify-center gap-3 px-3 py-2.5 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="text-sm font-medium">Chiudi Menu</span>
            </button>
        </div>
    </div>
</aside>

</div>

