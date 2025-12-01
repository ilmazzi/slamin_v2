<div>
    <div 
        x-data="{
            currentStep: <?php echo \Illuminate\Support\Js::from($currentStep)->toHtml() ?>,
            steps: <?php echo \Illuminate\Support\Js::from($this->steps)->toHtml() ?>,
            highlightedElement: null,
            highlightRect: null,
            isScrolling: false,
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
            get overlayTopStyle() {
                if (!this.highlightRect) return '';
                return `height: ${Math.max(0, this.highlightRect.y - 8)}px;`;
            },
            get overlayBottomStyle() {
                if (!this.highlightRect) return '';
                return `top: ${this.highlightRect.y + this.highlightRect.height + 8}px;`;
            },
            get overlayLeftStyle() {
                if (!this.highlightRect) return '';
                return `
                    left: 0;
                    top: ${Math.max(0, this.highlightRect.y - 8)}px;
                    width: ${Math.max(0, this.highlightRect.x - 8)}px;
                    height: ${this.highlightRect.height + 16}px;
                `;
            },
            get overlayRightStyle() {
                if (!this.highlightRect) return '';
                return `
                    right: 0;
                    top: ${Math.max(0, this.highlightRect.y - 8)}px;
                    left: ${this.highlightRect.x + this.highlightRect.width + 8}px;
                    height: ${this.highlightRect.height + 16}px;
                `;
            },
            updateHighlight() {
                // Remove previous highlights
                document.querySelectorAll('.tutorial-highlight').forEach(el => {
                    el.classList.remove('tutorial-highlight');
                });
                console.log('Tutorial: updateHighlight - clearing previous highlight');
                this.highlightedElement = null;
                this.highlightRect = null;
                
                const stepData = this.currentStepData;
                console.log('Tutorial: updateHighlight called for step', this.currentStep, 'focusElement:', stepData?.focusElement);
                
                if (stepData && stepData.focusElement) {
                    // Funzione per cercare e evidenziare l'elemento
                    const findAndHighlight = () => {
                        const selector = `[data-tutorial-focus='${stepData.focusElement}']`;
                        console.log('Tutorial: Searching for selector:', selector);
                        const allElements = document.querySelectorAll(selector);
                        console.log('Tutorial: Found elements:', allElements.length, Array.from(allElements));
                        
                        let element = null;
                        
                        // Cerca l'elemento - meno restrittivo
                        for (let el of allElements) {
                            const rect = el.getBoundingClientRect();
                            const style = window.getComputedStyle(el);
                            const isVisible = rect.width > 0 && rect.height > 0 && 
                                            style.display !== 'none' && 
                                            style.visibility !== 'hidden';
                            
                            console.log('Tutorial: Checking element:', el, {
                                tagName: el.tagName,
                                rect: { width: rect.width, height: rect.height, left: rect.left, top: rect.top },
                                display: style.display,
                                visibility: style.visibility,
                                opacity: style.opacity,
                                isVisible: isVisible
                            });
                            
                            // Accetta elementi visibili (anche con opacity bassa)
                            if (isVisible) {
                                // Preferisci nav se disponibile
                                if (el.tagName === 'NAV' || !element) {
                                    element = el;
                                    console.log('Tutorial: Element selected:', element);
                                }
                            }
                        }
                        
                        if (element) {
                            console.log('Tutorial: Element found, highlighting:', element);
                            this.highlightElement(element);
                        } else {
                            console.warn('Tutorial: No visible element found for:', stepData.focusElement);
                            const allTutorialElements = document.querySelectorAll('[data-tutorial-focus]');
                            console.warn('Tutorial: All elements with data-tutorial-focus:', Array.from(allTutorialElements).map(el => ({
                                focus: el.getAttribute('data-tutorial-focus'),
                                tag: el.tagName,
                                visible: el.getBoundingClientRect().width > 0
                            })));
                            this.highlightRect = null;
                            this.highlightedElement = null;
                        }
                    };
                    
                    // Prova subito
                    setTimeout(findAndHighlight, 100);
                    
                    // Riprova più volte se non trovato
                    setTimeout(() => {
                        if (!this.highlightedElement) {
                            console.log('Tutorial: Retry 1 - finding element...');
                            findAndHighlight();
                        }
                    }, 500);
                    
                    setTimeout(() => {
                        if (!this.highlightedElement) {
                            console.log('Tutorial: Retry 2 - finding element...');
                            findAndHighlight();
                        }
                    }, 1000);
                    
                    setTimeout(() => {
                        if (!this.highlightedElement) {
                            console.log('Tutorial: Retry 3 - finding element...');
                            findAndHighlight();
                        }
                    }, 2000);
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
                const style = window.getComputedStyle(element);
                console.log('Tutorial: Element rect:', rect, 'style:', {
                    display: style.display,
                    visibility: style.visibility,
                    opacity: style.opacity,
                    position: style.position
                });
                
                if (rect.width === 0 || rect.height === 0) {
                    console.warn('Tutorial: Element found but not visible (width or height is 0):', element);
                    this.highlightRect = null;
                    this.highlightedElement = null;
                    return;
                }
                
                // Scroll solo se necessario (non per elementi fixed)
                const isFixed = style.position === 'fixed';
                
                // Imposta il rect immediatamente PRIMA di qualsiasi scroll
                this.highlightRect = {
                    x: rect.left,
                    y: rect.top,
                    width: rect.width,
                    height: rect.height
                };
                console.log('Tutorial: Initial highlight rect set:', this.highlightRect);
                
                if (!isFixed) {
                    // Imposta flag per prevenire aggiornamenti durante lo scroll
                    this.isScrolling = true;
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    // Aspetta che lo scroll finisca
                    setTimeout(() => {
                        this.isScrolling = false;
                        // Aggiorna il rect dopo lo scroll
                        this.updateHighlightRect();
                        console.log('Tutorial: Scroll completed, highlight rect:', this.highlightRect);
                    }, 800); // Tempo sufficiente per lo scroll smooth
                } else {
                    // Per elementi fixed, aggiorna subito
                    this.isScrolling = false;
                }
                
                // Aggiungi la classe immediatamente - il CSS gestisce tutto
                element.classList.add('tutorial-highlight');
                
                // Forza reattività di Alpine.js immediatamente
                this.$nextTick(() => {
                    this.highlightRect = { ...this.highlightRect };
                    console.log('Tutorial: Forced reactivity update, highlightRect:', this.highlightRect);
                });
                
                // Update rect periodically per gestire scroll/resize (solo dopo lo scroll iniziale)
                setTimeout(() => {
                    const interval = setInterval(() => {
                        if (this.highlightedElement && this.highlightedElement.classList.contains('tutorial-highlight')) {
                            this.updateHighlightRect();
                        } else {
                            clearInterval(interval);
                        }
                    }, 100);
                }, isFixed ? 100 : 900);
            },
            updateHighlightRect() {
                // Non aggiornare durante lo scroll iniziale
                if (this.isScrolling) {
                    console.log('Tutorial: Skipping updateHighlightRect during initial scroll');
                    return;
                }
                
                if (this.highlightedElement) {
                    const rect = this.highlightedElement.getBoundingClientRect();
                    
                    // Verifica che l'elemento sia ancora visibile
                    if (rect.width === 0 || rect.height === 0) {
                        console.warn('Tutorial: Element became invisible, skipping update');
                        return;
                    }
                    
                    // Usa coordinate viewport perché l'overlay è fixed
                    const newRect = {
                        x: rect.left,
                        y: rect.top,
                        width: rect.width,
                        height: rect.height
                    };
                    
                    // Aggiorna solo se le coordinate sono cambiate significativamente
                    if (!this.highlightRect || 
                        Math.abs(this.highlightRect.x - newRect.x) > 1 ||
                        Math.abs(this.highlightRect.y - newRect.y) > 1 ||
                        Math.abs(this.highlightRect.width - newRect.width) > 1 ||
                        Math.abs(this.highlightRect.height - newRect.height) > 1) {
                        
                        this.highlightRect = newRect;
                        console.log('Tutorial: updateHighlightRect updated', {
                            element: this.highlightedElement,
                            rect: rect,
                            highlightRect: this.highlightRect
                        });
                        
                        // Forza re-render di Alpine.js
                        this.$nextTick(() => {
                            // Trigger reactivity
                            this.highlightRect = { ...this.highlightRect };
                        });
                    }
                } else {
                    console.warn('Tutorial: updateHighlightRect called but no highlightedElement');
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
            $watch('highlightRect', (value, oldValue) => {
                console.log('Tutorial: highlightRect changed', {
                    from: oldValue,
                    to: value,
                    hasHighlightedElement: !!highlightedElement
                });
            });
            $watch('highlightedElement', (value) => {
                console.log('Tutorial: highlightedElement changed', value ? value.getAttribute('data-tutorial-focus') : null);
            });
            if ($wire.show) {
                setTimeout(() => updateHighlight(), 300);
            }
            window.addEventListener('scroll', () => {
                if (!isScrolling) {
                    updateHighlightRect();
                }
            });
            window.addEventListener('resize', () => {
                if (!isScrolling) {
                    updateHighlightRect();
                }
            });
        "
        class="fixed inset-0 z-[999998]"
        style="display: none;"
        x-show="$wire.show"
        x-cloak
    >
        <!-- Overlay uniforme - molto più trasparente quando c'è elemento evidenziato -->
        <div class="absolute inset-0 pointer-events-auto"
             @click.self="$wire.close()"
             style="z-index: 1;"
             x-bind:class="highlightRect && highlightedElement ? 'bg-black/10' : 'bg-black/40 backdrop-blur-sm'">
        </div>
        
        <!-- Bordo pulsante attorno all'elemento evidenziato (sopra overlay) -->
        <div x-show="highlightRect && highlightedElement"
             x-cloak
             class="fixed pointer-events-none tutorial-spotlight"
             x-bind:style="highlightStyle"
             style="z-index: 1000001;">
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
        z-index: 1000002 !important;
        transform: scale(1.01);
        transition: transform 0.3s ease;
        outline: 6px solid #059669 !important;
        outline-offset: 6px;
        border-radius: 8px;
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.3),
                    0 0 0 8px rgba(5, 150, 105, 0.2),
                    0 0 30px rgba(5, 150, 105, 0.8),
                    0 0 60px rgba(5, 150, 105, 0.5) !important;
        animation: pulse-highlight 2s infinite;
    }

    .tutorial-spotlight {
        border: 10px solid #059669;
        border-radius: 20px;
        background: rgba(5, 150, 105, 0.15);
        box-shadow: 0 0 0 8px rgba(255, 255, 255, 0.8),
                    0 0 0 16px rgba(5, 150, 105, 0.4),
                    0 0 50px rgba(5, 150, 105, 1),
                    0 0 100px rgba(5, 150, 105, 0.8),
                    inset 0 0 30px rgba(5, 150, 105, 0.3);
        animation: pulse-border 2s infinite;
        z-index: 1000001 !important;
    }

    @keyframes pulse-highlight {
        0%, 100% {
            outline-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.3),
                        0 0 0 8px rgba(5, 150, 105, 0.2),
                        0 0 30px rgba(5, 150, 105, 0.8),
                        0 0 60px rgba(5, 150, 105, 0.5);
        }
        50% {
            outline-color: #10b981;
            box-shadow: 0 0 0 6px rgba(5, 150, 105, 0.5),
                        0 0 0 12px rgba(5, 150, 105, 0.3),
                        0 0 40px rgba(5, 150, 105, 1),
                        0 0 80px rgba(5, 150, 105, 0.7);
        }
    }

    @keyframes pulse-border {
        0%, 100% {
            border-color: #059669;
            box-shadow: 0 0 0 8px rgba(255, 255, 255, 0.8),
                        0 0 0 16px rgba(5, 150, 105, 0.4),
                        0 0 50px rgba(5, 150, 105, 1),
                        0 0 100px rgba(5, 150, 105, 0.8),
                        inset 0 0 30px rgba(5, 150, 105, 0.3);
            transform: scale(1);
        }
        50% {
            border-color: #10b981;
            box-shadow: 0 0 0 12px rgba(255, 255, 255, 1),
                        0 0 0 24px rgba(5, 150, 105, 0.6),
                        0 0 70px rgba(5, 150, 105, 1.2),
                        0 0 140px rgba(5, 150, 105, 1),
                        inset 0 0 40px rgba(5, 150, 105, 0.5);
            transform: scale(1.01);
        }
    }
    </style>
</div>
<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/tutorial/onboarding-tutorial.blade.php ENDPATH**/ ?>