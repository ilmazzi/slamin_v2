<div class="newsletter-subscribe">
    @if($subscribed)
        <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
            <p class="font-semibold">✓ Iscrizione completata con successo!</p>
            <p class="text-sm mt-1">Riceverai le nostre newsletter via email.</p>
        </div>
    @else
        <form wire:submit.prevent="subscribe" class="space-y-3">
            @if($error)
                <div class="p-3 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg text-sm">
                    {{ $error }}
                </div>
            @endif

            <div>
                <input type="email" 
                       wire:model="email" 
                       placeholder="La tua email *" 
                       required
                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <div>
                <input type="text" 
                       wire:model="name" 
                       placeholder="Il tuo nome (opzionale)" 
                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold disabled:opacity-50 transition-colors">
                <span wire:loading.remove>Iscriviti alla Newsletter</span>
                <span wire:loading>Iscrizione in corso...</span>
            </button>

            <p class="text-xs text-neutral-500 dark:text-neutral-400 text-center">
                Iscrivendoti accetti di ricevere newsletter da Slamin. Puoi disiscriverti in qualsiasi momento.
            </p>
        </form>
    @endif
</div>
