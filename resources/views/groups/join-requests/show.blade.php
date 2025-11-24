<x-layouts.app>


<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">Dettagli Richiesta</h1>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-neutral-500 dark:text-neutral-400">Gruppo</label>
                    <p class="text-lg font-semibold text-neutral-900 dark:text-white">{{ $request->group->name }}</p>
                </div>
                
                <div>
                    <label class="text-sm text-neutral-500 dark:text-neutral-400">Richiedente</label>
                    <p class="text-lg font-semibold text-neutral-900 dark:text-white">{{ $request->user->name }}</p>
                </div>
                
                @if($request->message)
                    <div>
                        <label class="text-sm text-neutral-500 dark:text-neutral-400">Messaggio</label>
                        <p class="text-lg text-neutral-900 dark:text-white p-4 bg-neutral-50 dark:bg-neutral-800 rounded-lg">{{ $request->message }}</p>
                    </div>
                @endif
                
                <div>
                    <label class="text-sm text-neutral-500 dark:text-neutral-400">Data</label>
                    <p class="text-lg text-neutral-900 dark:text-white">{{ $request->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div>
                    <label class="text-sm text-neutral-500 dark:text-neutral-400">Stato</label>
                    <p class="text-lg font-semibold text-neutral-900 dark:text-white">{{ ucfirst($request->status) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>

