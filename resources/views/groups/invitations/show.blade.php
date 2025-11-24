@extends('components.layouts.app')

@section('content')
<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">Dettagli Invito</h1>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-neutral-500 dark:text-neutral-400">Gruppo</label>
                    <p class="text-lg font-semibold text-neutral-900 dark:text-white">{{ $invitation->group->name }}</p>
                </div>
                
                <div>
                    <label class="text-sm text-neutral-500 dark:text-neutral-400">Invitato da</label>
                    <p class="text-lg font-semibold text-neutral-900 dark:text-white">{{ $invitation->invitedBy->name }}</p>
                </div>
                
                <div>
                    <label class="text-sm text-neutral-500 dark:text-neutral-400">Data</label>
                    <p class="text-lg text-neutral-900 dark:text-white">{{ $invitation->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div>
                    <label class="text-sm text-neutral-500 dark:text-neutral-400">Stato</label>
                    <p class="text-lg font-semibold text-neutral-900 dark:text-white">{{ ucfirst($invitation->status) }}</p>
                </div>
            </div>
            
            @if($invitation->status === 'pending' && $invitation->user_id === auth()->id())
                <div class="flex gap-3 mt-8">
                    <form action="{{ route('group-invitations.accept', $invitation) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700">
                            Accetta Invito
                        </button>
                    </form>
                    <form action="{{ route('group-invitations.decline', $invitation) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700">
                            Rifiuta Invito
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

