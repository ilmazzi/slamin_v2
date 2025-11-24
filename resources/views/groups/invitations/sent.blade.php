@extends('components.layouts.app')

@section('content')
<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-8">{{ __('groups.sent_invitations') }}</h1>

        @forelse($invitations as $invitation)
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">{{ $invitation->group->name }}</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-2">
                            Inviato a <strong>{{ $invitation->user->name }}</strong>
                        </p>
                        <p class="text-sm text-neutral-500 dark:text-neutral-500">{{ $invitation->created_at->diffForHumans() }}</p>
                    </div>
                    
                    <span class="px-3 py-1 rounded-lg text-sm font-semibold
                        {{ $invitation->status === 'pending' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300' : '' }}
                        {{ $invitation->status === 'accepted' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : '' }}
                        {{ $invitation->status === 'declined' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : '' }}">
                        {{ ucfirst($invitation->status) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white dark:bg-neutral-900 rounded-2xl">
                <p class="text-neutral-500 dark:text-neutral-400">Nessun invito inviato</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $invitations->links() }}
        </div>
    </div>
</div>
@endsection

