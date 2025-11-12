<x-layouts.app>
    <x-slot name="title">Poesie</x-slot>

    <div class="min-h-screen">
        {{-- HERO con Poetry Card + Titolo --}}
        <section class="relative py-12 md:py-20 overflow-hidden bg-neutral-900 dark:bg-black">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center gap-6 md:flex-row md:justify-center md:gap-12">
                    
                    <!-- POETRY CARD (pergamena/libro) -->
                    <div class="poetry-page-card">
                        <!-- Decorative corners -->
                        <div class="poetry-corner poetry-corner-tl"></div>
                        <div class="poetry-corner poetry-corner-tr"></div>
                        <div class="poetry-corner poetry-corner-bl"></div>
                        <div class="poetry-corner poetry-corner-br"></div>
                        
                        <!-- Paper texture overlay -->
                        <div class="poetry-paper"></div>
                        
                        <!-- Content -->
                        <div class="poetry-content">
                            <div class="poetry-title">Poesie</div>
                            <div class="poetry-lines">
                                <div class="poetry-line"></div>
                                <div class="poetry-line"></div>
                                <div class="poetry-line"></div>
                                <div class="poetry-line"></div>
                                <div class="poetry-line"></div>
                            </div>
                            <div class="poetry-signature">Slamin</div>
                        </div>
                        
                        <!-- Quill pen icon -->
                        <div class="poetry-quill">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21.71 3.29a1 1 0 00-1.42 0l-18 18a1 1 0 00-.21 1.09A1 1 0 003 23h3a1 1 0 001-1v-3.59l13.71-13.7a1 1 0 000-1.42zM5 21H4v-1h1zm2-2H6v-1h1zm11.29-11.29L7 19V18h1a1 1 0 001-1v-1h1a1 1 0 001-1v-1l11.29-11.29z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- TITOLO A FIANCO -->
                    <div class="text-center md:text-left">
                        <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-tight" style="font-family: 'Crimson Pro', serif;">
                            Poesie & <span class="italic text-accent-400">Versi</span>
                        </h1>
                        <p class="text-xl md:text-2xl text-white/80 mt-4 font-medium">
                            L'arte della parola scritta
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- POEMS SECTION --}}
        <section class="relative py-12 md:py-16 bg-gradient-to-br from-amber-50 via-orange-50 to-amber-50 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
                    <div class="flex items-baseline gap-4">
                        <h2 class="text-5xl md:text-7xl font-black text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                            Poesie
                        </h2>
                        <div class="text-accent-600 dark:text-accent-400 text-3xl md:text-4xl font-black">
                            1,234
                        </div>
                    </div>

                    {{-- Toggle --}}
                    <div class="flex items-center gap-1 bg-white dark:bg-neutral-800 p-1 rounded-full shadow-xl self-start md:self-auto">
                        <button class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all bg-accent-600 text-white shadow-lg">
                            POPOLARI
                        </button>
                        <button class="px-4 md:px-6 py-2 md:py-3 rounded-full font-black text-xs md:text-sm transition-all text-neutral-600 dark:text-neutral-400">
                            RECENTI
                        </button>
                    </div>
                </div>

                {{-- Poems Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @for($i = 1; $i <= 6; $i++)
                    <div class="poem-card group cursor-pointer">
                        <!-- Paper sheet -->
                        <div class="poem-sheet">
                            <!-- Decorative top border -->
                            <div class="poem-border-top"></div>
                            
                            <!-- Content -->
                            <div class="poem-header">
                                <h3 class="poem-title">
                                    {{ ['Il Silenzio della Luna', 'Vento tra i Rami', 'Alba Nascente', 'Echi Lontani', 'Stelle Cadenti', 'Ombre del Passato'][$i-1] }}
                                </h3>
                                <div class="poem-author">
                                    <span>di</span> Poeta {{ $i }}
                                </div>
                            </div>
                            
                            <div class="poem-excerpt">
                                <p>
                                    Nel silenzio della notte eterna,<br>
                                    le parole danzano leggere<br>
                                    come foglie al vento d'autunno,<br>
                                    portando con sé il peso<br>
                                    delle emozioni non dette...
                                </p>
                            </div>
                            
                            <div class="poem-meta">
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ rand(100, 999) }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        {{ rand(10, 99) }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ rand(0, 20) }}
                                    </span>
                                </div>
                                <span class="text-xs text-neutral-500">{{ $i }}h fa</span>
                            </div>
                            
                            <!-- Decorative bottom -->
                            <div class="poem-border-bottom"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </section>
    </div>

    <style>
        /* ========================================
           POETRY PAGE HERO - Card
           ======================================== */
        
        .poetry-page-card {
            position: relative;
            background: linear-gradient(135deg, 
                #f9f7f3 0%,
                #fefdfb 25%,
                #f9f7f3 50%,
                #fefdfb 75%,
                #f9f7f3 100%
            );
            padding: 2rem 1.5rem;
            height: 280px;
            width: 220px;
            border-radius: 4px;
            box-shadow: 
                0 10px 20px rgba(0, 0, 0, 0.15),
                0 20px 40px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            transition: all 0.4s ease;
            border: 1px solid rgba(139, 92, 46, 0.2);
        }
        
        .poetry-page-card:hover {
            transform: translateY(-8px) scale(1.04);
            box-shadow: 
                0 15px 30px rgba(0, 0, 0, 0.2),
                0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        /* Decorative corners */
        .poetry-corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(139, 92, 46, 0.3);
        }
        
        .poetry-corner-tl {
            top: 0.5rem;
            left: 0.5rem;
            border-right: none;
            border-bottom: none;
        }
        
        .poetry-corner-tr {
            top: 0.5rem;
            right: 0.5rem;
            border-left: none;
            border-bottom: none;
        }
        
        .poetry-corner-bl {
            bottom: 0.5rem;
            left: 0.5rem;
            border-right: none;
            border-top: none;
        }
        
        .poetry-corner-br {
            bottom: 0.5rem;
            right: 0.5rem;
            border-left: none;
            border-top: none;
        }
        
        /* Paper texture */
        .poetry-paper {
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.04' numOctaves='5' seed='2' /%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23paper)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1;
        }
        
        /* Content */
        .poetry-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .poetry-title {
            font-family: 'Crimson Pro', serif;
            font-size: 2rem;
            font-weight: 900;
            color: #8b5c2e;
            text-align: center;
            margin-bottom: 1rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .poetry-lines {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.75rem;
            padding: 0 0.5rem;
        }
        
        .poetry-line {
            height: 2px;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(139, 92, 46, 0.2) 10%,
                rgba(139, 92, 46, 0.3) 50%,
                rgba(139, 92, 46, 0.2) 90%,
                transparent 100%
            );
        }
        
        .poetry-signature {
            font-family: 'Brush Script MT', cursive;
            font-size: 1.5rem;
            color: rgba(139, 92, 46, 0.6);
            text-align: right;
            font-style: italic;
            margin-top: 0.5rem;
        }
        
        /* Quill pen */
        .poetry-quill {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            width: 32px;
            height: 32px;
            color: rgba(139, 92, 46, 0.4);
            z-index: 3;
            transform: rotate(-15deg);
            transition: all 0.3s ease;
        }
        
        .poetry-page-card:hover .poetry-quill {
            transform: rotate(-5deg) scale(1.1);
            color: rgba(139, 92, 46, 0.6);
        }
        
        @media (max-width: 768px) {
            .poetry-page-card {
                width: 200px;
                height: 260px;
                padding: 1.75rem 1.25rem;
            }
            
            .poetry-title {
                font-size: 1.75rem;
            }
        }
        
        
        /* ========================================
           POEM CARDS - Grid
           ======================================== */
        
        .poem-card {
            position: relative;
        }
        
        .poem-sheet {
            position: relative;
            background: linear-gradient(135deg, 
                #ffffff 0%,
                #fffef9 50%,
                #ffffff 100%
            );
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.05),
                0 4px 8px rgba(0, 0, 0, 0.04),
                0 8px 16px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            border: 1px solid rgba(139, 92, 46, 0.1);
            min-height: 320px;
            display: flex;
            flex-direction: column;
        }
        
        :is(.dark .poem-sheet) {
            background: linear-gradient(135deg, 
                #2a2520 0%,
                #2d2722 50%,
                #2a2520 100%
            );
            border-color: rgba(139, 92, 46, 0.2);
        }
        
        .poem-card:hover .poem-sheet {
            transform: translateY(-4px);
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.08),
                0 8px 16px rgba(0, 0, 0, 0.06),
                0 16px 32px rgba(0, 0, 0, 0.05);
        }
        
        .poem-border-top {
            height: 3px;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(139, 92, 46, 0.3) 50%,
                transparent 100%
            );
            margin-bottom: 1rem;
        }
        
        .poem-border-bottom {
            height: 2px;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(139, 92, 46, 0.2) 50%,
                transparent 100%
            );
            margin-top: auto;
            padding-top: 1rem;
        }
        
        .poem-header {
            margin-bottom: 1rem;
        }
        
        .poem-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #8b5c2e;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }
        
        :is(.dark .poem-title) {
            color: #d4a574;
        }
        
        .poem-author {
            font-size: 0.875rem;
            color: rgba(139, 92, 46, 0.7);
            font-style: italic;
        }
        
        :is(.dark .poem-author) {
            color: rgba(212, 165, 116, 0.7);
        }
        
        .poem-author span {
            font-size: 0.75rem;
            opacity: 0.6;
        }
        
        .poem-excerpt {
            flex: 1;
            font-family: 'Crimson Pro', serif;
            font-size: 0.9375rem;
            line-height: 1.7;
            color: #4a4a4a;
            font-style: italic;
            margin-bottom: 1rem;
        }
        
        :is(.dark .poem-excerpt) {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .poem-excerpt p {
            margin: 0;
        }
        
        .poem-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(139, 92, 46, 0.1);
            color: #8b5c2e;
            font-size: 0.875rem;
        }
        
        :is(.dark .poem-meta) {
            border-color: rgba(139, 92, 46, 0.2);
            color: #d4a574;
        }
        
        .poem-meta svg {
            flex-shrink: 0;
        }
    </style>
</x-layouts.app>
