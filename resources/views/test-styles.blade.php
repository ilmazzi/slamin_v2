<x-layouts.app>
    <x-slot name="title">Test Stili</x-slot>

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-neutral-900 dark:text-neutral-50 mb-4">
                    Test Design System
                </h1>
                <p class="text-xl text-neutral-600 dark:text-neutral-300">
                    Verifica che tutti gli stili funzionino correttamente
                </p>
            </div>

            <!-- Colors Test -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-neutral-900 dark:text-neutral-50 mb-6">
                    Palette Colori
                </h2>
                
                <!-- Primary Colors -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Primary (Slate/Blue)</h3>
                    <div class="flex gap-2">
                        <div class="bg-primary-50 w-20 h-20 rounded-lg"></div>
                        <div class="bg-primary-100 w-20 h-20 rounded-lg"></div>
                        <div class="bg-primary-200 w-20 h-20 rounded-lg"></div>
                        <div class="bg-primary-300 w-20 h-20 rounded-lg"></div>
                        <div class="bg-primary-400 w-20 h-20 rounded-lg"></div>
                        <div class="bg-primary-500 w-20 h-20 rounded-lg"></div>
                        <div class="bg-primary-600 w-20 h-20 rounded-lg"></div>
                        <div class="bg-primary-700 w-20 h-20 rounded-lg"></div>
                        <div class="bg-primary-800 w-20 h-20 rounded-lg"></div>
                        <div class="bg-primary-900 w-20 h-20 rounded-lg"></div>
                    </div>
                </div>

                <!-- Accent Colors -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Accent (Terracotta/Rose)</h3>
                    <div class="flex gap-2">
                        <div class="bg-accent-50 w-20 h-20 rounded-lg"></div>
                        <div class="bg-accent-100 w-20 h-20 rounded-lg"></div>
                        <div class="bg-accent-200 w-20 h-20 rounded-lg"></div>
                        <div class="bg-accent-300 w-20 h-20 rounded-lg"></div>
                        <div class="bg-accent-400 w-20 h-20 rounded-lg"></div>
                        <div class="bg-accent-500 w-20 h-20 rounded-lg"></div>
                        <div class="bg-accent-600 w-20 h-20 rounded-lg"></div>
                        <div class="bg-accent-700 w-20 h-20 rounded-lg"></div>
                        <div class="bg-accent-800 w-20 h-20 rounded-lg"></div>
                        <div class="bg-accent-900 w-20 h-20 rounded-lg"></div>
                    </div>
                </div>

                <!-- Secondary Colors -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Secondary (Sage/Green)</h3>
                    <div class="flex gap-2">
                        <div class="bg-secondary-50 w-20 h-20 rounded-lg"></div>
                        <div class="bg-secondary-100 w-20 h-20 rounded-lg"></div>
                        <div class="bg-secondary-200 w-20 h-20 rounded-lg"></div>
                        <div class="bg-secondary-300 w-20 h-20 rounded-lg"></div>
                        <div class="bg-secondary-400 w-20 h-20 rounded-lg"></div>
                        <div class="bg-secondary-500 w-20 h-20 rounded-lg"></div>
                        <div class="bg-secondary-600 w-20 h-20 rounded-lg"></div>
                        <div class="bg-secondary-700 w-20 h-20 rounded-lg"></div>
                        <div class="bg-secondary-800 w-20 h-20 rounded-lg"></div>
                        <div class="bg-secondary-900 w-20 h-20 rounded-lg"></div>
                    </div>
                </div>
            </div>

            <!-- Buttons Test -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-neutral-900 dark:text-neutral-50 mb-6">
                    Buttons
                </h2>
                <div class="flex flex-wrap gap-4">
                    <button class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition-all">
                        Primary Button
                    </button>
                    <button class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-lg font-medium transition-all">
                        Accent Button
                    </button>
                    <button class="bg-secondary-600 hover:bg-secondary-700 text-white px-6 py-3 rounded-lg font-medium transition-all">
                        Secondary Button
                    </button>
                    <button class="border-2 border-neutral-300 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-800 px-6 py-3 rounded-lg font-medium transition-all">
                        Outline Button
                    </button>
                </div>
            </div>

            <!-- Cards Test -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-neutral-900 dark:text-neutral-50 mb-6">
                    Cards
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-md border border-neutral-200 dark:border-neutral-700 p-6 transition-all hover:shadow-lg hover:translate-y-[-2px]">
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-50 mb-3">
                            Card Title 1
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-300">
                            Questa card usa la palette minimalista con colori neutri e non troppo accesi.
                        </p>
                    </div>
                    <div class="card-interactive p-6">
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-50 mb-3">
                            Card SCSS Custom
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-300">
                            Questa card usa la classe `.card-interactive` dal SCSS.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-md border border-accent-200 dark:border-accent-900 p-6">
                        <h3 class="text-xl font-semibold text-accent-700 dark:text-accent-400 mb-3">
                            Card Accent
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-300">
                            Con bordo accent per evidenziare.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Typography Test -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-neutral-900 dark:text-neutral-50 mb-6">
                    Typography
                </h2>
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-md border border-neutral-200 dark:border-neutral-700 p-8">
                    <h1 class="h1 text-neutral-900 dark:text-neutral-50">Heading 1 - Custom Class</h1>
                    <h2 class="h2 text-neutral-900 dark:text-neutral-50">Heading 2 - Custom Class</h2>
                    <h3 class="h3 text-neutral-900 dark:text-neutral-50">Heading 3 - Custom Class</h3>
                    <p class="body text-neutral-600 dark:text-neutral-300">
                        Questo è un paragrafo con la classe <code class="bg-neutral-100 dark:bg-neutral-700 px-2 py-1 rounded">.body</code> dal SCSS. 
                        Il font è Inter, elegante e leggibile.
                    </p>
                    <p class="caption text-neutral-500 dark:text-neutral-400">
                        Caption text - piccolo ma leggibile
                    </p>
                </div>
            </div>

            <!-- Custom Utilities Test -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-neutral-900 dark:text-neutral-50 mb-6">
                    Custom Utilities
                </h2>
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-md border border-neutral-200 dark:border-neutral-700 p-8">
                    <h3 class="text-gradient text-4xl font-bold mb-4">
                        Text Gradient (SCSS Custom)
                    </h3>
                    <p class="text-balance text-neutral-600 dark:text-neutral-300 mb-4">
                        Questo testo usa text-balance per una migliore leggibilità e distribuzione delle parole su più righe.
                    </p>
                </div>
            </div>

            <!-- Status -->
            <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-500 rounded-xl p-6 text-center">
                <div class="text-4xl mb-2">✅</div>
                <h3 class="text-2xl font-bold text-green-800 dark:text-green-200 mb-2">
                    Se Vedi Questo con Stili
                </h3>
                <p class="text-green-700 dark:text-green-300">
                    Il tuo sistema SCSS + Tailwind funziona perfettamente!
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>

