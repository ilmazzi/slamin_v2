<x-layouts.fluid>
    <x-slot name="title">Fluid Poetry</x-slot>

    <!-- Hero Section - Full Screen -->
    <section class="h-screen snap-start flex items-center justify-center relative px-8">
        <div class="max-w-5xl text-center">
            <h1 class="text-[8vw] font-light leading-[0.9] mb-12" 
                style="font-family: 'Playfair Display', serif;"
                x-data="{ words: ['Nel silenzio', 'della notte', 'le parole', 'danzano'] }"
                x-init="$el.querySelectorAll('span').forEach((span, i) => {
                    setTimeout(() => {
                        span.style.opacity = '1';
                        span.style.transform = 'translateY(0)';
                    }, i * 200);
                })">
                <span class="block opacity-0 transform translate-y-8 transition-all duration-1000">Nel silenzio</span>
                <span class="block opacity-0 transform translate-y-8 transition-all duration-1000 italic text-accent-600 dark:text-accent-400">della notte</span>
                <span class="block opacity-0 transform translate-y-8 transition-all duration-1000">le parole</span>
                <span class="block opacity-0 transform translate-y-8 transition-all duration-1000">danzano</span>
            </h1>
            <p class="text-xl font-light text-neutral-600 dark:text-neutral-400 tracking-wider">
                Un nuovo modo di vivere la poesia
            </p>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex flex-col items-center gap-3 animate-bounce">
            <span class="text-xs font-light tracking-widest text-neutral-400">SCROLL</span>
            <div class="w-px h-12 bg-gradient-to-b from-neutral-400 to-transparent"></div>
        </div>
    </section>

    <!-- Poesia Fluida 1 - Testo che scorre -->
    <section class="min-h-screen snap-start flex items-center relative px-8 py-32">
        <div class="max-w-7xl mx-auto grid grid-cols-12 gap-0 items-center">
            <!-- Testo poetico - colonna sinistra -->
            <div class="col-span-12 lg:col-span-7 relative">
                <div class="sticky top-1/4">
                    <p class="text-[3.5vw] leading-relaxed font-light" 
                       style="font-family: 'Crimson Pro', serif;">
                        <span class="italic text-accent-600 dark:text-accent-400">Tra le righe</span> 
                        di un verso dimenticato,<br>
                        scopro <span class="font-semibold">mondi</span> che non sapevo esistessero.<br><br>
                        Il poeta è un <span class="underline decoration-secondary-500">ladro di emozioni</span>,<br>
                        che ruba al cielo le stelle<br>
                        per farne parole.
                    </p>
                    
                    <!-- Author info - floating -->
                    <div class="mt-16 flex items-center gap-4 text-sm font-light text-neutral-500 dark:text-neutral-400">
                        <div class="w-px h-12 bg-current"></div>
                        <div>
                            <div class="font-medium text-neutral-900 dark:text-white">Alessandro M.</div>
                            <div class="text-xs">3 ore fa · 234 cuori</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spazio vuoto - respirazione -->
            <div class="hidden lg:block col-span-1"></div>

            <!-- Immagine/Visual - floating -->
            <div class="col-span-12 lg:col-span-4 relative h-[60vh]">
                <div class="absolute inset-0 bg-gradient-to-br from-accent-200 to-accent-400 dark:from-accent-800 dark:to-accent-600 rounded-[3rem] transform rotate-3 hover:rotate-6 transition-transform duration-700"></div>
                <div class="absolute inset-4 bg-gradient-to-tl from-secondary-200 to-secondary-300 dark:from-secondary-700 dark:to-secondary-600 rounded-[2.5rem] transform -rotate-2 hover:rotate-0 transition-transform duration-700"></div>
            </div>
        </div>
    </section>

    <!-- Stream di Versi - Colonna Centrale Fluida -->
    <section class="min-h-screen snap-start py-32 px-8">
        <div class="max-w-4xl mx-auto space-y-32">
            <!-- Verso 1 - Grande e centrato -->
            <div class="text-center transform hover:scale-105 transition-transform duration-700">
                <p class="text-5xl lg:text-7xl font-light leading-tight mb-6" 
                   style="font-family: 'Playfair Display', serif;">
                    "L'amore è un <span class="italic text-accent-600 dark:text-accent-400">sussurro</span><br>
                    che il <span class="font-bold">tempo</span> non può dimenticare"
                </p>
                <div class="flex items-center justify-center gap-6 text-sm text-neutral-500 dark:text-neutral-400">
                    <span>Laura B.</span>
                    <span class="w-1 h-1 rounded-full bg-current"></span>
                    <span>142 ❤</span>
                    <span class="w-1 h-1 rounded-full bg-current"></span>
                    <span>28 commenti</span>
                </div>
            </div>

            <!-- Verso 2 - Allineato a sinistra con decorazione -->
            <div class="grid grid-cols-12 gap-8 items-center">
                <div class="col-span-2 hidden lg:block">
                    <div class="w-full h-px bg-gradient-to-r from-transparent via-accent-500 to-transparent"></div>
                </div>
                <div class="col-span-12 lg:col-span-10">
                    <p class="text-4xl font-light leading-relaxed" 
                       style="font-family: 'Crimson Pro', serif;">
                        Nel giardino segreto dei ricordi,<br>
                        ogni petalo è un verso che cade<br>
                        dolcemente nell'oblio del tempo...
                    </p>
                    <div class="mt-6 text-sm text-neutral-500 dark:text-neutral-400 font-light">
                        Marco R. · 5h · 89 cuori
                    </div>
                </div>
            </div>

            <!-- Verso 3 - Con immagine laterale -->
            <div class="grid grid-cols-12 gap-12 items-center">
                <div class="col-span-12 lg:col-span-8">
                    <p class="text-5xl font-light leading-tight" 
                       style="font-family: 'Playfair Display', serif;">
                        Danzano le stelle<br>
                        nel <span class="italic text-secondary-600 dark:text-secondary-400">cielo notturno</span>,<br>
                        mentre io qui scrivo<br>
                        di te
                    </p>
                </div>
                <div class="col-span-12 lg:col-span-4">
                    <div class="aspect-square bg-gradient-to-br from-primary-300 to-primary-500 dark:from-primary-700 dark:to-primary-500 rounded-full"></div>
                </div>
            </div>

            <!-- Verso 4 - Minimal e centrato -->
            <div class="text-center py-16">
                <p class="text-3xl font-extralight italic text-neutral-600 dark:text-neutral-400 tracking-wide"
                   style="font-family: 'Crimson Pro', serif;">
                    "Nel silenzio trovo le parole più vere"
                </p>
            </div>
        </div>
    </section>

    <!-- Evento - Full Width Split -->
    <section class="min-h-screen snap-start grid lg:grid-cols-2">
        <!-- Left - Immagine -->
        <div class="relative bg-gradient-to-br from-secondary-400 via-secondary-500 to-secondary-600 flex items-center justify-center p-16">
            <div class="text-white text-center">
                <div class="text-8xl font-bold mb-4" style="font-family: 'Playfair Display', serif;">
                    05
                </div>
                <div class="text-2xl font-light tracking-widest">NOVEMBRE</div>
            </div>
        </div>

        <!-- Right - Info -->
        <div class="flex flex-col justify-center px-16 py-24 bg-white dark:bg-neutral-900">
            <span class="text-xs font-medium tracking-[0.3em] text-accent-600 dark:text-accent-400 mb-6">POETRY SLAM</span>
            <h2 class="text-6xl font-light leading-tight mb-8" style="font-family: 'Playfair Display', serif;">
                Notte di<br>
                Versi Liberi
            </h2>
            <p class="text-xl font-light text-neutral-600 dark:text-neutral-400 leading-relaxed mb-12 max-w-lg">
                Un evento imperdibile per tutti gli amanti della poesia contemporanea. 
                Voce, emozione, e parole che danzano nell'aria.
            </p>
            
            <div class="flex items-center gap-8">
                <div>
                    <div class="text-sm font-light text-neutral-500 dark:text-neutral-400 mb-2">Dove</div>
                    <div class="text-lg font-medium">Milano, Teatro Strehler</div>
                </div>
                <div class="w-px h-12 bg-neutral-200 dark:bg-neutral-700"></div>
                <div>
                    <div class="text-sm font-light text-neutral-500 dark:text-neutral-400 mb-2">Quando</div>
                    <div class="text-lg font-medium">5 Nov, 21:00</div>
                </div>
            </div>

            <button class="mt-12 inline-flex items-center gap-3 text-lg font-light hover:tracking-widest transition-all duration-500 group">
                <span>PARTECIPA</span>
                <span class="w-12 h-px bg-current group-hover:w-24 transition-all duration-500"></span>
            </button>
        </div>
    </section>

    <!-- Poeti in Movimento - Horizontal Scroll -->
    <section class="h-screen snap-start flex items-center overflow-hidden">
        <div class="flex gap-16 px-8 animate-scroll-horizontal">
            @for($i = 1; $i <= 15; $i++)
            <div class="flex-shrink-0 text-center group">
                <div class="w-48 h-48 mb-6 rounded-full bg-gradient-to-br {{ ['from-accent-300 to-accent-500', 'from-primary-300 to-primary-500', 'from-secondary-300 to-secondary-500'][$i % 3] }} 
                           transform group-hover:scale-110 transition-transform duration-700"></div>
                <div class="text-xl font-light">Poeta {{ $i }}</div>
                <div class="text-sm text-neutral-500 dark:text-neutral-400 font-light">{{ rand(50, 500) }} versi</div>
            </div>
            @endfor
        </div>
    </section>

    <!-- Articolo - Layout Editoriale -->
    <section class="min-h-screen snap-start flex items-center px-8 py-32">
        <div class="max-w-3xl mx-auto">
            <span class="text-xs font-medium tracking-[0.3em] text-secondary-600 dark:text-secondary-400">RIFLESSIONI</span>
            
            <h2 class="text-6xl lg:text-7xl font-light leading-[0.95] mt-6 mb-12" 
                style="font-family: 'Playfair Display', serif;">
                Il potere<br>
                della<br>
                <span class="italic text-accent-600 dark:text-accent-400">poesia</span>
            </h2>

            <div class="prose prose-xl prose-neutral dark:prose-invert font-light leading-relaxed space-y-6"
                 style="font-family: 'Crimson Pro', serif;">
                <p class="text-2xl">
                    La poesia non è solo un insieme di parole disposte in modo armonioso. 
                    È un linguaggio dell'anima, un ponte tra ciò che siamo e ciò che vorremmo essere.
                </p>
                <p class="text-xl text-neutral-600 dark:text-neutral-400">
                    Ogni verso è un respiro, ogni strofa un battito del cuore. 
                    Quando leggiamo poesia, non consumiamo solo parole: viviamo emozioni, 
                    attraversiamo mondi interiori, scopriamo parti di noi che non sapevamo esistessero.
                </p>
            </div>

            <div class="mt-16 flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-400 to-accent-600"></div>
                <div>
                    <div class="font-medium">Elena Ferretti</div>
                    <div class="text-sm text-neutral-500 dark:text-neutral-400 font-light">Poetessa e critica letteraria</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action - Minimal -->
    <section class="h-screen snap-start flex flex-col items-center justify-center text-center px-8">
        <h2 class="text-[6vw] font-light leading-tight mb-12" 
            style="font-family: 'Playfair Display', serif;">
            Inizia a scrivere<br>
            la tua <span class="italic text-accent-600 dark:text-accent-400">storia</span>
        </h2>
        
        <button class="group relative">
            <span class="text-xl font-light tracking-widest">UNISCITI A NOI</span>
            <div class="absolute -bottom-2 left-0 right-0 h-px bg-current transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
        </button>
    </section>

    <style>
        /* Smooth scroll snap */
        #main-scroll {
            scroll-behavior: smooth;
        }

        /* Horizontal scroll animation */
        @keyframes scroll-horizontal {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .animate-scroll-horizontal {
            animation: scroll-horizontal 60s linear infinite;
        }

        .animate-scroll-horizontal:hover {
            animation-play-state: paused;
        }
    </style>
</x-layouts.fluid>

