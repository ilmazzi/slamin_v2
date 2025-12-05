<x-layouts.app>


<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-8">{{ __('groups.my_invitations') }}</h1>

        @forelse($invitations as $item)
            @php
                $invitation = $item['invitation'];
                $type = $item['type'];
            @endphp
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        @if($type === 'group')
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">{{ $invitation->group->name }}</h3>
                            <p class="text-neutral-600 dark:text-neutral-400 mb-2">
                                Invitato da <strong>{{ $invitation->invitedBy->name }}</strong>
                            </p>
                        @else
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                                {{ $invitation->event->title }}
                            </h3>
                            <p class="text-neutral-600 dark:text-neutral-400 mb-2">
                                Invitato da <strong>{{ $invitation->inviter->name }}</strong> come 
                                <strong>
                                    @if($invitation->role === 'performer')
                                        {{ __('events.invitation.role_performer') }}
                                    @elseif($invitation->role === 'organizer')
                                        {{ __('events.invitation.role_organizer') }}
                                    @elseif($invitation->role === 'audience')
                                        {{ __('events.invitation.role_audience') }}
                                    @else
                                        {{ __('events.invitation.role_participant') }}
                                    @endif
                                </strong>
                            </p>
                        @endif
                        <p class="text-sm text-neutral-500 dark:text-neutral-500">{{ $invitation->created_at->diffForHumans() }}</p>
                    </div>
                    
                    @if($invitation->status === 'pending')
                        <div class="flex gap-2">
                            @if($type === 'group')
                                <form action="{{ route('group-invitations.accept', $invitation) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                        Accetta
                                    </button>
                                </form>
                                <form action="{{ route('group-invitations.decline', $invitation) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        Rifiuta
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('event-invitations.accept', $invitation) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                        {{ __('events.invitation.accept') }}
                                    </button>
                                </form>
                                <form action="{{ route('event-invitations.decline', $invitation) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        {{ __('events.invitation.decline') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <span class="px-3 py-1 rounded-lg text-sm font-semibold
                            {{ $invitation->status === 'accepted' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : '' }}
                            {{ $invitation->status === 'declined' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : '' }}">
                            @if($invitation->status === 'accepted')
                                {{ __('events.invitation.accepted') }}
                            @elseif($invitation->status === 'declined')
                                {{ __('events.invitation.declined') }}
                            @else
                                {{ ucfirst($invitation->status) }}
                            @endif
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white dark:bg-neutral-900 rounded-2xl">
                <p class="text-neutral-500 dark:text-neutral-400">Nessun invito ricevuto</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $invitations->links() }}
        </div>
    </div>
</div>
</x-layouts.app>

