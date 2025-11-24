@extends('components.layouts.app')

@section('content')
<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('groups.show', $group) }}" wire:navigate
                   class="inline-flex items-center gap-2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Torna al gruppo
                </a>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Annunci - {{ $group->name }}</h1>
            </div>
            
            @if(auth()->check() && $group->hasModerator(auth()->user()))
                <a href="{{ route('groups.announcements.create', $group) }}"
                   class="px-6 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700">
                    Nuovo Annuncio
                </a>
            @endif
        </div>

        @forelse($announcements as $announcement)
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-4 {{ $announcement->is_pinned ? 'border-2 border-primary-500' : '' }}">
                @if($announcement->is_pinned)
                    <span class="inline-block px-3 py-1 bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300 text-xs font-semibold rounded-lg mb-3">
                        📌 In Evidenza
                    </span>
                @endif
                
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">{{ $announcement->title }}</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-3">{{ Str::limit($announcement->content, 200) }}</p>
                        <div class="flex items-center gap-3 text-sm text-neutral-500 dark:text-neutral-500">
                            <span>{{ $announcement->user->name }}</span>
                            <span>•</span>
                            <span>{{ $announcement->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('groups.announcements.show', [$group, $announcement]) }}"
                       class="px-4 py-2 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-200 dark:hover:bg-neutral-700">
                        Leggi
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white dark:bg-neutral-900 rounded-2xl">
                <p class="text-neutral-500 dark:text-neutral-400">Nessun annuncio pubblicato</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection

