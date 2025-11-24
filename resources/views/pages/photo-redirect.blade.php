<x-layouts.app>
    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 flex items-center justify-center">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600 mx-auto mb-4"></div>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('common.loading') }}...</p>
        </div>
    </div>

    <script>
        // Auto-open photo modal when page loads
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.dispatch('openPhotoModal', { photoId: {{ $photo->id }} });
        });
    </script>
</x-layouts.app>

