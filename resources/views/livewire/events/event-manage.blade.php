<x-layouts.app>
    <div class="min-h-screen bg-[#fefaf3] dark:bg-neutral-900">
        
        {{-- Header --}}
        <div class="sticky top-0 z-40 bg-[#fefaf3] dark:bg-neutral-900 border-b border-[rgba(139,115,85,0.2)] dark:border-neutral-700 shadow-sm">
            <div class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('events.show', $event) }}" class="p-2 text-[#8b7355] hover:bg-[rgba(139,115,85,0.1)] rounded-lg">
                        <i class="ph ph-arrow-left text-xl"></i>
                    </a>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-lg font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                            {{ __('events.manage.title') }}
                        </h1>
                        <p class="text-xs text-[#8b7355] dark:text-neutral-400 truncate">{{ $event->title }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="px-4 py-6 space-y-4 max-w-2xl mx-auto">
            
            {{-- Event Info Card --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700">
                <div class="flex items-center gap-4">
                    @if($event->cover_image)
                        <img src="{{ Storage::url($event->cover_image) }}" class="w-20 h-20 rounded-xl object-cover">
                    @else
                        <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-[#b91c1c] to-[#991b1b] flex items-center justify-center">
                            <i class="ph ph-calendar-blank text-3xl text-white"></i>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h2 class="font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                            {{ $event->title }}
                        </h2>
                        <p class="text-sm text-[#8b7355] dark:text-neutral-400">
                            {{ $event->start_datetime->format('d M Y, H:i') }}
                        </p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs px-2 py-0.5 rounded-full 
                                {{ $event->status === 'published' ? 'bg-green-100 text-green-700' : 
                                   ($event->status === 'draft' ? 'bg-gray-100 text-gray-700' : 
                                   ($event->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                                {{ ucfirst($event->status) }}
                            </span>
                            <span class="text-xs text-[#8b7355]">
                                <i class="ph ph-users"></i> {{ $event->participants()->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="space-y-3">
                <h3 class="text-xs font-black uppercase tracking-widest text-[#8b7355] dark:text-neutral-500">
                    {{ __('events.manage.quick_actions') }}
                </h3>
                
                {{-- Edit Event --}}
                <a href="{{ route('events.edit', $event) }}" 
                   class="flex items-center gap-4 bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 hover:border-[#b91c1c] transition-all">
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <i class="ph ph-pencil-simple text-2xl text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-[#1a1a1a] dark:text-white">{{ __('events.manage.edit_event') }}</div>
                        <div class="text-xs text-[#8b7355] dark:text-neutral-400">{{ __('events.manage.edit_event_desc') }}</div>
                    </div>
                    <i class="ph ph-caret-right text-[#8b7355]"></i>
                </a>

                {{-- Scoring (only for Poetry Slam) --}}
                @if($event->category === \App\Models\Event::CATEGORY_POETRY_SLAM)
                    <a href="{{ route('events.scoring.scores', $event) }}" 
                       class="flex items-center gap-4 bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 hover:border-[#b91c1c] transition-all">
                        <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <i class="ph ph-trophy text-2xl text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-[#1a1a1a] dark:text-white">{{ __('events.manage.scoring') }}</div>
                            <div class="text-xs text-[#8b7355] dark:text-neutral-400">{{ __('events.manage.scoring_desc') }}</div>
                        </div>
                        <i class="ph ph-caret-right text-[#8b7355]"></i>
                    </a>
                @endif

                {{-- Participants --}}
                <a href="{{ route('events.scoring.participants', $event) }}" 
                   class="flex items-center gap-4 bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 hover:border-[#b91c1c] transition-all">
                    <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <i class="ph ph-users text-2xl text-purple-600"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-[#1a1a1a] dark:text-white">{{ __('events.manage.participants') }}</div>
                        <div class="text-xs text-[#8b7355] dark:text-neutral-400">{{ $event->participants()->count() }} {{ __('events.manage.registered') }}</div>
                    </div>
                    <i class="ph ph-caret-right text-[#8b7355]"></i>
                </a>

                {{-- View Event --}}
                <a href="{{ route('events.show', $event) }}" 
                   class="flex items-center gap-4 bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 hover:border-[#b91c1c] transition-all">
                    <div class="w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <i class="ph ph-eye text-2xl text-amber-600"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-[#1a1a1a] dark:text-white">{{ __('events.manage.view_event') }}</div>
                        <div class="text-xs text-[#8b7355] dark:text-neutral-400">{{ __('events.manage.view_event_desc') }}</div>
                    </div>
                    <i class="ph ph-caret-right text-[#8b7355]"></i>
                </a>
            </div>

            {{-- Danger Zone --}}
            <div class="space-y-3 mt-8">
                <h3 class="text-xs font-black uppercase tracking-widest text-red-600">
                    {{ __('events.manage.danger_zone') }}
                </h3>
                
                <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border-2 border-red-200 dark:border-red-800">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center flex-shrink-0">
                            <i class="ph ph-trash text-2xl text-red-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-red-700 dark:text-red-400">{{ __('events.manage.delete_event') }}</div>
                            <p class="text-xs text-red-600 dark:text-red-400/80 mt-1">
                                {{ __('events.manage.delete_event_warning') }}
                            </p>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="mt-3"
                                  onsubmit="return confirm('{{ __('events.manage.delete_confirm') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold text-sm transition-all">
                                    <i class="ph ph-trash"></i> {{ __('events.manage.delete_button') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

