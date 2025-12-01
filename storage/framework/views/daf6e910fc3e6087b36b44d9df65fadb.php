<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show): ?>
    <div 
        x-data="{
            currentStep: <?php echo \Illuminate\Support\Js::from($currentStep)->toHtml() ?>,
            steps: <?php echo \Illuminate\Support\Js::from($this->steps)->toHtml() ?>,
            get currentStepData() {
                return this.steps[this.currentStep] || this.steps[0];
            },
            highlightElement() {
                // Remove previous highlights
                document.querySelectorAll('.tutorial-highlight').forEach(el => {
                    el.classList.remove('tutorial-highlight');
                });
                
                const stepData = this.currentStepData;
                if (stepData && stepData.focusElement) {
                    setTimeout(() => {
                        const element = document.querySelector(`[data-tutorial-focus='${stepData.focusElement}']`);
                        if (element) {
                            element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            setTimeout(() => {
                                element.classList.add('tutorial-highlight');
                            }, 300);
                        }
                    }, 100);
                }
            }
        }"
        x-init="
            $watch('$wire.currentStep', (value) => {
                currentStep = value;
                highlightElement();
            });
            highlightElement();
        "
        class="fixed inset-0 z-[999998]"
        style="display: none;"
        x-show="$wire.show"
        x-cloak
    >
        <!-- Overlay scuro -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
             @click.self="$wire.close()"></div>

        <!-- Spotlight effect -->
        <div class="absolute inset-0 pointer-events-none">
            <svg class="w-full h-full">
                <defs>
                    <mask id="tutorial-mask">
                        <rect width="100%" height="100%" fill="black"/>
                        <circle id="spotlight-circle" cx="50%" cy="50%" r="200" fill="white"/>
                    </mask>
                </defs>
                <rect width="100%" height="100%" fill="rgba(0,0,0,0.5)" mask="url(#tutorial-mask)"/>
            </svg>
        </div>

        <!-- Tutorial Modal -->
        <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">
            <div class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl max-w-2xl w-full p-6 md:p-8 pointer-events-auto"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                            <span class="text-2xl">👋</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white">
                                <span x-text="currentStepData.title"></span>
                            </h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                Step <span x-text="currentStep + 1"></span> di <span x-text="steps.length"></span>
                            </p>
                        </div>
                    </div>
                    <button @click="$wire.close()" 
                            class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="mb-6">
                    <div class="prose prose-sm dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300"
                         x-html="currentStepData.content"></div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-6">
                    <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full transition-all duration-300"
                             :style="`width: ${(($wire.currentStep + 1) / <?php echo e($this->getTotalSteps()); ?>) * 100}%`"></div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between gap-3">
                    <button @click="$wire.skip()" 
                            class="px-4 py-2 text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200 transition-colors">
                        Salta tutorial
                    </button>
                    
                    <div class="flex gap-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep > 0): ?>
                            <button @click="$wire.previous()" 
                                    class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 rounded-lg transition-colors">
                                Indietro
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep < $this->getTotalSteps() - 1): ?>
                            <button @click="$wire.next()" 
                                    class="px-6 py-2 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors shadow-lg">
                                Prosegui
                            </button>
                        <?php else: ?>
                            <button @click="$wire.close()" 
                                    class="px-6 py-2 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors shadow-lg">
                                Inizia a esplorare!
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<style>
.tutorial-highlight {
    position: relative;
    z-index: 999999 !important;
    outline: 3px solid #8b5cf6 !important;
    outline-offset: 4px;
    border-radius: 8px;
    animation: pulse-highlight 2s infinite;
}

@keyframes pulse-highlight {
    0%, 100% {
        outline-color: #8b5cf6;
        box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.7);
    }
    50% {
        outline-color: #a78bfa;
        box-shadow: 0 0 0 8px rgba(139, 92, 246, 0);
    }
}
</style>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/tutorial/onboarding-tutorial.blade.php ENDPATH**/ ?>