<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Crimson+Pro:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Additional Head Content -->
    {{ $head ?? '' }}
</head>
<body class="antialiased bg-neutral-50 dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100" 
      x-data="{ scrollY: 0 }" 
      @scroll.window="scrollY = window.scrollY">
    <!-- Navigation -->
    <x-layouts.navigation-modern />

    <!-- Main Content (no spacing) -->
    <main class="mt-0">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-layouts.footer-modern />

    <!-- Scripts -->
    @livewireScripts
    
    <!-- Additional Body Scripts -->
    {{ $scripts ?? '' }}

    <!-- Comments Modal -->
    <div x-data="{
        show: false,
        contentId: null,
        contentType: null,
        comments: [],
        newComment: '',
        loading: false,
        
        openModal(data) {
            this.contentId = data.id;
            this.contentType = data.type;
            this.show = true;
            this.loadComments();
        },
        
        loadComments() {
            this.loading = true;
            fetch(`{{ route('api.comments.index') }}?id=${this.contentId}&type=${this.contentType}`)
                .then(res => res.json())
                .then(data => {
                    this.comments = data.comments;
                    this.loading = false;
                });
        },
        
        addComment() {
            if(!this.newComment.trim()) return;
            
            fetch('{{ route('api.comments.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: this.contentId,
                    type: this.contentType,
                    content: this.newComment
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    this.comments.unshift(data.comment);
                    this.newComment = '';
                    $dispatch('notify', { message: data.message, type: 'success' });
                }
            });
        }
    }"
    @open-comments.window="openModal($event.detail)"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[10000] flex items-center justify-center p-4"
    style="display: none;">
        <!-- Backdrop -->
        <div @click="show = false" 
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        
        <!-- Modal -->
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="relative bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col">
            
            <!-- Header -->
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white">{{ __('social.comments_title') }}</h3>
                <button @click="show = false" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Comments List -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                <template x-if="loading">
                    <div class="text-center py-8 text-neutral-500">{{ __('common.loading') }}</div>
                </template>
                
                <template x-if="!loading && comments.length === 0">
                    <div class="text-center py-8 text-neutral-500">{{ __('social.no_comments') }}</div>
                </template>
                
                <template x-for="comment in comments" :key="comment.id">
                    <div class="flex gap-3">
                        <img :src="comment.user.avatar" 
                             :alt="comment.user.name" 
                             class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                        <div class="flex-1">
                            <div class="bg-neutral-100 dark:bg-neutral-800 rounded-2xl p-4">
                                <h4 class="font-semibold text-sm text-neutral-900 dark:text-white" x-text="comment.user.name"></h4>
                                <p class="text-neutral-700 dark:text-neutral-300 mt-1" x-text="comment.content"></p>
                            </div>
                            <p class="text-xs text-neutral-500 mt-1 ml-4" x-text="comment.created_at"></p>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Comment Form -->
            @auth
            <div class="p-6 border-t border-neutral-200 dark:border-neutral-800">
                <form @submit.prevent="addComment()" class="flex gap-3">
                    <img src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=059669&color=fff' }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                    <div class="flex-1 flex gap-2">
                        <input type="text" 
                               x-model="newComment"
                               placeholder="{{ __('social.write_comment_placeholder') }}"
                               class="flex-1 px-4 py-2 bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white">
                        <button type="submit"
                                class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors">
                            {{ __('social.send') }}
                        </button>
                    </div>
                </form>
            </div>
            @endauth
        </div>
    </div>

    <!-- Toast Notifications -->
    <div x-data="{ 
        show: false, 
        message: '', 
        type: 'success',
        showToast(data) {
            this.message = data.message;
            this.type = data.type || 'success';
            this.show = true;
            setTimeout(() => { this.show = false; }, 3000);
        }
    }"
    @notify.window="showToast($event.detail)"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-4 right-4 z-50 max-w-sm">
        <div class="rounded-xl shadow-2xl overflow-hidden"
             :class="{
                'bg-success-600': type === 'success',
                'bg-info-600': type === 'info',
                'bg-warning-600': type === 'warning',
                'bg-danger-600': type === 'error'
             }">
            <div class="p-4 flex items-center gap-3">
                <!-- Icon Success -->
                <svg x-show="type === 'success'" class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <!-- Icon Warning -->
                <svg x-show="type === 'warning'" class="w-6 h-6 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <!-- Message -->
                <span x-text="message" class="text-white font-medium flex-1"></span>
                <!-- Close -->
                <button @click="show = false" class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</body>
</html>

