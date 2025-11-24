<x-layouts.app>


<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('groups.show', $group) }}" wire:navigate
               class="inline-flex items-center gap-2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Torna al gruppo
            </a>
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">{{ __('groups.members') }} - {{ $group->name }}</h1>
        </div>

        {{-- Members Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($members as $member)
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($member->user, 80) }}"
                             alt="{{ $member->user->name }}"
                             class="w-16 h-16 rounded-full object-cover ring-4 ring-primary-100 dark:ring-primary-900">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('profile.show', $member->user) }}" wire:navigate
                               class="text-lg font-bold text-neutral-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 truncate block">
                                {{ $member->user->name }}
                            </a>
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-lg
                                {{ $member->role === 'admin' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : '' }}
                                {{ $member->role === 'moderator' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : '' }}
                                {{ $member->role === 'member' ? 'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300' : '' }}">
                                {{ __('groups.role_' . $member->role) }}
                            </span>
                        </div>
                    </div>
                    
                    @if($isAdmin && $member->user_id !== auth()->id())
                        <div class="flex gap-2">
                            @if($member->role === 'member')
                                <form action="{{ route('groups.members.promote-moderator', [$group, $member]) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                        Promuovi Moderatore
                                    </button>
                                </form>
                            @elseif($member->role === 'moderator')
                                <form action="{{ route('groups.members.promote', [$group, $member]) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-3 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
                                        Promuovi Admin
                                    </button>
                                </form>
                                <form action="{{ route('groups.members.demote-member', [$group, $member]) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-3 py-2 bg-amber-600 text-white rounded-lg text-sm hover:bg-amber-700">
                                        Retrocedi
                                    </button>
                                </form>
                            @elseif($member->role === 'admin')
                                <form action="{{ route('groups.members.demote', [$group, $member]) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-3 py-2 bg-amber-600 text-white rounded-lg text-sm hover:bg-amber-700">
                                        Retrocedi Moderatore
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('groups.members.remove', [$group, $member]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Sei sicuro?')" class="px-3 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
                                    Rimuovi
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $members->links() }}
        </div>
    </div>
</div>
</x-layouts.app>

