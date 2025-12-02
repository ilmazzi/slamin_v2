<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::id() !== $userId): ?>
            <button wire:click="toggleFollow" 
                    wire:loading.attr="disabled"
                    class="follow-button follow-button-<?php echo e($size); ?> follow-button-<?php echo e($variant); ?> <?php echo e($isFollowing ? 'following' : ''); ?>"
                    :class="{ 'opacity-50 cursor-not-allowed': $wire.__instance?.effects?.loading }">
                <span wire:loading.remove wire:target="toggleFollow" class="follow-content">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isFollowing): ?>
                        <svg class="follow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="follow-text"><?php echo e(__('follow.following')); ?></span>
                    <?php else: ?>
                        <svg class="follow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="follow-text"><?php echo e(__('follow.follow')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </span>
                <span wire:loading wire:target="toggleFollow" class="follow-content">
                    <svg class="follow-icon animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="follow-text"><?php echo e(__('common.loading')); ?></span>
                </span>
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
        <a href="<?php echo e(route('login')); ?>" 
           class="follow-button follow-button-<?php echo e($size); ?> follow-button-<?php echo e($variant); ?>">
            <span class="follow-content">
                <svg class="follow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="follow-text"><?php echo e(__('follow.follow')); ?></span>
            </span>
        </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <style>
    /* ============================================
       FOLLOW BUTTON - Icona + Testo, Palette Sito
       ============================================ */
    .follow-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9999px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: none;
        text-decoration: none;
        flex-shrink: 0;
        position: relative;
        white-space: nowrap; /* NO WRAPPING MAI! */
        line-height: 1;
    }
    
    .follow-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .follow-content {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        white-space: nowrap; /* NO WRAPPING MAI! */
    }
    
    .follow-icon {
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    
    .follow-text {
        font-weight: 600;
        flex-shrink: 0; /* Il testo non si restringe */
        white-space: nowrap; /* NO WRAPPING MAI! */
    }
    
    /* Size Variants - ICONA + TESTO */
    .follow-button-sm {
        padding: 0.5rem 1rem;
        min-width: 90px; /* Larghezza minima garantita */
    }
    
    .follow-button-sm .follow-icon {
        width: 16px;
        height: 16px;
    }
    
    .follow-button-sm .follow-text {
        font-size: 0.75rem;
    }
    
    .follow-button-md {
        padding: 0.625rem 1.25rem;
        min-width: 110px;
    }
    
    .follow-button-md .follow-icon {
        width: 18px;
        height: 18px;
    }
    
    .follow-button-md .follow-text {
        font-size: 0.875rem;
    }
    
    .follow-button-lg {
        padding: 0.75rem 1.5rem;
        min-width: 130px;
    }
    
    .follow-button-lg .follow-icon {
        width: 20px;
        height: 20px;
    }
    
    .follow-button-lg .follow-text {
        font-size: 1rem;
    }
    
    /* Variant: Default - VERDE SMERALDO (palette sito) */
    .follow-button-default {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
    }
    
    .follow-button-default:hover:not(:disabled) {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
        transform: translateY(-2px) scale(1.05);
    }
    
    .follow-button-default:active:not(:disabled) {
        transform: translateY(0) scale(0.98);
    }
    
    .follow-button-default.following {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        opacity: 0.8;
    }
    
    .follow-button-default.following:hover:not(:disabled) {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.35);
        opacity: 1;
    }
    
    /* Variant: Outline - VERDE SMERALDO */
    .follow-button-outline {
        background: white;
        color: #10b981;
        border: 2px solid #10b981;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    
    .follow-button-outline:hover:not(:disabled) {
        background: #ecfdf5;
        border-color: #059669;
        color: #059669;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    
    .follow-button-outline.following {
        background: #ecfdf5;
        color: #10b981;
        border-color: #10b981;
    }
    
    .follow-button-outline.following:hover:not(:disabled) {
        background: #fef2f2;
        color: #ef4444;
        border-color: #ef4444;
    }
    
    /* Variant: Ghost - VERDE SMERALDO */
    .follow-button-ghost {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .follow-button-ghost:hover:not(:disabled) {
        background: rgba(16, 185, 129, 0.2);
        color: #059669;
        border-color: rgba(16, 185, 129, 0.4);
        transform: translateY(-1px) scale(1.05);
    }
    
    .follow-button-ghost.following {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.3);
    }
    
    .follow-button-ghost.following:hover:not(:disabled) {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.3);
    }
    
    /* Dark Mode */
    :is(.dark .follow-button-default) {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    :is(.dark .follow-button-default.following) {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    :is(.dark .follow-button-outline) {
        background: rgba(16, 185, 129, 0.1);
        border-color: #10b981;
        color: #34d399;
    }
    
    :is(.dark .follow-button-outline:hover:not(:disabled)) {
        background: rgba(16, 185, 129, 0.2);
        border-color: #34d399;
    }
    
    :is(.dark .follow-button-ghost) {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border-color: rgba(16, 185, 129, 0.3);
    }
    
    /* Loading State */
    .follow-button [wire\:loading] {
        display: none;
    }
    
    .follow-button [wire\:loading].animate-spin {
        display: block;
    }
    
    /* Icona checkmark più grossa quando following */
    .follow-button.following .follow-icon {
        stroke-width: 3;
    }
    </style>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/components/follow-button.blade.php ENDPATH**/ ?>