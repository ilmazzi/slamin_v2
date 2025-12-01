<div>
    <div 
        x-data="{
            currentStep: <?php echo \Illuminate\Support\Js::from($currentStep)->toHtml() ?>,
            steps: <?php echo \Illuminate\Support\Js::from($this->steps)->toHtml() ?>,
            highlightedElement: null,
            highlightRect: null,
            get currentStepData() {
                return this.steps[this.currentStep] || this.steps[0];
            },
            get highlightStyle() {
                if (!this.highlightRect) return 'display: none;';
                const x = Math.max(0, this.highlightRect.x - 8);
                const y = Math.max(0, this.highlightRect.y - 8);
                const w = this.highlightRect.width + 16;
                const h = this.highlightRect.height + 16;
                return `left: ${x}px; top: ${y}px; width: ${w}px; height: ${h}px;`;
            },
            get overlayTopHeight() {
                if (!this.highlightRect) return '0px';
                return `${Math.max(0, this.highlightRect.y - 8)}px`;
            },
            get overlayBottomTop() {
                if (!this.highlightRect) return '0px';
                return `${this.highlightRect.y + this.highlightRect.height + 8}px`;
            },
            get overlayLeftWidth() {
                if (!this.highlightRect) return '0px';
                return `${Math.max(0, this.highlightRect.x - 8)}px`;
            },
            get overlayRightLeft() {
                if (!this.highlightRect) return '0px';
                const viewportWidth = window.innerWidth || document.documentElement.clientWidth;
                return `${this.highlightRect.x + this.highlightRect.width + 8}px`;
            },
            get overlayRightWidth() {
                if (!this.highlightRect) return '0px';
                const viewportWidth = window.innerWidth || document.documentElement.clientWidth;
                return `${Math.max(0, viewportWidth - this.highlightRect.x - this.highlightRect.width - 8)}px`;
            },
            updateHighlight() {
                // Remove previous highlights
                document.querySelectorAll('.tutorial-highlight').forEach(el => {
                    el.classList.remove('tutorial-highlight');
                });
                this.highlightedElement = null;
                this.highlightRect = null;
                
                const stepData = this.currentStepData;
                if (stepData && stepData.focusElement) {
                    setTimeout(() => {
                        // Prova a trovare l'elemento - preferisci nav se disponibile
                        let element = null;
                        const allElements = document.querySelectorAll(`[data-tutorial-focus='${stepData.focusElement}']`);
                        
                        if (allElements.length > 0) {
                            // Se ci sono più elementi, preferisci nav o l'elemento più piccolo/visibile
                            for (let el of allElements) {
                                const rect = el.getBoundingClientRect();
                                if (rect.width > 0 && rect.height > 0) {
                                    // Preferisci nav se disponibile, altrimenti il primo visibile
                                    if (el.tagName === 'NAV' || !element) {
                                        element = el;
                                    }
                                }
                            }
                        }
                        
                        // Se non trovato, aspetta un po' e riprova (per elementi che potrebbero essere caricati dinamicamente)
                        if (!element) {
                            setTimeout(() => {
                                const retryElements = document.querySelectorAll(`[data-tutorial-focus='${stepData.focusElement}']`);
                                if (retryElements.length > 0) {
                                    for (let el of retryElements) {
                                        const rect = el.getBoundingClientRect();
                                        if (rect.width > 0 && rect.height > 0) {
                                            if (el.tagName === 'NAV' || !element) {
                                                element = el;
                                            }
                                        }
                                    }
                                }
                                
                                if (element) {
                                    this.highlightElement(element);
                                } else {
                                    console.warn('Tutorial: Element not found after retry:', stepData.focusElement);
                                    console.warn('Tutorial: Found elements:', document.querySelectorAll(`[data-tutorial-focus]`));
                                    // Se non trovato, nascondi l'overlay per non bloccare l'utente
                                    this.highlightRect = null;
                                    this.highlightedElement = null;
                                }
                            }, 500);
                        } else {
                            this.highlightElement(element);
                        }
                    }, 200);
                }
            },
            highlightElement(element) {
                if (!element) {
                    console.warn('Tutorial: highlightElement called with null element');
                    return;
                }
                
                console.log('Tutorial: Highlighting element:', element, element.getAttribute('data-tutorial-focus'));
                
                this.highlightedElement = element;
                
                // Verifica che l'elemento sia visibile
                const rect = element.getBoundingClientRect();
                console.log('Tutorial: Element rect:', rect);
                
                if (rect.width === 0 || rect.height === 0) {
                    console.warn('Tutorial: Element found but not visible (width or height is 0):', element);
                    // Prova a forzare la visibilità se è nascosto
                    const computedStyle = window.getComputedStyle(element);
                    if (computedStyle.display === 'none') {
                        console.warn('Tutorial: Element is display:none, cannot highlight');
                    }
                    this.highlightRect = null;
                    this.highlightedElement = null;
                    return;
                }
                
                // Scroll solo se necessario (non per elementi fixed)
                const isFixed = window.getComputedStyle(element).position === 'fixed';
                if (!isFixed) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                setTimeout(() => {
                    element.classList.add('tutorial-highlight');
                    // Forza l'elemento sopra l'overlay solo se non è già fixed
                    if (!isFixed) {
                        element.style.position = 'relative';
                    }
                    element.style.zIndex = '1000002';
                    
                    // Aggiorna il rect immediatamente
                    this.updateHighlightRect();
                    console.log('Tutorial: Highlight rect updated:', this.highlightRect);
                    
                    // Update rect periodically per gestire scroll/resize
                    const interval = setInterval(() => {
                        if (this.highlightedElement && this.highlightedElement.classList.contains('tutorial-highlight')) {
                            this.updateHighlightRect();
                        } else {
                            clearInterval(interval);
                        }
                    }, 100);
                }, isFixed ? 100 : 500);
            },
            updateHighlightRect() {
                if (this.highlightedElement) {
                    const rect = this.highlightedElement.getBoundingClientRect();
                    // Usa coordinate viewport perché l'overlay è fixed
                    this.highlightRect = {
                        x: rect.left,
                        y: rect.top,
                        width: rect.width,
                        height: rect.height
                    };
                }
            }
        }"
        x-init="
            $watch('$wire.currentStep', (value) => {
                currentStep = value;
                updateHighlight();
            });
            $watch('$wire.show', (value) => {
                if (value) {
                    setTimeout(() => updateHighlight(), 300);
                }
            });
            if ($wire.show) {
                setTimeout(() => updateHighlight(), 300);
            }
            window.addEventListener('scroll', () => updateHighlightRect());
            window.addEventListener('resize', () => updateHighlightRect());
        "
        class="fixed inset-0 z-[999998]"
        style="display: none;"
        x-show="$wire.show"
        x-cloak
    >
        <!-- Overlay scuro con buco per elemento evidenziato -->
        <div x-show="highlightRect && highlightedElement"
             class="absolute inset-0 pointer-events-auto"
             style="z-index: 1; display: none;"
             @click.self="$wire.close()">
            <!-- Sopra -->
            <div class="absolute top-0 left-0 right-0 bg-black/60 backdrop-blur-sm"
                 x-bind:style="`height: ${overlayTopHeight};`"></div>
            
            <!-- Sotto -->
            <div class="absolute left-0 right-0 bottom-0 bg-black/60 backdrop-blur-sm"
                 x-bind:style="`top: ${overlayBottomTop};`"></div>
            
            <!-- Sinistra -->
            <div class="absolute bg-black/60 backdrop-blur-sm"
                 x-bind:style="`
                     left: 0;
                     top: ${overlayTopHeight};
                     width: ${overlayLeftWidth};
                     height: ${highlightRect ? highlightRect.height + 16 + 'px' : '0px'};
                 `"></div>
            
            <!-- Destra -->
            <div class="absolute bg-black/60 backdrop-blur-sm"
                 x-bind:style="`
                     right: 0;
                     top: ${overlayTopHeight};
                     width: ${overlayRightWidth};
                     height: ${highlightRect ? highlightRect.height + 16 + 'px' : '0px'};
                 `"></div>
        </div>
        
        <!-- Overlay completo quando non c'è elemento evidenziato -->
        <div x-show="!highlightRect || !highlightedElement"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm pointer-events-auto"
             @click.self="$wire.close()"
             style="z-index: 1;">
        </div>
        
        <!-- Bordo pulsante attorno all'elemento evidenziato (sopra overlay) -->
        <div x-show="highlightRect && highlightedElement"
             class="fixed pointer-events-none tutorial-spotlight"
             x-bind:style="highlightStyle"
             style="display: none; z-index: 1000001;">
        </div>

        <!-- Tutorial Modal -->
        <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none" style="z-index: 1000000;">
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
                             :style="`width: ${((currentStep + 1) / steps.length) * 100}%`"></div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between gap-3">
                    <button @click="$wire.skip()" 
                            class="px-4 py-2 text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200 transition-colors">
                        Salta tutorial
                    </button>
                    
                    <div class="flex gap-3">
                        <button x-show="currentStep > 0"
                                @click="$wire.previous()" 
                                class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 rounded-lg transition-colors">
                            Indietro
                        </button>
                        
                        <button x-show="currentStep < steps.length - 1"
                                @click="$wire.next()" 
                                class="px-6 py-2 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors shadow-lg">
                            Prosegui
                        </button>
                        <button x-show="currentStep >= steps.length - 1"
                                @click="$wire.close()" 
                                class="px-6 py-2 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors shadow-lg">
                            Inizia a esplorare!
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .tutorial-highlight {
        position: relative !important;
        z-index: 1000002 !important;
        transform: scale(1.05);
        transition: transform 0.3s ease;
        outline: 4px solid #8b5cf6 !important;
        outline-offset: 4px;
        border-radius: 8px;
    }

    .tutorial-spotlight {
        border: 6px solid #8b5cf6;
        border-radius: 16px;
        background: rgba(139, 92, 246, 0.1);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.5),
                    0 0 30px rgba(139, 92, 246, 0.8),
                    0 0 60px rgba(139, 92, 246, 0.4);
        animation: pulse-border 2s infinite;
    }

    @keyframes pulse-border {
        0%, 100% {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.5),
                        0 0 30px rgba(139, 92, 246, 0.8),
                        0 0 60px rgba(139, 92, 246, 0.4);
            transform: scale(1);
        }
        50% {
            border-color: #a78bfa;
            box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.7),
                        0 0 40px rgba(139, 92, 246, 1),
                        0 0 80px rgba(139, 92, 246, 0.6);
            transform: scale(1.02);
        }
    }
    </style>
</div>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/tutorial/onboarding-tutorial.blade.php ENDPATH**/ ?>