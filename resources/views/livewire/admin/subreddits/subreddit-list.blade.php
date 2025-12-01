<div class="p-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-black text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
            {{ __('admin.sections.subreddits.title') }}
        </h1>
        <p class="text-lg text-neutral-600 dark:text-neutral-400">{{ __('admin.sections.subreddits.description') }}</p>
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
                       placeholder="{{ __('admin.sections.subreddits.search_placeholder') }}"
                       class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
            </div>

            {{-- Add Button --}}
            <div class="flex items-end">
                <button wire:click="create" 
                        class="w-full px-5 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                    ➕ {{ __('admin.sections.subreddits.add') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Subreddits List --}}
    <div class="space-y-4">
        @forelse($subreddits as $subreddit)
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    {{-- Banner/Icon Preview --}}
                    <div class="md:w-64 h-48 md:h-auto bg-neutral-100 dark:bg-neutral-900 flex items-center justify-center overflow-hidden"
                         style="background-color: {{ $subreddit->color ?? '#059669' }};">
                        @if($subreddit->banner)
                            <img src="{{ Storage::url($subreddit->banner) }}" 
                                 alt="{{ $subreddit->name }}"
                                 class="w-full h-full object-cover">
                        @elseif($subreddit->icon)
                            <div class="text-6xl">{{ $subreddit->icon }}</div>
                        @else
                            <div class="text-neutral-400 text-4xl">💬</div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2 flex-wrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $subreddit->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' }}">
                                        {{ $subreddit->is_active ? __('admin.sections.subreddits.status.active') : __('admin.sections.subreddits.status.inactive') }}
                                    </span>
                                    @if($subreddit->is_private)
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                            🔒 {{ __('admin.sections.subreddits.private') }}
                                        </span>
                                    @endif
                                    <span class="text-xs text-neutral-500">
                                        r/{{ $subreddit->slug }}
                                    </span>
                                    <span class="text-xs text-neutral-500">
                                        {{ $subreddit->subscribers_count ?? 0 }} {{ __('admin.sections.subreddits.subscribers') }}
                                    </span>
                                    <span class="text-xs text-neutral-500">
                                        {{ $subreddit->posts_count ?? 0 }} {{ __('admin.sections.subreddits.posts') }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                                    {{ $subreddit->name }}
                                </h3>
                                @if($subreddit->description)
                                    <p class="text-neutral-600 dark:text-neutral-400 line-clamp-2 mb-3">
                                        {{ \Illuminate\Support\Str::limit($subreddit->description, 150) }}
                                    </p>
                                @endif
                                @if($subreddit->creator)
                                    <p class="text-sm text-neutral-500">
                                        {{ __('admin.sections.subreddits.created_by') }}: {{ $subreddit->creator->name }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2 flex-wrap">
                            <button wire:click="edit({{ $subreddit->id }})" 
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors text-sm">
                                ✏️ {{ __('admin.sections.subreddits.actions.edit') }}
                            </button>
                            <button wire:click="toggleActive({{ $subreddit->id }})" 
                                    class="px-4 py-2 {{ $subreddit->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-bold rounded-xl transition-colors text-sm">
                                {{ $subreddit->is_active ? '⏸️' : '▶️' }} {{ __('admin.sections.subreddits.actions.toggle_active') }}
                            </button>
                            <a href="{{ route('forum.subreddit.show', $subreddit->slug) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors text-sm">
                                👁️ {{ __('admin.sections.subreddits.actions.view') }}
                            </a>
                            <button wire:click="delete({{ $subreddit->id }})" 
                                    wire:confirm="{{ __('common.delete_confirm') }}"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-colors text-sm">
                                🗑️ {{ __('admin.sections.subreddits.actions.delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">💬</div>
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.sections.subreddits.no_subreddits') }}</h3>
                <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                    @if(!empty($search))
                        {{ __('common.no_results') }}
                    @else
                        {{ __('admin.sections.subreddits.description') }}
                    @endif
                </p>
                <button wire:click="create" 
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                    ➕ {{ __('admin.sections.subreddits.add') }}
                </button>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $subreddits->links() }}
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
                        {{ $isEditing ? __('admin.sections.subreddits.edit') : __('admin.sections.subreddits.create') }}
                    </h2>
                </div>

                <form wire:submit="save" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.subreddits.form.name') }} *
                            </label>
                            <input type="text" 
                                   wire:model="name"
                                   placeholder="{{ __('admin.sections.subreddits.form.name_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.subreddits.form.slug') }} *
                            </label>
                            <input type="text" 
                                   wire:model="slug"
                                   placeholder="{{ __('admin.sections.subreddits.form.slug_placeholder') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('slug') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.sections.subreddits.form.description') }}
                        </label>
                        <textarea wire:model="description" 
                                  rows="4"
                                  placeholder="{{ __('admin.sections.subreddits.form.description_placeholder') }}"
                                  class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium"></textarea>
                        @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Rules --}}
                    <div>
                        <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.sections.subreddits.form.rules') }}
                        </label>
                        <textarea wire:model="rules" 
                                  rows="6"
                                  placeholder="{{ __('admin.sections.subreddits.form.rules_placeholder') }}"
                                  class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium"></textarea>
                        @error('rules') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Icon --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.subreddits.form.icon') }}
                            </label>
                            <input type="text" 
                                   wire:model="icon"
                                   placeholder="💬"
                                   maxlength="2"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium text-2xl text-center">
                            @error('icon') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Color --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.subreddits.form.color') }}
                            </label>
                            <input type="color" 
                                   wire:model="color"
                                   class="w-full h-12 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 cursor-pointer">
                            @error('color') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Banner --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.subreddits.form.banner') }}
                            </label>
                            @if($existing_banner)
                                <div class="mb-3">
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-2">{{ __('admin.sections.subreddits.form.banner_current') }}:</p>
                                    <img src="{{ Storage::url($existing_banner) }}" 
                                         alt="Current banner"
                                         class="w-32 h-32 object-cover rounded-xl border-2 border-neutral-300 dark:border-neutral-600">
                                </div>
                            @endif
                            <input type="file" 
                                   wire:model="banner"
                                   accept="image/*"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                            @error('banner') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            @if($banner)
                                <p class="mt-2 text-sm text-green-600 dark:text-green-400">{{ __('admin.sections.subreddits.form.banner_upload') }}: {{ $banner->getClientOriginalName() }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Active Status --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.subreddits.form.is_active') }}
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="is_active"
                                       class="w-5 h-5 text-primary-600 border-neutral-300 rounded">
                                <span class="text-neutral-700 dark:text-neutral-300">{{ __('admin.sections.subreddits.status.active') }}</span>
                            </label>
                        </div>

                        {{-- Private Status --}}
                        <div>
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.sections.subreddits.form.is_private') }}
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="is_private"
                                       class="w-5 h-5 text-primary-600 border-neutral-300 rounded">
                                <span class="text-neutral-700 dark:text-neutral-300">{{ __('admin.sections.subreddits.private') }}</span>
                            </label>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex gap-3 justify-end pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <button type="button" 
                                wire:click="closeModal"
                                class="px-5 py-2.5 bg-neutral-600 hover:bg-neutral-700 text-white font-bold rounded-xl transition-colors">
                            {{ __('admin.sections.subreddits.form.cancel') }}
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                            💾 {{ __('admin.sections.subreddits.form.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
