@props([
    'itemId' => null,
    'itemType' => null,
    'url' => null,
    'title' => '',
    'size' => 'md', // sm, md, lg
])

@php
$sizeClasses = [
    'sm' => 'w-5 h-5',
    'md' => 'w-6 h-6',
    'lg' => 'w-7 h-7',
];
$iconSize = $sizeClasses[$size] ?? $sizeClasses['md'];

// Generate URL if not provided
if (!$url && $itemId && $itemType) {
    $url = match($itemType) {
        'poem' => route('poems.show', $itemId),
        'article' => route('articles.show', $itemId),
        'event' => route('events.show', $itemId),
        'video' => route('media.index', ['tab' => 'videos']) . '#video-' . $itemId,
        'photo' => route('media.index', ['tab' => 'photos']) . '#photo-' . $itemId,
        default => url()->current(),
    };
}

$shareUrl = $url ?? url()->current();
$shareTitle = $title ?: config('app.name');
@endphp

<div x-data="{ 
    showModal: false,
    showFediverseModal: false,
    fediverseInstance: '',
    shareUrl: '{{ $shareUrl }}',
    shareTitle: '{{ addslashes($shareTitle) }}',
    
    async share() {
        // Always show custom modal (no system share)
        this.showModal = true;
    },
    
    shareToFediverse() {
        if (!this.fediverseInstance) {
            this.$dispatch('notify', { 
                message: 'Inserisci l\'indirizzo della tua istanza', 
                type: 'error' 
            });
            return;
        }
        
        // Rimuovi https:// se presente
        let instance = this.fediverseInstance.replace(/^https?:\/\//, '');
        
        // Crea URL per condivisione Mastodon-style
        const encodedUrl = encodeURIComponent(this.shareUrl);
        const encodedTitle = encodeURIComponent(this.shareTitle);
        const shareUrl = `https://${instance}/share?text=${encodedTitle}%20${encodedUrl}`;
        
        // Calcola la posizione per centrare la finestra
        const width = 600;
        const height = 700;
        const left = (window.screen.width / 2) - (width / 2);
        const top = (window.screen.height / 2) - (height / 2);
        
        // Apri una finestra popup centrata
        window.open(
            shareUrl, 
            'shareWindow',
            `width=${width},height=${height},left=${left},top=${top},toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no`
        );
        this.showFediverseModal = false;
        this.showModal = false;
        this.fediverseInstance = '';
    },
    
    copyLink() {
        navigator.clipboard.writeText(this.shareUrl).then(() => {
            this.$dispatch('notify', { 
                message: '{{ __('social.link_copied') }}', 
                type: 'success' 
            });
            this.showModal = false;
        });
    },
    
    shareOn(platform) {
        let url = '';
        const encodedUrl = encodeURIComponent(this.shareUrl);
        const encodedTitle = encodeURIComponent(this.shareTitle);
        
        switch(platform) {
            case 'twitter':
                url = `https://twitter.com/intent/tweet?url=${encodedUrl}&text=${encodedTitle}`;
                break;
            case 'facebook':
                url = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
                break;
            case 'whatsapp':
                url = `https://wa.me/?text=${encodedTitle}%20${encodedUrl}`;
                break;
            case 'telegram':
                url = `https://t.me/share/url?url=${encodedUrl}&text=${encodedTitle}`;
                break;
            case 'linkedin':
                url = `https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`;
                break;
            case 'fediverse':
                // Mostra modal per scegliere istanza fediverso
                this.showFediverseModal = true;
                return;
            case 'email':
                url = `mailto:?subject=${encodedTitle}&body=${encodedUrl}`;
                break;
            case 'instagram':
                // Su mobile, prova ad aprire l'app Instagram
                const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
                if (isMobile) {
                    // Prova ad aprire l'app Instagram
                    const instagramAppUrl = `instagram://share?url=${encodedUrl}`;
                    window.location.href = instagramAppUrl;
                    
                    // Se l'app non si apre entro 1 secondo, copia il link
                    setTimeout(() => {
                        this.copyLink();
                        this.$dispatch('notify', { 
                            message: 'Link copiato! Incollalo in Instagram', 
                            type: 'info' 
                        });
                    }, 1000);
                } else {
                    // Su desktop, copia il link
                    this.copyLink();
                    this.$dispatch('notify', { 
                        message: 'Link copiato! Incollalo in Instagram', 
                        type: 'info' 
                    });
                }
                this.showModal = false;
                return;
        }
        
        if (url) {
            if (platform === 'email') {
                window.location.href = url;
            } else {
                // Calcola la posizione per centrare la finestra
                const width = 600;
                const height = 500;
                const left = (window.screen.width / 2) - (width / 2);
                const top = (window.screen.height / 2) - (height / 2);
                
                // Apri una finestra popup centrata
                window.open(
                    url, 
                    'shareWindow',
                    `width=${width},height=${height},left=${left},top=${top},toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,directories=no,status=no`
                );
            }
            this.showModal = false;
        }
    }
}" 
class="relative inline-block" {{ $attributes->only(['class']) }}>
    <button type="button"
            @click="share()"
            class="flex items-center gap-1 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 transition-all duration-300 group cursor-pointer">
        <svg class="{{ $iconSize }} group-hover:scale-110 group-hover:rotate-12 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
        </svg>
    </button>
    
    <!-- Share Modal -->
    <template x-teleport="body">
        <div x-show="showModal"
             x-cloak
             @keydown.escape.window="showModal = false"
             class="fixed inset-0 z-[999999] flex items-center justify-center p-4"
             style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showModal = false"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        
        <!-- Modal Content -->
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            
            <!-- Header -->
            <div class="sticky top-0 bg-white dark:bg-neutral-800 border-b border-neutral-200 dark:border-neutral-700 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    {{ __('social.share_title') }}
                </h3>
                <button @click="showModal = false" 
                        class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-6 space-y-3">
                
                <!-- Copy Link - Featured -->
                <button @click="copyLink()" 
                        class="w-full flex items-center gap-4 px-5 py-4 bg-primary-50 dark:bg-primary-900/20 border-2 border-primary-200 dark:border-primary-800 hover:bg-primary-100 dark:hover:bg-primary-900/30 rounded-xl transition-all group">
                    <div class="flex-shrink-0 w-12 h-12 bg-primary-600 text-white rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="font-bold text-neutral-900 dark:text-white">{{ __('social.copy_link') }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('social.copy_link_description') }}</div>
                    </div>
                </button>
                
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-neutral-200 dark:border-neutral-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400">
                            {{ __('social.share_on_social') }}
                        </span>
                    </div>
                </div>
                
                <!-- Social Networks Grid -->
                <div class="grid grid-cols-2 gap-3">
                    
                    <!-- Email -->
                    <button @click="shareOn('email')" 
                            class="flex flex-col items-center gap-3 px-4 py-5 bg-neutral-50 dark:bg-neutral-900/50 hover:bg-neutral-100 dark:hover:bg-neutral-700 border border-neutral-200 dark:border-neutral-700 hover:border-neutral-300 dark:hover:border-neutral-600 rounded-xl transition-all group">
                        <div class="w-12 h-12 bg-neutral-700 dark:bg-neutral-600 text-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Email</span>
                    </button>
                    
                    <!-- Telegram -->
                    <button @click="shareOn('telegram')" 
                            class="flex flex-col items-center gap-3 px-4 py-5 bg-neutral-50 dark:bg-neutral-900/50 hover:bg-blue-50 dark:hover:bg-blue-900/20 border border-neutral-200 dark:border-neutral-700 hover:border-blue-300 dark:hover:border-blue-800 rounded-xl transition-all group">
                        <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Telegram</span>
                    </button>
                    
                    <!-- LinkedIn -->
                    <button @click="shareOn('linkedin')" 
                            class="flex flex-col items-center gap-3 px-4 py-5 bg-neutral-50 dark:bg-neutral-900/50 hover:bg-blue-50 dark:hover:bg-blue-900/20 border border-neutral-200 dark:border-neutral-700 hover:border-blue-300 dark:hover:border-blue-800 rounded-xl transition-all group">
                        <div class="w-12 h-12 bg-blue-700 text-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">LinkedIn</span>
                    </button>
                    
                    <!-- Twitter -->
                    <button @click="shareOn('twitter')" 
                            class="flex flex-col items-center gap-3 px-4 py-5 bg-neutral-50 dark:bg-neutral-900/50 hover:bg-blue-50 dark:hover:bg-blue-900/20 border border-neutral-200 dark:border-neutral-700 hover:border-blue-300 dark:hover:border-blue-800 rounded-xl transition-all group">
                        <div class="w-12 h-12 bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">X (Twitter)</span>
                    </button>
                    
                    <!-- WhatsApp -->
                    <button @click="shareOn('whatsapp')" 
                            class="flex flex-col items-center gap-3 px-4 py-5 bg-neutral-50 dark:bg-neutral-900/50 hover:bg-green-50 dark:hover:bg-green-900/20 border border-neutral-200 dark:border-neutral-700 hover:border-green-300 dark:hover:border-green-800 rounded-xl transition-all group">
                        <div class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">WhatsApp</span>
                    </button>
                    
                    <!-- Instagram -->
                    <button @click="shareOn('instagram')" 
                            class="flex flex-col items-center gap-3 px-4 py-5 bg-neutral-50 dark:bg-neutral-900/50 hover:bg-pink-50 dark:hover:bg-pink-900/20 border border-neutral-200 dark:border-neutral-700 hover:border-pink-300 dark:hover:border-pink-800 rounded-xl transition-all group">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 text-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Instagram</span>
                    </button>
                    
                    <!-- Fediverse (Mastodon, Pixelfed, etc) -->
                    <button @click="shareOn('fediverse')" 
                            class="flex flex-col items-center gap-3 px-4 py-5 bg-neutral-50 dark:bg-neutral-900/50 hover:bg-purple-50 dark:hover:bg-purple-900/20 border border-neutral-200 dark:border-neutral-700 hover:border-purple-300 dark:hover:border-purple-800 rounded-xl transition-all group">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-600 via-blue-600 to-cyan-600 text-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform p-2">
                            <svg class="w-full h-full" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Pentagono intrecciato del Fediverso -->
                                <path d="M50 10 L90 35 L75 85 L25 85 L10 35 Z" stroke="currentColor" stroke-width="8" fill="none" stroke-linejoin="round"/>
                                <path d="M50 10 L75 85" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                                <path d="M50 10 L25 85" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                                <path d="M90 35 L25 85" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                                <path d="M90 35 L10 35" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                                <path d="M75 85 L10 35" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                                <circle cx="50" cy="10" r="6" fill="currentColor"/>
                                <circle cx="90" cy="35" r="6" fill="currentColor"/>
                                <circle cx="75" cy="85" r="6" fill="currentColor"/>
                                <circle cx="25" cy="85" r="6" fill="currentColor"/>
                                <circle cx="10" cy="35" r="6" fill="currentColor"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Fediverso</span>
                    </button>
                    
                    <!-- Facebook -->
                    <button @click="shareOn('facebook')" 
                            class="flex flex-col items-center gap-3 px-4 py-5 bg-neutral-50 dark:bg-neutral-900/50 hover:bg-blue-50 dark:hover:bg-blue-900/20 border border-neutral-200 dark:border-neutral-700 hover:border-blue-300 dark:hover:border-blue-800 rounded-xl transition-all group">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Facebook</span>
                    </button>
                </div>
            </div>
        </div>
        </div>
    </template>
    
    <!-- Fediverse Instance Modal -->
    <template x-teleport="body">
        <div x-show="showFediverseModal"
             x-cloak
             @keydown.escape.window="showFediverseModal = false"
             class="fixed inset-0 z-[9999999] flex items-center justify-center p-4"
             style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="showFediverseModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showFediverseModal = false"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        
        <!-- Modal Content -->
        <div x-show="showFediverseModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl max-w-md w-full p-6">
            
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                    <svg class="w-7 h-7 text-purple-600" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M50 10 L90 35 L75 85 L25 85 L10 35 Z" stroke="currentColor" stroke-width="8" fill="none" stroke-linejoin="round"/>
                        <path d="M50 10 L75 85" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                        <path d="M50 10 L25 85" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                        <path d="M90 35 L25 85" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                        <path d="M90 35 L10 35" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                        <path d="M75 85 L10 35" stroke="currentColor" stroke-width="6" opacity="0.8"/>
                        <circle cx="50" cy="10" r="6" fill="currentColor"/>
                        <circle cx="90" cy="35" r="6" fill="currentColor"/>
                        <circle cx="75" cy="85" r="6" fill="currentColor"/>
                        <circle cx="25" cy="85" r="6" fill="currentColor"/>
                        <circle cx="10" cy="35" r="6" fill="currentColor"/>
                    </svg>
                    Condividi nel Fediverso
                </h3>
                <button @click="showFediverseModal = false" 
                        class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="space-y-4">
                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                    Inserisci l'indirizzo della tua istanza Mastodon, Pixelfed o altra piattaforma federata per condividere questo contenuto.
                </p>
                
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        Istanza Fediverso
                    </label>
                    <input type="text" 
                           x-model="fediverseInstance"
                           @keydown.enter="shareToFediverse()"
                           placeholder="mastodon.social"
                           class="w-full px-4 py-3 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg 
                                  bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white
                                  focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20
                                  transition-all">
                    <p class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">
                        Esempi: mastodon.social, pixelfed.social, fosstodon.org
                    </p>
                </div>
                
                <!-- Popular Instances Quick Select -->
                <div>
                    <p class="text-xs font-semibold text-neutral-600 dark:text-neutral-400 mb-2">Istanze popolari:</p>
                    <div class="flex flex-wrap gap-2">
                        <button @click="fediverseInstance = 'mastodon.social'" 
                                class="px-3 py-1.5 text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                            mastodon.social
                        </button>
                        <button @click="fediverseInstance = 'pixelfed.social'" 
                                class="px-3 py-1.5 text-xs font-medium bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300 rounded-full hover:bg-pink-200 dark:hover:bg-pink-900/50 transition-colors">
                            pixelfed.social
                        </button>
                        <button @click="fediverseInstance = 'fosstodon.org'" 
                                class="px-3 py-1.5 text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                            fosstodon.org
                        </button>
                        <button @click="fediverseInstance = 'mastodon.uno'" 
                                class="px-3 py-1.5 text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                            mastodon.uno 🇮🇹
                        </button>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4">
                    <button @click="showFediverseModal = false" 
                            class="flex-1 px-4 py-3 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600 font-semibold transition-colors">
                        Annulla
                    </button>
                    <button @click="shareToFediverse()" 
                            class="flex-1 px-4 py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all">
                        Condividi
                    </button>
                </div>
            </div>
        </div>
        </div>
    </template>
</div>

