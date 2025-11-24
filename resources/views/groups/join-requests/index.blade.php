@extends('components.layouts.app')

@section('content')
<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-8">{{ __('groups.my_requests') }}</h1>

        @forelse($requests as $request)
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">{{ $request->group->name }}</h3>
                        @if($request->message)
                            <p class="text-neutral-600 dark:text-neutral-400 mb-2">{{ $request->message }}</p>
                        @endif
                        <p class="text-sm text-neutral-500 dark:text-neutral-500">{{ $request->created_at->diffForHumans() }}</p>
                    </div>
                    
                    @if($request->status === 'pending')
                        <div class="flex gap-2">
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300 rounded-lg text-sm font-semibold">
                                In Attesa
                            </span>
                            <form action="{{ route('group-requests.cancel', $request) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                    Annulla
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="px-3 py-1 rounded-lg text-sm font-semibold
                            {{ $request->status === 'accepted' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : '' }}
                            {{ $request->status === 'declined' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : '' }}">
                            {{ ucfirst($request->status) }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white dark:bg-neutral-900 rounded-2xl">
                <p class="text-neutral-500 dark:text-neutral-400">Nessuna richiesta inviata</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection

