<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900" wire:poll.30s>
    
    {{-- Header --}}
    <div class="bg-gradient-to-r from-accent-600 to-primary-600 dark:from-accent-700 dark:to-primary-700 py-8 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('gigs.show', $application->gig) }}" 
                           class="text-white/80 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </a>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">
                            Workspace Collaborativo
                        </h1>
                    </div>
                    <p class="text-white/90 text-sm">
                        Poesia: <span class="font-semibold">"{{ $application->gig->poem->title }}"</span>
                        → {{ strtoupper($application->gig->target_language) }}
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-white font-semibold">
                        Versione {{ $translation->version }}
                    </div>
                    <div class="px-4 py-2 rounded-lg font-semibold
                        {{ $translation->status === 'draft' ? 'bg-yellow-500/20 text-yellow-100' : '' }}
                        {{ $translation->status === 'in_review' ? 'bg-blue-500/20 text-blue-100' : '' }}
                        {{ $translation->status === 'approved' ? 'bg-green-500/20 text-green-100' : '' }}">
                        {{ ucfirst($translation->status) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid lg:grid-cols-3 gap-8">
            
            {{-- Left: Original Poem --}}
            <div class="lg:col-span-1">
                <div class="sticky top-6 bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Testo Originale
                    </h2>
                    <div class="prose prose-sm dark:prose-invert max-w-none">
                        <h3 class="font-poem text-lg">"{{ $application->gig->poem->title }}"</h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                            di {{ $application->gig->poem->user->name }}
                        </p>
                        <div class="font-poem text-neutral-700 dark:text-neutral-300 leading-relaxed">
                            {!! $application->gig->poem->content !!}
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Center: Translation Editor --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Editor Card --}}
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Traduzione
                            </h2>
                            <button wire:click="$toggle('showVersionHistory')" 
                                    class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Storico ({{ $versions->count() }})
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        {{-- Editor Textarea with Selection --}}
                        <div x-data="{ 
                            handleSelection() {
                                const textarea = $refs.editor;
                                const start = textarea.selectionStart;
                                const end = textarea.selectionEnd;
                                const selectedText = textarea.value.substring(start, end);
                                
                                if (selectedText.length > 0) {
                                    $wire.call('handleTextSelection', start, end, selectedText);
                                }
                            }
                        }">
                            <textarea x-ref="editor"
                                      wire:model.live.debounce.500ms="translatedText"
                                      @mouseup="handleSelection()"
                                      rows="20"
                                      placeholder="Scrivi qui la traduzione..."
                                      class="w-full px-4 py-3 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg 
                                             bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white
                                             focus:border-accent-500 focus:ring-4 focus:ring-accent-500/20
                                             font-poem text-lg leading-relaxed resize-none"
                                      {{ $translation->status === 'approved' ? 'disabled' : '' }}></textarea>
                        </div>
                        
                        {{-- Actions --}}
                        <div class="flex flex-wrap gap-3 mt-4">
                            @if($translation->status !== 'approved')
                                <button wire:click="saveTranslation" 
                                        wire:loading.attr="disabled"
                                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 disabled:bg-neutral-400 text-white font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl">
                                    <span wire:loading.remove>💾 Salva Versione</span>
                                    <span wire:loading>Salvataggio...</span>
                                </button>
                                
                                @if($isTranslator && $translation->status === 'draft')
                                    <button wire:click="submitForReview" 
                                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all">
                                        📤 Invia per Revisione
                                    </button>
                                @endif
                                
                                @if($isAuthor && $translation->status === 'in_review')
                                    <button wire:click="approveTranslation" 
                                            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all shadow-lg">
                                        ✅ Approva Traduzione
                                    </button>
                                @endif
                            @else
                                <div class="flex-1 px-6 py-3 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-lg font-semibold text-center">
                                    ✅ Traduzione Approvata
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- Comments Section --}}
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        Commenti ({{ $comments->count() }})
                    </h3>
                    
                    {{-- New Comment Form (when text selected) --}}
                    @if($showCommentForm && $translation->status !== 'approved')
                        <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 border-2 border-yellow-300 dark:border-yellow-700 rounded-lg">
                            <p class="text-sm text-neutral-700 dark:text-neutral-300 mb-2">
                                <span class="font-semibold">Testo selezionato:</span> 
                                <span class="italic">"{{ \Str::limit($selectedText, 100) }}"</span>
                            </p>
                            <textarea wire:model="newComment"
                                      rows="3"
                                      placeholder="Scrivi il tuo commento..."
                                      class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white mb-2"></textarea>
                            <div class="flex gap-2">
                                <button wire:click="addComment" 
                                        class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg">
                                    💬 Aggiungi Commento
                                </button>
                                <button wire:click="$set('showCommentForm', false)" 
                                        class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg">
                                    Annulla
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Comments List --}}
                    <div class="space-y-4">
                        @forelse($comments as $comment)
                            <div class="p-4 rounded-lg {{ $comment->is_resolved ? 'bg-neutral-100 dark:bg-neutral-900 opacity-60' : 'bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-300 dark:border-yellow-700' }}">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($comment->user, 64) }}" 
                                             class="w-8 h-8 rounded-full">
                                        <div>
                                            <div class="font-semibold text-neutral-900 dark:text-white text-sm">
                                                {{ $comment->user->name }}
                                            </div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    @if(!$comment->is_resolved && $translation->status !== 'approved')
                                        <button wire:click="resolveComment({{ $comment->id }})" 
                                                class="text-xs px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-full font-semibold">
                                            ✓ Risolvi
                                        </button>
                                    @endif
                                </div>
                                
                                @if($comment->highlighted_text)
                                    <div class="mb-2 p-2 bg-white dark:bg-neutral-800 rounded border-l-4 border-yellow-500">
                                        <p class="text-xs text-neutral-600 dark:text-neutral-400 italic">
                                            "{{ $comment->highlighted_text }}"
                                        </p>
                                    </div>
                                @endif
                                
                                <p class="text-sm text-neutral-700 dark:text-neutral-300">
                                    {{ $comment->comment }}
                                </p>
                                
                                @if($comment->is_resolved)
                                    <div class="mt-2 text-xs text-green-600 dark:text-green-400">
                                        ✓ Risolto da {{ $comment->resolver->name }} {{ $comment->resolved_at->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8 text-neutral-500 dark:text-neutral-400">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                <p>Nessun commento ancora</p>
                                <p class="text-sm mt-1">Seleziona del testo nell'editor per aggiungere un commento</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                {{-- Version History (Collapsible) --}}
                @if($showVersionHistory)
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Storico Versioni
                            </h3>
                            <button wire:click="$toggle('showVersionHistory')" 
                                    class="text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            @foreach($versions as $version)
                                <div class="p-4 border border-neutral-200 dark:border-neutral-700 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-bold">
                                                v{{ $version->version_number }}
                                            </span>
                                            <span class="text-sm font-semibold text-neutral-900 dark:text-white">
                                                {{ $version->modifier->name }}
                                            </span>
                                        </div>
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                            {{ $version->created_at->format('d M Y H:i') }}
                                        </span>
                                    </div>
                                    @if($version->changes_summary)
                                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                            {{ $version->changes_summary }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
    
    {{-- Success/Error Messages --}}
    @if(session()->has('success'))
        <div x-data="{ show: true }" 
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-6 right-6 z-50 px-6 py-4 bg-green-600 text-white rounded-lg shadow-2xl">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-6 right-6 z-50 px-6 py-4 bg-red-600 text-white rounded-lg shadow-2xl">
            {{ session('error') }}
        </div>
    @endif
</div>
