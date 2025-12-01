@props([
    'itemId',
    'itemType',
    'isLiked' => false,
    'likesCount' => 0,
    'size' => 'md', // sm, md, lg
])

@php
$sizeClasses = [
    'sm' => 'w-5 h-5',
    'md' => 'w-6 h-6',
    'lg' => 'w-7 h-7',
];
$iconSize = $sizeClasses[$size] ?? $sizeClasses['md'];

$textSizeClasses = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];
$textSize = $textSizeClasses[$size] ?? $textSizeClasses['md'];
@endphp

<div x-data="{ 
    liked: {{ $isLiked ? 'true' : 'false' }}, 
    likesCount: {{ $likesCount }},
    showTooltip: false,
    likers: [],
    loadingLikers: false,
    tooltipTimeout: null,
    
    async loadLikers() {
        if (this.likesCount === 0 || this.loadingLikers) return;
        
        this.loadingLikers = true;
        try {
            const response = await fetch(`{{ route('api.like.likers') }}?id={{ $itemId }}&type={{ json_encode($itemType) }}`);
            const data = await response.json();
            if (data.success) {
                this.likers = data.users || [];
            }
        } catch (error) {
            console.error('Error loading likers:', error);
        } finally {
            this.loadingLikers = false;
        }
    },
    
    showLikersTooltip() {
        if (this.likesCount === 0) return;
        
        // Cancella timeout precedente
        if (this.tooltipTimeout) {
            clearTimeout(this.tooltipTimeout);
        }
        
        // Mostra tooltip dopo un breve delay
        this.tooltipTimeout = setTimeout(() => {
            this.showTooltip = true;
            if (this.likers.length === 0) {
                this.loadLikers();
            }
        }, 300);
    },
    
    hideLikersTooltip() {
        if (this.tooltipTimeout) {
            clearTimeout(this.tooltipTimeout);
        }
        this.showTooltip = false;
    },
    
    toggleLike() {
        @guest
            this.$dispatch('notify', { 
                message: 'Effettua il login per mettere mi piace', 
                type: 'success' 
            });
            return;
        @endguest
        
        this.liked = !this.liked;
        this.likesCount = this.liked ? this.likesCount + 1 : this.likesCount - 1;
        
        fetch('{{ route('api.like.toggle') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: {{ $itemId }},
                type: {{ json_encode($itemType) }}
            })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            if(data.success) {
                // Aggiorna il conteggio reale dal server
                if(data.count !== undefined) {
                    this.likesCount = data.count;
                }
                
                // Aggiorna lo stato reale
                this.liked = data.liked;
                
                // 🐉 DRAGHETTO CON CORIANDOLI solo quando metti like!
                if(data.liked) {
                    $dispatch('notify', { type: 'like' });
                }
            } else {
                // Errore dal server
                console.error('Server error:', data.message);
                // Rollback
                this.liked = !this.liked;
                this.likesCount = this.liked ? this.likesCount + 1 : this.likesCount - 1;
                // Mostra errore
                $dispatch('notify', { 
                    message: data.message || {{ Js::from(__('social.error_generic')) }}, 
                    type: 'error' 
                });
            }
        })
        .catch(error => {
            console.error('Errore like:', error);
            // Rollback in caso di errore
            this.liked = !this.liked;
            this.likesCount = this.liked ? this.likesCount + 1 : this.likesCount - 1;
            // Mostra errore
            $dispatch('notify', { 
                message: {{ Js::from(__('social.error_like')) }}, 
                type: 'error' 
            });
        });
    }
}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 relative']) }}>
    <button type="button"
            @click="toggleLike()"
            @mouseenter="showLikersTooltip()"
            @mouseleave="hideLikersTooltip()"
            class="flex items-center gap-1 transition-all duration-300 group cursor-pointer hover:opacity-80 relative">
        <img src="{{ asset('assets/icon/new/like.svg') }}" 
             alt="Like" 
             class="{{ $iconSize }} flex-shrink-0 group-hover:scale-125 transition-all duration-300"
             :style="liked 
                ? 'filter: brightness(0) saturate(100%) invert(38%) sepia(95%) saturate(1200%) hue-rotate(130deg) brightness(95%) contrast(90%);' 
                : 'filter: brightness(0) saturate(100%) invert(60%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(89%) contrast(86%);'">
        <span class="font-medium {{ $textSize }}" 
              :style="'color: ' + (liked ? '#059669' : '#525252')" 
              x-text="likesCount"></span>
    </button>
    
    <!-- Tooltip con utenti che hanno messo like -->
    <div x-show="showTooltip && likesCount > 0"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @mouseenter="showTooltip = true"
         @mouseleave="hideLikersTooltip()"
         class="absolute bottom-full left-0 mb-2 w-64 bg-white dark:bg-neutral-800 rounded-xl shadow-xl border border-neutral-200 dark:border-neutral-700 z-50 overflow-hidden"
         style="display: none;">
        <div class="p-3 border-b border-neutral-200 dark:border-neutral-700">
            <h4 class="font-semibold text-sm text-neutral-900 dark:text-white">
                <span x-text="likesCount"></span> <span x-text="likesCount === 1 ? 'mi piace' : 'mi piace'"></span>
            </h4>
        </div>
        <div class="max-h-64 overflow-y-auto">
            <template x-if="loadingLikers">
                <div class="p-4 text-center text-sm text-neutral-500 dark:text-neutral-400">
                    Caricamento...
                </div>
            </template>
            <template x-if="!loadingLikers && likers.length === 0">
                <div class="p-4 text-center text-sm text-neutral-500 dark:text-neutral-400">
                    Nessun mi piace ancora
                </div>
            </template>
            <template x-if="!loadingLikers && likers.length > 0">
                <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    <template x-for="user in likers" :key="user.id">
                        <a :href="`/users/${user.id}`" 
                           class="flex items-center gap-3 p-3 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors">
                            <img :src="user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&background=059669&color=fff'"
                                 :alt="user.name"
                                 class="w-10 h-10 rounded-full object-cover ring-2 ring-neutral-200 dark:ring-neutral-700">
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-sm text-neutral-900 dark:text-white truncate" x-text="user.nickname || user.name"></div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400 truncate" x-text="user.nickname ? user.name : ''"></div>
                            </div>
                        </a>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>

