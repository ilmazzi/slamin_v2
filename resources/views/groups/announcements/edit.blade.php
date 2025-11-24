@extends('components.layouts.app')

@section('content')
<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">Modifica Annuncio</h1>
            
            <form action="{{ route('groups.announcements.update', [$group, $announcement]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Titolo
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}" required
                           class="w-full px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 focus:ring-2 focus:ring-primary-500 text-neutral-900 dark:text-white">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Contenuto
                    </label>
                    <textarea id="content" name="content" rows="8" required
                              class="w-full px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 focus:ring-2 focus:ring-primary-500 text-neutral-900 dark:text-white">{{ old('content', $announcement->content) }}</textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                @if(auth()->check() && $group->hasModerator(auth()->user()))
                    <div class="mb-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $announcement->is_pinned) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-neutral-700 dark:text-neutral-300">Metti in evidenza (pin)</span>
                        </label>
                    </div>
                @endif
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-6 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700">
                        Salva Modifiche
                    </button>
                    <a href="{{ route('groups.announcements.show', [$group, $announcement]) }}" class="flex-1 px-6 py-3 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-xl font-semibold hover:bg-neutral-300 dark:hover:bg-neutral-600 text-center">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

