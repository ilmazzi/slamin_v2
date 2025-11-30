<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'itemId',
    'itemType',
    'isLiked' => false,
    'likesCount' => 0,
    'size' => 'md', // sm, md, lg
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'itemId',
    'itemType',
    'isLiked' => false,
    'likesCount' => 0,
    'size' => 'md', // sm, md, lg
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
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
?>

<div x-data="{ 
    liked: <?php echo e($isLiked ? 'true' : 'false'); ?>, 
    likesCount: <?php echo e($likesCount); ?>,
    
    toggleLike() {
        <?php if(auth()->guard()->guest()): ?>
            this.$dispatch('notify', { 
                message: 'Effettua il login per mettere mi piace', 
                type: 'success' 
            });
            return;
        <?php endif; ?>
        
        this.liked = !this.liked;
        this.likesCount = this.liked ? this.likesCount + 1 : this.likesCount - 1;
        
        fetch('<?php echo e(route('api.like.toggle')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                id: <?php echo e($itemId); ?>,
                type: <?php echo e(json_encode($itemType)); ?>

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
                    message: data.message || <?php echo e(Js::from(__('social.error_generic'))); ?>, 
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
                message: <?php echo e(Js::from(__('social.error_like'))); ?>, 
                type: 'error' 
            });
        });
    }
}" <?php echo e($attributes->merge(['class' => 'inline-flex items-center gap-1'])); ?>>
    <button type="button"
            @click="toggleLike()"
            class="flex items-center gap-1 transition-all duration-300 group cursor-pointer hover:opacity-80">
        <img src="<?php echo e(asset('assets/icon/new/like.svg')); ?>" 
             alt="Like" 
             class="<?php echo e($iconSize); ?> flex-shrink-0 group-hover:scale-125 transition-all duration-300"
             :style="liked 
                ? 'filter: brightness(0) saturate(100%) invert(38%) sepia(95%) saturate(1200%) hue-rotate(130deg) brightness(95%) contrast(90%);' 
                : 'filter: brightness(0) saturate(100%) invert(60%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(89%) contrast(86%);'">
        <span class="font-medium <?php echo e($textSize); ?>" 
              :style="'color: ' + (liked ? '#059669' : '#525252')" 
              x-text="likesCount"></span>
    </button>
</div>

<?php /**PATH /Users/mazzi/slamin_v2/resources/views/components/like-button.blade.php ENDPATH**/ ?>