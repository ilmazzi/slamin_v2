<div>
    <div 
        x-data="{
            currentStep: @js($currentStep),
            steps: @js($this->steps),
            highlightedElement: null,
            highlightRect: null,
            
            get currentStepData() {
                return this.steps[this.currentStep] || this.steps[0];
            },
            
            get highlightStyle() {
                if (!this.highlightRect) return '';
                const r = this.highlightRect;
                return `left: ${r.x - 8}px; top: ${r.y - 8}px; width: ${r.width + 16}px; height: ${r.height + 16}px;`;
            },
            
            updateHighlight() {
                const stepData = this.currentStepData;
                
                // Rimuovi tutto
                document.querySelectorAll('.tutorial-highlight').forEach(el => {
                    el.classList.remove('tutorial-highlight');
                });
                this.highlightedElement = null;
                this.highlightRect = null;
                
                if (!stepData || !stepData.focusElement) {
                    return;
                }
                
                const selector = `[data-tutorial-focus='${stepData.focusElement}']`;
                
                // Prova a trovare l'elemento con più tentativi
                const tryFind = (attempt = 0) => {
                    const element = document.querySelector(selector);
                    
                    if (element) {
                        const rect = element.getBoundingClientRect();
                        const style = window.getComputedStyle(element);
                        
                        if (rect.width > 0 && rect.height > 0 && style.display !== 'none' && style.visibility !== 'hidden') {
                            this.highlightedElement = element;
                            element.classList.add('tutorial-highlight');
                            
                            const updateRect = () => {
                                const r = element.getBoundingClientRect();
                                this.highlightRect = {
                                    x: r.left,
                                    y: r.top,
                                    width: r.width,
                                    height: r.height
                                };
                            };
                            
                            updateRect();
                            
                            if (style.position !== 'fixed') {
                                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                setTimeout(updateRect, 600);
                            }
                            
                            return;
                        }
                    }
                    
                    // Riprova se non trovato
                    if (attempt < 5) {
                        setTimeout(() => tryFind(attempt + 1), 200 * (attempt + 1));
                    }
                };
                
                tryFind();
            }
        }"
        x-init="
            $watch('$wire.currentStep', () => {
                currentStep = $wire.currentStep;
                updateHighlight();
            });
            
            $watch('$wire.show', (value) => {
                if (value) {
                    setTimeout(() => updateHighlight(), 100);
                }
            });
            
            if ($wire.show) {
                setTimeout(() => updateHighlight(), 100);
            }
        "
        class="fixed inset-0 z-[999998]"
        style="display: none;"
        x-show="$wire.show"
        x-cloak
    >
        <div class="absolute inset-0 pointer-events-auto"
             @click.self="$wire.close()"
             style="z-index: 1;"
             :class="highlightRect && highlightedElement ? 'bg-black/10' : 'bg-black/40 backdrop-blur-sm'">
        </div>
        
        <div x-show="highlightRect && highlightedElement"
             class="fixed pointer-events-none tutorial-spotlight"
             :style="highlightStyle"
             style="z-index: 1000001;">
        </div>

        <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none" style="z-index: 1000000;">
            <div class="relative bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl max-w-2xl w-full p-6 md:p-8 pointer-events-auto">
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
                    <button @click="$wire.close()" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="mb-6">
                    <div class="prose prose-sm dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300" x-html="currentStepData.content"></div>
                </div>
                <div class="mb-6">
                    <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full transition-all duration-300" :style="`width: ${((currentStep + 1) / steps.length) * 100}%`"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <button @click="$wire.skip()" class="px-4 py-2 text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200 transition-colors">Salta tutorial</button>
                    <div class="flex gap-3">
                        <button x-show="currentStep > 0" @click="$wire.previous()" class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 rounded-lg transition-colors">Indietro</button>
                        <button x-show="currentStep < steps.length - 1" @click="$wire.next()" class="px-6 py-2 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors shadow-lg">Prosegui</button>
                        <button x-show="currentStep >= steps.length - 1" @click="$wire.close()" class="px-6 py-2 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors shadow-lg">Inizia a esplorare!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .tutorial-highlight {
        z-index: 1000002 !important;
        outline: 6px solid #059669 !important;
        outline-offset: 6px;
        border-radius: 8px;
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.3), 0 0 0 8px rgba(5, 150, 105, 0.2), 0 0 30px rgba(5, 150, 105, 0.8), 0 0 60px rgba(5, 150, 105, 0.5) !important;
        animation: pulse-highlight 2s infinite;
    }
    .tutorial-spotlight {
        border: 8px solid #059669;
        border-radius: 16px;
        background: rgba(5, 150, 105, 0.1);
        box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.8), 0 0 0 12px rgba(5, 150, 105, 0.4), 0 0 40px rgba(5, 150, 105, 1), 0 0 80px rgba(5, 150, 105, 0.8);
        animation: pulse-border 2s infinite;
    }
    @keyframes pulse-highlight {
        0%, 100% { outline-color: #059669; box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.3), 0 0 0 8px rgba(5, 150, 105, 0.2), 0 0 30px rgba(5, 150, 105, 0.8), 0 0 60px rgba(5, 150, 105, 0.5); }
        50% { outline-color: #10b981; box-shadow: 0 0 0 6px rgba(5, 150, 105, 0.5), 0 0 0 12px rgba(5, 150, 105, 0.3), 0 0 40px rgba(5, 150, 105, 1), 0 0 80px rgba(5, 150, 105, 0.7); }
    }
    @keyframes pulse-border {
        0%, 100% { border-color: #059669; box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.8), 0 0 0 12px rgba(5, 150, 105, 0.4), 0 0 40px rgba(5, 150, 105, 1), 0 0 80px rgba(5, 150, 105, 0.8); }
        50% { border-color: #10b981; box-shadow: 0 0 0 8px rgba(255, 255, 255, 1), 0 0 0 16px rgba(5, 150, 105, 0.6), 0 0 50px rgba(5, 150, 105, 1.2), 0 0 100px rgba(5, 150, 105, 1); }
    }
    </style>
</div>
