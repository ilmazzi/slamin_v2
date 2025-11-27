<x-layouts.app>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Open the article modal automatically when page loads
            @if($article)
                Livewire.dispatch('openArticleModal', {{ $article->id }});
            @endif
        });
    </script>
    @endpush

    {{-- Article Modal Component --}}
    <livewire:articles.article-modal />

    {{-- Fallback content (shown while modal loads) --}}
    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-12">
        <div class="max-w-5xl mx-auto px-4">
            <div class="bg-white dark:bg-neutral-800 rounded-3xl p-8 shadow-xl border border-neutral-200 dark:border-neutral-700 text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-4 border-primary-600 mx-auto mb-4"></div>
                <p class="text-neutral-600 dark:text-neutral-400">{{ __('common.loading') }}</p>
            </div>
        </div>
    </div>
</x-layouts.app>

