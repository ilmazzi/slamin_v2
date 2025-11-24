<x-layouts.app>


<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('groups.announcements.index', $group) }}"
           class="inline-flex items-center gap-2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Torna agli annunci
        </a>
        
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-lg p-8">
            @if($announcement->is_pinned)
                <span class="inline-block px-3 py-1 bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300 text-sm font-semibold rounded-lg mb-4">
                    📌 In Evidenza
                </span>
            @endif
            
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-4">{{ $announcement->title }}</h1>
            
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-neutral-200 dark:border-neutral-700">
                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($announcement->user, 50) }}"
                     alt="{{ $announcement->user->name }}"
                     class="w-12 h-12 rounded-full object-cover">
                <div>
                    <p class="font-semibold text-neutral-900 dark:text-white">{{ $announcement->user->name }}</p>
                    <p class="text-sm text-neutral-500 dark:text-neutral-500">{{ $announcement->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                @if(auth()->check() && ($group->hasModerator(auth()->user()) || $announcement->user_id === auth()->id()))
                    <div class="ml-auto flex gap-2">
                        <a href="{{ route('groups.announcements.edit', [$group, $announcement]) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Modifica
                        </a>
                        <form action="{{ route('groups.announcements.destroy', [$group, $announcement]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Sei sicuro?')"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Elimina
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($announcement->content)) !!}
            </div>
        </div>
    </div>
</div>
</x-layouts.app>

