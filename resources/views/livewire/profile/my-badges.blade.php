<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2 flex items-center gap-3">
                        <span class="text-amber-500">🏆</span>
                        {{ __('gamification.my_badges') }}
                    </h1>
                    <p class="text-neutral-600 dark:text-neutral-400 hidden md:block">
                        {{ __('La tua collezione completa di badge - sblocca nuovi achievement!') }}
                    </p>
                </div>
                <a href="{{ route('profile.show') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('Torna al Profilo') }}</span>
                    <span class="sm:hidden">{{ __('Profilo') }}</span>
                </a>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <!-- Badge Sbloccati -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-4 text-center">
                <div class="text-3xl md:text-4xl mb-2">🎖️</div>
                <h3 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-1">
                    {{ $badges->count() }}
                </h3>
                <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('Badge Sbloccati') }}
                </p>
            </div>

            <!-- Punti Totali -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-4 text-center">
                <div class="text-3xl md:text-4xl mb-2">⭐</div>
                <h3 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-1">
                    {{ $badges->sum(fn($b) => $b->badge->points ?? 0) }}
                </h3>
                <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('Punti Totali') }}
                </p>
            </div>

            <!-- Livello Attuale -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-4 text-center">
                <div class="text-3xl md:text-4xl mb-2">📈</div>
                <h3 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-1">
                    {{ Auth::user()->userPoints->level ?? 1 }}
                </h3>
                <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('Livello Attuale') }}
                </p>
            </div>

            <!-- Da Sbloccare -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-4 text-center">
                <div class="text-3xl md:text-4xl mb-2">🔓</div>
                <h3 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-1">
                    {{ \App\Models\Badge::active()->count() - $badges->count() }}
                </h3>
                <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('Da Sbloccare') }}
                </p>
            </div>
        </div>

        <!-- Trophy Case Grid -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    {{ __('Collezione Completa') }}
                </h2>
            </div>
            <div class="p-6">
                @if($badges && $badges->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($badges as $userBadge)
                            <div class="group relative bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-xl p-4 border-2 border-amber-200 dark:border-amber-700 hover:border-amber-400 dark:hover:border-amber-500 transition-all hover:scale-105 hover:shadow-lg">
                                <div class="text-center">
                                    <img src="{{ $userBadge->badge->icon_url ?? asset('assets/images/draghetto.png') }}" 
                                         alt="{{ $userBadge->badge->name }}" 
                                         class="w-16 h-16 mx-auto mb-2 rounded-full object-cover">
                                    <h3 class="font-semibold text-sm text-neutral-900 dark:text-white mb-1 line-clamp-2">
                                        {{ $userBadge->badge->name }}
                                    </h3>
                                    <p class="text-xs text-neutral-600 dark:text-neutral-400 mb-2">
                                        +{{ $userBadge->badge->points }} {{ __('punti') }}
                                    </p>
                                    <div class="text-xs text-amber-600 dark:text-amber-400">
                                        {{ $userBadge->earned_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🎯</div>
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('Nessun badge ancora') }}
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-4">
                            {{ __('Inizia a interagire con la community per guadagnare i tuoi primi badge!') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

