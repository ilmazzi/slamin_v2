<x-layouts.app>


<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('groups.show', $group) }}" wire:navigate
           class="inline-flex items-center gap-2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Torna al gruppo
        </a>
        
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-8">Richieste Pendenti - {{ $group->name }}</h1>

        @forelse($requests as $request)
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-4">
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($request->user, 60) }}"
                         alt="{{ $request->user->name }}"
                         class="w-16 h-16 rounded-full object-cover">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white">{{ $request->user->name }}</h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-500">{{ $request->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                
                @if($request->message)
                    <p class="text-neutral-600 dark:text-neutral-400 mb-4 p-4 bg-neutral-50 dark:bg-neutral-800 rounded-lg">
                        "{{ $request->message }}"
                    </p>
                @endif
                
                @if($request->status === 'pending')
                    <div class="flex gap-3">
                        <form action="{{ route('groups.requests.accept', [$group, $request]) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700">
                                Accetta
                            </button>
                        </form>
                        <form action="{{ route('groups.requests.decline', [$group, $request]) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700">
                                Rifiuta
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12 bg-white dark:bg-neutral-900 rounded-2xl">
                <p class="text-neutral-500 dark:text-neutral-400">Nessuna richiesta pendente</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    </div>
</div>
</x-layouts.app>

