<div class="p-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-black text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
            {{ __('admin.sections.carousels.title') }}
        </h1>
        <p class="text-lg text-neutral-600 dark:text-neutral-400">{{ __('admin.sections.carousels.description') }}</p>
    </div>

    {{-- Flash Messages --}}
    @if(session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl">
            <p class="text-green-800 dark:text-green-400 font-semibold">{{ session('message') }}</p>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl">
            <p class="text-red-800 dark:text-red-400 font-semibold">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Controls --}}
    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Search --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                    🔍 {{ __('common.search') }}
                </label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="{{ __('admin.sections.carousels.search_placeholder') }}"
                       class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
            </div>

            {{-- Add Button --}}
            <div class="flex items-end">
                <button wire:click="create" 
                        class="w-full px-5 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                    ➕ {{ __('admin.sections.carousels.add') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Carousels List --}}
    <div class="space-y-4">
        @forelse($carousels as $carousel)
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    {{-- Image Preview --}}
                    <div class="md:w-64 h-48 md:h-auto bg-neutral-100 dark:bg-neutral-900 flex items-center justify-center overflow-hidden">
                        @if($carousel->image_url || $carousel->content_image_url)
                            <img src="{{ $carousel->image_url ?? $carousel->content_image_url }}" 
                                 alt="{{ $carousel->display_title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="text-neutral-400 text-4xl">🖼️</div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2 flex-wrap">
                                    @if($carousel->content_type)
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                            {{ strtoupper($carousel->content_type) }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                            UPLOAD
                                        </span>
                                    @endif
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $carousel->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' }}">
                                        {{ $carousel->is_active ? __('admin.sections.carousels.status.active') : __('admin.sections.carousels.status.inactive') }}
                                    </span>
                                    <span class="text-xs text-neutral-500">{{ __('common.order') }}: {{ $carousel->order }}</span>
                                    @if($carousel->start_date || $carousel->end_date)
                                        <span class="text-xs text-neutral-500">
                                            @if($carousel->start_date)
                                                {{ __('admin.sections.carousels.form.start_date') }}: {{ $carousel->start_date->format('d/m/Y') }}
                                            @endif
                                            @if($carousel->end_date)
                                                - {{ __('admin.sections.carousels.form.end_date') }}: {{ $carousel->end_date->format('d/m/Y') }}
                                            @endif
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                                    {{ $carousel->display_title ?: __('admin.sections.carousels.no_carousels') }}
                                </h3>
                                @if($carousel->display_description)
                                    <p class="text-neutral-600 dark:text-neutral-400 line-clamp-2 mb-3">
                                        {{ \Illuminate\Support\Str::limit($carousel->display_description, 150) }}
                                    </p>
                                @endif
                                @if($carousel->display_url)
                                    <a href="{{ $carousel->display_url }}" 
                                       target="_blank"
                                       class="text-primary-600 dark:text-primary-400 hover:underline text-sm font-medium">
                                        {{ $carousel->link_text ?: $carousel->display_url }} →
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2 flex-wrap">
                            <button wire:click="edit({{ $carousel->id }})" 
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors text-sm">
                                ✏️ {{ __('admin.sections.carousels.actions.edit') }}
                            </button>
                            <button wire:click="toggleActive({{ $carousel->id }})" 
                                    class="px-4 py-2 {{ $carousel->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-bold rounded-xl transition-colors text-sm">
                                {{ $carousel->is_active ? '⏸️' : '▶️' }} {{ __('admin.sections.carousels.actions.toggle_active') }}
                            </button>
                            <button wire:click="delete({{ $carousel->id }})" 
                                    wire:confirm="{{ __('common.delete_confirm') }}"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-colors text-sm">
                                🗑️ {{ __('admin.sections.carousels.actions.delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">🎠</div>
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.sections.carousels.no_carousels') }}</h3>
                <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                    @if(!empty($search))
                        {{ __('common.no_results') }}
                    @else
                        {{ __('admin.sections.carousels.description') }}
                    @endif
                </p>
                <button wire:click="create" 
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                    ➕ {{ __('admin.sections.carousels.add') }}
                </button>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $carousels->links() }}
    </div>

    {{-- Create/Edit Modal --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" 
             x-data="{ show: @entangle('showModal') }"
             x-show="show"
             x-transition>
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
                 @click.away="$wire.closeModal()">
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">
                        {{ $isEditing ? __('admin.sections.carousels.edit') : __('admin.sections.carousels.create') }}
                    </h2>
                </div>

                <form wire:submit="save" class="p-6 space-y-6">
                    {{-- Content Type Selection --}}
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.sections.carousels.form.content_type') }} *
                        </label>
                        <select wire:model.live="content_type" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            <option value="">{{ __('admin.sections.carousels.form.content_type_upload') }}</option>
                            @foreach($this->availableContentTypes as $type => $label)
                                <option value="{{ $type }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('content_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Content Search (if content type selected) --}}
                    @if($content_type)
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.content_search') }}
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       wire:model.live.debounce.500ms="contentSearch"
                                       wire:keydown.enter.prevent="$wire.searchContent()"
                                       placeholder="{{ __('admin.sections.carousels.form.content_search_placeholder') }}"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                                @if($contentSearch && strlen($contentSearch) < 2)
                                    <p class="mt-2 text-sm text-yellow-600 dark:text-yellow-400">
                                        {{ __('admin.sections.carousels.form.min_chars', ['min' => 2]) }}
                                    </p>
                                @endif
                                @if(!empty($contentSearchResults))
                                    <div class="absolute z-50 w-full mt-2 bg-white dark:bg-neutral-800 rounded-xl shadow-xl border border-neutral-200 dark:border-neutral-700 max-h-60 overflow-y-auto">
                                        @foreach($contentSearchResults as $result)
                                            <button type="button"
                                                    wire:click="selectContent({{ $result['id'] }})"
                                                    class="w-full px-4 py-3 text-left hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors border-b border-neutral-100 dark:border-neutral-700 last:border-b-0">
                                                <div class="font-medium text-neutral-900 dark:text-white">{{ $result['title'] }}</div>
                                                <div class="text-xs text-neutral-500 uppercase">{{ $result['type'] }}</div>
                                            </button>
                                        @endforeach
                                    </div>
                                @elseif($contentSearch && strlen($contentSearch) >= 2 && empty($contentSearchResults))
                                    <div class="absolute z-50 w-full mt-2 bg-white dark:bg-neutral-800 rounded-xl shadow-xl border border-neutral-200 dark:border-neutral-700 p-4">
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400 text-center">
                                            {{ __('admin.sections.carousels.form.no_results') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            @if($content_id)
                                <p class="mt-2 text-sm text-green-600 dark:text-green-400">
                                    ✓ {{ __('admin.sections.carousels.form.content_selected') }}: ID {{ $content_id }}
                                </p>
                            @endif
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.title') }} @if(!$content_type) * @endif
                            </label>
                            <input type="text" 
                                   wire:model="title"
                                   placeholder="{{ __('admin.sections.carousels.form.title_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Order --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.order') }}
                            </label>
                            <input type="number" 
                                   wire:model="order"
                                   min="0"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('order') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.sections.carousels.form.description') }}
                        </label>
                        <textarea wire:model="description" 
                                  rows="4"
                                  placeholder="{{ __('admin.sections.carousels.form.description_placeholder') }}"
                                  class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium"></textarea>
                        @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Image Upload --}}
                    @if($content_type && $content_id)
                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="use_original_image"
                                       class="w-5 h-5 text-primary-600 border-neutral-300 rounded">
                                <span class="text-neutral-700 dark:text-neutral-300 font-medium">
                                    {{ __('admin.sections.carousels.form.use_original_image') }}
                                </span>
                            </label>
                        </div>
                    @endif

                    @if(!$use_original_image || !$content_type)
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.image') }} @if(!$content_type) * @endif
                            </label>
                            @if($existing_image)
                                <div class="mb-3">
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-2">{{ __('admin.sections.carousels.form.image_current') }}:</p>
                                    <img src="{{ filter_var($existing_image, FILTER_VALIDATE_URL) ? $existing_image : asset('storage/' . $existing_image) }}" 
                                         alt="Current image"
                                         class="w-32 h-32 object-cover rounded-xl border-2 border-neutral-300 dark:border-neutral-600">
                                </div>
                            @endif
                            <input type="file" 
                                   wire:model="image"
                                   accept="image/*"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            @if($image)
                                <p class="mt-2 text-sm text-green-600 dark:text-green-400">{{ __('admin.sections.carousels.form.image_upload') }}: {{ $image->getClientOriginalName() }}</p>
                            @endif
                        </div>
                    @endif

                    {{-- Video Upload (only for traditional upload) --}}
                    @if(!$content_type)
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.video') }}
                            </label>
                            @if($existing_video)
                                <div class="mb-3">
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-2">{{ __('admin.sections.carousels.form.video_current') }}:</p>
                                    <video src="{{ filter_var($existing_video, FILTER_VALIDATE_URL) ? $existing_video : asset('storage/' . $existing_video) }}" 
                                           controls
                                           class="w-full max-w-md rounded-xl border-2 border-neutral-300 dark:border-neutral-600">
                                    </video>
                                </div>
                            @endif
                            <input type="file" 
                                   wire:model="video"
                                   accept="video/*"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('video') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            @if($video)
                                <p class="mt-2 text-sm text-green-600 dark:text-green-400">{{ __('admin.sections.carousels.form.video_upload') }}: {{ $video->getClientOriginalName() }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Link URL --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.link_url') }}
                            </label>
                            <input type="url" 
                                   wire:model="link_url"
                                   placeholder="{{ __('admin.sections.carousels.form.link_url_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('link_url') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Link Text --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.link_text') }}
                            </label>
                            <input type="text" 
                                   wire:model="link_text"
                                   placeholder="{{ __('admin.sections.carousels.form.link_text_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('link_text') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Start Date --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.start_date') }}
                            </label>
                            <input type="date" 
                                   wire:model="start_date"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('start_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- End Date --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.end_date') }}
                            </label>
                            <input type="date" 
                                   wire:model="end_date"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('end_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Active Status --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.carousels.form.is_active') }}
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="is_active"
                                       class="w-5 h-5 text-primary-600 border-neutral-300 rounded">
                                <span class="text-neutral-700 dark:text-neutral-300">{{ __('admin.sections.carousels.status.active') }}</span>
                            </label>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex gap-3 justify-end pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <button type="button" 
                                wire:click="closeModal"
                                class="px-5 py-2.5 bg-neutral-600 hover:bg-neutral-700 text-white font-bold rounded-xl transition-colors">
                            {{ __('admin.sections.carousels.form.cancel') }}
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                            💾 {{ __('admin.sections.carousels.form.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
