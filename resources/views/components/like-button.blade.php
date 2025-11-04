@props([
    'itemId',
    'itemType',
    'isLiked' => false,
    'likesCount' => 0,
    'size' => 'md', // sm, md, lg
])

@php
$sizeClasses = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
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
    
    toggleLike() {
        @guest
            this.$dispatch('notify', { 
                message: 'Effettua il login per mettere mi piace', 
                type: 'info' 
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
}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}>
    <button type="button"
            @click="toggleLike()"
            class="flex items-center gap-2 transition-all duration-300 group cursor-pointer hover:opacity-80">
        <img src="{{ asset('assets/icon/new/like.svg') }}" 
             alt="Like" 
             class="{{ $iconSize }} group-hover:scale-125 transition-transform duration-300"
             :style="liked 
                ? 'filter: brightness(0) saturate(100%) invert(27%) sepia(98%) saturate(2618%) hue-rotate(346deg) brightness(94%) contrast(97%);' 
                : 'filter: brightness(0) saturate(100%) invert(60%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(89%) contrast(86%);'">
        <span class="font-medium {{ $textSize }}" 
              :style="'color: ' + (liked ? '#dc2626' : '#525252')" 
              x-text="likesCount"></span>
    </button>
</div>

