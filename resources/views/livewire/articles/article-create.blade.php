@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Quill Editor - Stile Redazione */
    .ql-container {
        font-family: 'Crimson Pro', Georgia, serif !important;
        font-size: 1.125rem !important;
        line-height: 1.8 !important;
    }
    
    .ql-editor {
        min-height: 400px !important;
        padding: 2rem !important;
        color: #1c1917 !important;
    }
    
    .ql-toolbar {
        background: linear-gradient(to bottom, #f5f5f4, #e7e5e4) !important;
        border: none !important;
        border-bottom: 2px solid #d1d5db !important;
        border-radius: 0.5rem 0.5rem 0 0 !important;
        padding: 1rem !important;
    }
</style>
@endpush

<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                {{ __('articles.create.title') }}
            </h1>
            <p class="text-neutral-600 dark:text-neutral-400">
                {{ __('articles.create.subtitle') }}
            </p>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div x-data="{ show: true }" 
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 class="mb-6 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-semibold">{{ session('message') }}</span>
                <button @click="show = false" class="ml-auto hover:bg-white/20 rounded p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" 
                 x-show="show"
                 x-init="setTimeout(() => show = false, 8000)"
                 class="mb-6 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold">{{ session('error') }}</span>
                <button @click="show = false" class="ml-auto hover:bg-white/20 rounded p-1 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('articles.create.title_label') }} *
                </label>
                <input type="text" 
                       id="title"
                       wire:model="title"
                       class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all"
                       placeholder="{{ __('articles.create.title_placeholder') }}">
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Excerpt --}}
            <div>
                <label for="excerpt" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('articles.create.excerpt_label') }}
                </label>
                <textarea id="excerpt"
                          wire:model="excerpt"
                          rows="3"
                          class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all resize-none"
                          placeholder="{{ __('articles.create.excerpt_placeholder') }}"></textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <label for="category_id" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('articles.create.category_label') }}
                </label>
                <select id="category_id"
                        wire:model="category_id"
                        class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                    <option value="">{{ __('articles.create.no_category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Featured Image --}}
            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('articles.create.featured_image_label') }}
                </label>
                
                <input type="file" 
                       wire:model="featured_image"
                       accept="image/*"
                       class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                @if($featured_image)
                    <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                        {{ __('articles.create.image_uploaded') }}: {{ $featured_image->getClientOriginalName() }}
                    </p>
                @endif
            </div>

            {{-- Content Editor --}}
            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('articles.create.content_label') }} *
                </label>
                <div wire:ignore class="bg-white dark:bg-neutral-800 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <div id="quill-editor" style="min-height: 400px;"></div>
                </div>
                <textarea wire:model="content" id="quill-content" style="display:none;">{{ $content }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status and Visibility --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('articles.create.status_label') }} *
                    </label>
                    <select id="status"
                            wire:model="status"
                            class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        <option value="draft">{{ __('articles.create.status_draft') }}</option>
                        <option value="published">{{ __('articles.create.status_published') }}</option>
                        <option value="archived">{{ __('articles.create.status_archived') }}</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('articles.create.published_at_label') }}
                    </label>
                    <input type="datetime-local" 
                           id="published_at"
                           wire:model="published_at"
                           class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Is Public --}}
            <div class="flex items-center gap-3">
                <input type="checkbox" 
                       id="is_public"
                       wire:model="is_public"
                       class="w-5 h-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                <label for="is_public" class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                    {{ __('articles.create.is_public_label') }}
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <a href="{{ route('articles.index') }}" 
                   class="px-6 py-3 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl font-semibold transition-all">
                    {{ __('articles.create.cancel') }}
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-all hover:scale-105 shadow-lg">
                    {{ __('articles.create.create_button') }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editorDiv = document.getElementById('quill-editor');
        const textarea = document.getElementById('quill-content');
        
        if (!editorDiv || !textarea) {
            console.error('Quill elements not found');
            return;
        }
        
        const initialContent = textarea.value || '';
        
        const quill = new Quill(editorDiv, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });
        
        quill.root.innerHTML = initialContent;
        
        // Sync Quill → Textarea → Livewire
        quill.on('text-change', function() {
            textarea.value = quill.root.innerHTML;
            textarea.dispatchEvent(new Event('input', { bubbles: true }));
        });
        
        // Sync Livewire → Quill (when content changes from server)
        Livewire.on('content-updated', (content) => {
            if (quill.root.innerHTML !== content) {
                quill.root.innerHTML = content;
            }
        });
        
        console.log('✅ Quill initialized for article creation');
    });
</script>
@endpush

