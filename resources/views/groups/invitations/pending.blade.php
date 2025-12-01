<x-layouts.app>
<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('groups.show', $group) }}" wire:navigate
           class="inline-flex items-center gap-2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('groups.back_to_group') }}
        </a>
        
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-8">{{ __('groups.pending_invitations') }} - {{ $group->name }}</h1>

        @forelse($invitations as $invitation)
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-4">
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($invitation->user, 60) }}"
                         alt="{{ $invitation->user->name }}"
                         class="w-16 h-16 rounded-full object-cover">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white">{{ $invitation->user->name }}</h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-500">
                            {{ __('groups.invited_by') }} {{ $invitation->invitedBy->name }} • {{ $invitation->created_at->diffForHumans() }}
                        </p>
                        @if($invitation->expires_at)
                            <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">
                                {{ __('groups.expires_at') }} {{ $invitation->expires_at->format('d/m/Y H:i') }}
                            </p>
                        @endif
                    </div>
                    
                    <div class="flex gap-2">
                        @if($invitation->status === 'pending')
                            <form action="{{ route('group-invitations.cancel', $invitation) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('{{ __('groups.cancel_invitation_confirm') }}')"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                    {{ __('groups.cancel_invitation') }}
                                </button>
                            </form>
                        @else
                            <span class="px-3 py-1 rounded-lg text-sm font-semibold
                                {{ $invitation->status === 'accepted' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : '' }}
                                {{ $invitation->status === 'declined' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : '' }}
                                {{ $invitation->status === 'expired' ? 'bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300' : '' }}">
                                {{ ucfirst($invitation->status) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white dark:bg-neutral-900 rounded-2xl">
                <p class="text-neutral-500 dark:text-neutral-400">{{ __('groups.no_pending_invitations') }}</p>
                <a href="{{ route('groups.invitations.create', $group) }}"
                   class="mt-4 inline-block px-6 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700">
                    {{ __('groups.invite_user') }}
                </a>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $invitations->links() }}
        </div>
    </div>
</div>
</x-layouts.app>

